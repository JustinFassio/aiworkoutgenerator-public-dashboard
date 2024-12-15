/**
 * Nutrition Logger Component
 */
(function() {
    // Only define the component if it hasn't been defined yet
    if (typeof window.NutritionLoggerComponent === 'undefined') {
        window.NutritionLoggerComponent = class {
            constructor() {
                this.form = document.getElementById('meal-log-form');
                this.foodSearch = document.getElementById('food-search');
                this.selectedFoodsList = document.getElementById('selected-foods-list');
                this.manageFoodsButton = document.getElementById('manage-foods-button');
                this.foodManagerModal = document.getElementById('food-manager-modal');
                this.selectedFoods = new Map();
                
                this.init();
            }

            init() {
                if (this.form) {
                    this.form.addEventListener('submit', (e) => this.handleFormSubmit(e));
                }

                if (this.foodSearch) {
                    $(this.foodSearch).autocomplete({
                        source: (request, response) => this.handleFoodSearch(request, response),
                        minLength: 2,
                        select: (event, ui) => this.handleFoodSelect(event, ui)
                    });
                }

                if (this.manageFoodsButton) {
                    this.manageFoodsButton.addEventListener('click', () => this.showFoodManager());
                }

                if (this.foodManagerModal) {
                    const closeButton = this.foodManagerModal.querySelector('.close-modal');
                    if (closeButton) {
                        closeButton.addEventListener('click', () => this.hideFoodManager());
                    }
                }

                // Event delegation for remove buttons
                if (this.selectedFoodsList) {
                    this.selectedFoodsList.addEventListener('click', (e) => {
                        if (e.target.closest('.remove-food')) {
                            const foodItem = e.target.closest('.food-item');
                            if (foodItem) {
                                const foodId = foodItem.dataset.foodId;
                                this.removeFood(foodId);
                            }
                        }
                    });

                    this.selectedFoodsList.addEventListener('change', (e) => {
                        if (e.target.matches('input[type="number"]')) {
                            this.updateServings(e.target);
                        }
                    });
                }
            }

            handleFoodSearch(request, response) {
                fetch(`${nutritionLoggerData.ajaxurl}?action=search_foods&nonce=${nutritionLoggerData.nonce}&query=${request.term}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            response(data.data.map(food => ({
                                label: `${food.name} (${food.serving_size})`,
                                value: food.name,
                                food: food
                            })));
                        }
                    })
                    .catch(error => {
                        console.error('Error searching foods:', error);
                        response([]);
                    });
            }

            handleFoodSelect(event, ui) {
                event.preventDefault();
                this.foodSearch.value = '';
                this.addFood(ui.item.food);
                return false;
            }

            addFood(food) {
                if (this.selectedFoods.has(food.id)) {
                    const existingServings = parseFloat(this.selectedFoods.get(food.id).servings);
                    this.updateFoodServings(food.id, existingServings + 1);
                    return;
                }

                const foodData = {
                    ...food,
                    servings: 1,
                    totalCalories: food.calories,
                    totalProtein: food.protein,
                    totalCarbs: food.carbs,
                    totalFat: food.fat
                };

                this.selectedFoods.set(food.id, foodData);
                this.renderSelectedFoods();
                this.updateMealTotals();
            }

            removeFood(foodId) {
                this.selectedFoods.delete(foodId);
                this.renderSelectedFoods();
                this.updateMealTotals();
            }

            updateServings(input) {
                const foodItem = input.closest('.food-item');
                const foodId = foodItem.dataset.foodId;
                const servings = parseFloat(input.value) || 0;

                this.updateFoodServings(foodId, servings);
            }

            updateFoodServings(foodId, servings) {
                const food = this.selectedFoods.get(foodId);
                if (!food) return;

                food.servings = servings;
                food.totalCalories = food.calories * servings;
                food.totalProtein = food.protein * servings;
                food.totalCarbs = food.carbs * servings;
                food.totalFat = food.fat * servings;

                this.selectedFoods.set(foodId, food);
                this.renderSelectedFoods();
                this.updateMealTotals();
            }

            renderSelectedFoods() {
                if (!this.selectedFoodsList) return;

                this.selectedFoodsList.innerHTML = Array.from(this.selectedFoods.values())
                    .map(food => `
                        <div class="food-item" data-food-id="${food.id}">
                            <div class="food-col">${this.escapeHtml(food.name)}</div>
                            <div class="food-col">${this.escapeHtml(food.serving_size)}</div>
                            <div class="food-col">
                                <input type="number" 
                                       value="${food.servings}" 
                                       min="0.1" 
                                       step="0.1" 
                                       class="servings-input">
                            </div>
                            <div class="food-col">${Math.round(food.totalCalories)}</div>
                            <div class="food-col">${food.totalProtein.toFixed(1)}g</div>
                            <div class="food-col">${food.totalCarbs.toFixed(1)}g</div>
                            <div class="food-col">${food.totalFat.toFixed(1)}g</div>
                            <div class="food-col actions">
                                <button type="button" class="remove-food danger-button" title="${nutritionLoggerData.strings.remove}">
                                    <span class="dashicons dashicons-trash"></span>
                                </button>
                            </div>
                        </div>
                    `)
                    .join('');
            }

            updateMealTotals() {
                const totals = Array.from(this.selectedFoods.values()).reduce((acc, food) => {
                    acc.calories += food.totalCalories;
                    acc.protein += food.totalProtein;
                    acc.carbs += food.totalCarbs;
                    acc.fat += food.totalFat;
                    return acc;
                }, { calories: 0, protein: 0, carbs: 0, fat: 0 });

                document.getElementById('total-calories').textContent = Math.round(totals.calories);
                document.getElementById('total-protein').textContent = totals.protein.toFixed(1);
                document.getElementById('total-carbs').textContent = totals.carbs.toFixed(1);
                document.getElementById('total-fat').textContent = totals.fat.toFixed(1);
            }

            handleFormSubmit(e) {
                e.preventDefault();

                if (this.selectedFoods.size === 0) {
                    window.athleteDashboard.showNotification(nutritionLoggerData.strings.noFoods, 'error');
                    return;
                }

                const formData = new FormData(this.form);
                formData.append('action', 'log_meal');
                formData.append('nonce', nutritionLoggerData.nonce);
                formData.append('foods', JSON.stringify(Array.from(this.selectedFoods.values())));

                this.form.classList.add('loading');
                fetch(nutritionLoggerData.ajaxurl, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.athleteDashboard.showNotification(data.data.message, 'success');
                        this.resetForm();
                        this.loadMealHistory();
                    } else {
                        window.athleteDashboard.showNotification(data.data, 'error');
                    }
                })
                .catch(error => {
                    window.athleteDashboard.showNotification(nutritionLoggerData.strings.saveError, 'error');
                })
                .finally(() => {
                    this.form.classList.remove('loading');
                });
            }

            resetForm() {
                this.form.reset();
                this.selectedFoods.clear();
                this.renderSelectedFoods();
                this.updateMealTotals();
                this.form.querySelector('#meal-date').value = new Date().toISOString().split('T')[0];
            }

            loadMealHistory() {
                const historyList = document.getElementById('meal-history-list');
                if (!historyList) return;

                fetch(`${nutritionLoggerData.ajaxurl}?action=get_meal_history&nonce=${nutritionLoggerData.nonce}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.renderMealHistory(data.data);
                        }
                    })
                    .catch(error => {
                        console.error('Error loading meal history:', error);
                    });
            }

            renderMealHistory(meals) {
                const historyList = document.getElementById('meal-history-list');
                if (!historyList) return;

                if (!meals.length) {
                    historyList.innerHTML = '<p class="no-meals">No meals logged yet.</p>';
                    return;
                }

                historyList.innerHTML = meals.map(meal => `
                    <div class="meal-history-item">
                        <div class="meal-history-header">
                            <h4>${this.escapeHtml(meal.title)}</h4>
                            <span class="meal-date">${meal.date}</span>
                        </div>
                        <div class="meal-history-details">
                            <span class="meal-type">${this.escapeHtml(meal.type)}</span>
                            <span class="meal-macros">
                                ${meal.calories} cal | 
                                P: ${meal.protein}g | 
                                C: ${meal.carbs}g | 
                                F: ${meal.fat}g
                            </span>
                        </div>
                        ${this.renderMealFoods(meal.foods)}
                        ${meal.notes ? `
                            <div class="meal-notes">
                                ${this.escapeHtml(meal.notes)}
                            </div>
                        ` : ''}
                    </div>
                `).join('');
            }

            renderMealFoods(foods) {
                if (!foods || !foods.length) return '';

                return `
                    <div class="meal-foods">
                        <h5>Foods:</h5>
                        <ul>
                            ${foods.map(food => `
                                <li>
                                    ${this.escapeHtml(food.name)} - 
                                    ${food.servings} × ${this.escapeHtml(food.serving_size)}
                                    <small>
                                        (${Math.round(food.totalCalories)} cal | 
                                        P: ${food.totalProtein.toFixed(1)}g | 
                                        C: ${food.totalCarbs.toFixed(1)}g | 
                                        F: ${food.totalFat.toFixed(1)}g)
                                    </small>
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                `;
            }

            showFoodManager() {
                if (this.foodManagerModal) {
                    this.foodManagerModal.style.display = 'block';
                }
            }

            hideFoodManager() {
                if (this.foodManagerModal) {
                    this.foodManagerModal.style.display = 'none';
                }
            }

            escapeHtml(str) {
                const div = document.createElement('div');
                div.textContent = str;
                return div.innerHTML;
            }
        }
    }

    // Initialize when document is ready
    if (typeof window.nutritionLogger === 'undefined') {
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof window.NutritionLoggerComponent !== 'undefined') {
                window.nutritionLogger = new window.NutritionLoggerComponent();
            }
        });
    }
})(); 