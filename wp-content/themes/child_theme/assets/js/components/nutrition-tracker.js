/**
 * Nutrition Tracker Component
 */
(function() {
    // Only define the component if it hasn't been defined yet
    if (typeof window.NutritionTrackerComponent === 'undefined') {
        window.NutritionTrackerComponent = class {
            constructor() {
                this.form = document.getElementById('nutrition-goals-form');
                this.dateInput = document.getElementById('nutrition-date');
                this.macroChart = null;
                this.caloriesChart = null;
                this.init();
            }

            init() {
                if (this.form) {
                    this.form.addEventListener('submit', (e) => this.handleGoalsSubmit(e));
                }
                if (this.dateInput) {
                    this.dateInput.addEventListener('change', () => this.loadDailyNutrition());
                }

                // Only initialize charts if we have at least one of the chart canvases
                if (document.getElementById('macro-distribution-chart') || document.getElementById('weekly-calories-chart')) {
                    this.initializeCharts();
                }

                // Only load nutrition data if we have the date input
                if (this.dateInput) {
                    this.loadDailyNutrition();
                }
            }

            initializeCharts() {
                // Initialize macro distribution chart
                const macroCanvas = document.getElementById('macro-distribution-chart');
                if (macroCanvas) {
                    try {
                        const macroCtx = macroCanvas.getContext('2d');
                        this.macroChart = new Chart(macroCtx, {
                            type: 'doughnut',
                            data: {
                                labels: ['Protein', 'Carbs', 'Fat'],
                                datasets: [{
                                    data: [0, 0, 0],
                                    backgroundColor: [
                                        '#FF6384',
                                        '#36A2EB',
                                        '#FFCE56'
                                    ]
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    },
                                    title: {
                                        display: true,
                                        text: 'Macro Distribution'
                                    }
                                }
                            }
                        });
                    } catch (error) {
                        console.warn('Failed to initialize macro chart:', error);
                    }
                }

                // Initialize weekly calories chart
                const caloriesCanvas = document.getElementById('weekly-calories-chart');
                if (caloriesCanvas) {
                    try {
                        const caloriesCtx = caloriesCanvas.getContext('2d');
                        this.caloriesChart = new Chart(caloriesCtx, {
                            type: 'line',
                            data: {
                                labels: [],
                                datasets: [{
                                    label: 'Calories',
                                    data: [],
                                    borderColor: '#36A2EB',
                                    tension: 0.4
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        type: 'time',
                                        time: {
                                            unit: 'day',
                                            displayFormats: {
                                                day: 'MMM D'
                                            }
                                        },
                                        title: {
                                            display: true,
                                            text: 'Date'
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Calories'
                                        }
                                    }
                                },
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Weekly Calories'
                                    }
                                }
                            }
                        });
                    } catch (error) {
                        console.warn('Failed to initialize calories chart:', error);
                    }
                }
            }

            handleGoalsSubmit(e) {
                e.preventDefault();
                const formData = new FormData(this.form);
                formData.append('action', 'save_nutrition_goals');
                formData.append('nonce', nutritionTrackerData.nonce);

                this.form.classList.add('loading');
                fetch(nutritionTrackerData.ajaxurl, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.athleteDashboard.showNotification(data.data.message, 'success');
                        this.updateProgressBars(data.data.goals);
                    } else {
                        window.athleteDashboard.showNotification(data.data, 'error');
                    }
                })
                .catch(error => {
                    window.athleteDashboard.showNotification(nutritionTrackerData.strings.saveError, 'error');
                })
                .finally(() => {
                    this.form.classList.remove('loading');
                });
            }

            loadDailyNutrition() {
                const date = this.dateInput.value;
                
                fetch(`${nutritionTrackerData.ajaxurl}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'get_daily_nutrition',
                        nonce: nutritionTrackerData.nonce,
                        date: date
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.updateNutritionDisplay(data.data);
                    }
                })
                .catch(error => {
                    console.error('Error loading nutrition data:', error);
                });
            }

            updateNutritionDisplay(data) {
                this.updateProgressBars(data.goals, data.totals);
                this.updateMacroChart(data.totals);
                this.updateCaloriesChart(data.weekly_calories);
                this.renderMealsList(data.meals);
            }

            updateProgressBars(goals, totals = null) {
                const macros = ['calories', 'protein', 'carbs', 'fat'];
                macros.forEach(macro => {
                    const progressBar = document.querySelector(`#${macro}-progress .progress-fill`);
                    const currentSpan = document.querySelector(`#${macro}-progress .current`);
                    const goalSpan = document.querySelector(`#${macro}-progress .goal`);

                    if (progressBar && goalSpan) {
                        const goal = goals[macro];
                        goalSpan.textContent = macro === 'calories' ? goal : `${goal}g`;

                        if (totals) {
                            const current = totals[macro];
                            const percentage = Math.min(100, (current / goal) * 100);
                            progressBar.style.width = `${percentage}%`;
                            if (currentSpan) {
                                currentSpan.textContent = macro === 'calories' ? current : `${current}g`;
                            }
                        }
                    }
                });
            }

            updateMacroChart(totals) {
                if (!this.macroChart) return;
                
                const totalGrams = totals.protein + totals.carbs + totals.fat;
                if (totalGrams > 0) {
                    this.macroChart.data.datasets[0].data = [
                        totals.protein,
                        totals.carbs,
                        totals.fat
                    ];
                    this.macroChart.update();
                }
            }

            updateCaloriesChart(weeklyData) {
                if (!this.caloriesChart) return;
                
                if (weeklyData && weeklyData.length) {
                    this.caloriesChart.data.labels = weeklyData.map(d => d.date);
                    this.caloriesChart.data.datasets[0].data = weeklyData.map(d => ({
                        x: d.date,
                        y: d.calories
                    }));
                    this.caloriesChart.update();
                }
            }

            renderMealsList(meals) {
                const container = document.getElementById('daily-meals-list');
                if (!container) return;

                if (!meals.length) {
                    container.innerHTML = '<p class="no-meals">No meals logged for this date.</p>';
                    return;
                }

                container.innerHTML = meals.map(meal => `
                    <div class="meal-entry">
                        <div class="meal-header">
                            <h4>${this.escapeHtml(meal.title)}</h4>
                            <span class="meal-type">${this.escapeHtml(meal.type)}</span>
                        </div>
                        <div class="meal-macros">
                            <span class="calories">${meal.calories} cal</span>
                            <span class="protein">P: ${meal.protein}g</span>
                            <span class="carbs">C: ${meal.carbs}g</span>
                            <span class="fat">F: ${meal.fat}g</span>
                        </div>
                        ${this.renderFoodsList(meal.foods)}
                    </div>
                `).join('');
            }

            renderFoodsList(foods) {
                if (!foods || !foods.length) return '';

                return `
                    <div class="foods-list">
                        <h5>Foods:</h5>
                        <ul>
                            ${foods.map(food => `
                                <li>
                                    ${this.escapeHtml(food.name)} - 
                                    ${this.escapeHtml(food.serving_size)}
                                    <small>
                                        (${food.calories} cal | 
                                        P: ${food.protein}g | 
                                        C: ${food.carbs}g | 
                                        F: ${food.fat}g)
                                    </small>
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                `;
            }

            escapeHtml(str) {
                const div = document.createElement('div');
                div.textContent = str;
                return div.innerHTML;
            }
        }
    }

    // Initialize when document is ready
    if (typeof window.nutritionTracker === 'undefined') {
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof window.NutritionTrackerComponent !== 'undefined') {
                window.nutritionTracker = new window.NutritionTrackerComponent();
            }
        });
    }
})(); 