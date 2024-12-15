/**
 * Food Manager Component
 */
(function() {
    // Only define the component if it hasn't been defined yet
    if (typeof window.FoodManagerComponent === 'undefined') {
        window.FoodManagerComponent = class {
            constructor() {
                this.form = document.getElementById('food-form');
                this.formContainer = document.querySelector('.food-form-container');
                this.addButton = document.getElementById('add-food-button');
                this.foodsList = document.querySelector('.foods-list');
                
                this.init();
            }

            init() {
                // Add food button
                if (this.addButton) {
                    this.addButton.addEventListener('click', () => this.showForm());
                }

                // Form submission
                if (this.form) {
                    this.form.addEventListener('submit', (e) => this.handleFormSubmit(e));
                }

                // Cancel button
                const cancelButton = document.querySelector('.cancel-food-form');
                if (cancelButton) {
                    cancelButton.addEventListener('click', () => this.hideForm());
                }

                // Edit and delete buttons
                if (this.foodsList) {
                    this.foodsList.addEventListener('click', (e) => {
                        const target = e.target.closest('button');
                        if (!target) return;

                        const foodItem = target.closest('.food-item');
                        if (!foodItem) return;

                        const foodId = foodItem.dataset.foodId;

                        if (target.classList.contains('edit-food')) {
                            this.editFood(foodItem);
                        } else if (target.classList.contains('delete-food')) {
                            this.deleteFood(foodId);
                        }
                    });
                }
            }

            showForm(foodData = null) {
                this.formContainer.style.display = 'block';
                this.form.reset();

                if (foodData) {
                    // Populate form with food data
                    this.form.querySelector('#food-id').value = foodData.id;
                    this.form.querySelector('#food-name').value = foodData.name;
                    this.form.querySelector('#serving-size').value = foodData.serving_size;
                    this.form.querySelector('#calories').value = foodData.calories;
                    this.form.querySelector('#protein').value = foodData.protein;
                    this.form.querySelector('#carbs').value = foodData.carbs;
                    this.form.querySelector('#fat').value = foodData.fat;
                    this.form.querySelector('#is-public').checked = foodData.is_public === '1';
                } else {
                    this.form.querySelector('#food-id').value = '';
                }
            }

            hideForm() {
                this.formContainer.style.display = 'none';
                this.form.reset();
            }

            handleFormSubmit(e) {
                e.preventDefault();
                const formData = new FormData(this.form);
                formData.append('action', 'save_food');
                formData.append('nonce', foodManagerData.nonce);

                this.form.classList.add('loading');
                fetch(foodManagerData.ajaxurl, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.athleteDashboard.showNotification(data.data, 'success');
                        this.hideForm();
                        this.refreshFoodsList();
                    } else {
                        window.athleteDashboard.showNotification(data.data, 'error');
                    }
                })
                .catch(error => {
                    window.athleteDashboard.showNotification(foodManagerData.strings.saveError, 'error');
                })
                .finally(() => {
                    this.form.classList.remove('loading');
                });
            }

            editFood(foodItem) {
                const foodData = {
                    id: foodItem.dataset.foodId,
                    name: foodItem.querySelector('.food-col:nth-child(1)').textContent,
                    serving_size: foodItem.querySelector('.food-col:nth-child(2)').textContent,
                    calories: foodItem.querySelector('.food-col:nth-child(3)').textContent,
                    protein: foodItem.querySelector('.food-col:nth-child(4)').textContent.replace('g', ''),
                    carbs: foodItem.querySelector('.food-col:nth-child(5)').textContent.replace('g', ''),
                    fat: foodItem.querySelector('.food-col:nth-child(6)').textContent.replace('g', ''),
                    is_public: foodItem.dataset.isPublic || '0'
                };

                this.showForm(foodData);
            }

            deleteFood(foodId) {
                if (!confirm(foodManagerData.strings.confirmDelete)) {
                    return;
                }

                const formData = new FormData();
                formData.append('action', 'delete_food');
                formData.append('nonce', foodManagerData.nonce);
                formData.append('food_id', foodId);

                fetch(foodManagerData.ajaxurl, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.athleteDashboard.showNotification(data.data, 'success');
                        this.refreshFoodsList();
                    } else {
                        window.athleteDashboard.showNotification(data.data, 'error');
                    }
                })
                .catch(error => {
                    window.athleteDashboard.showNotification(foodManagerData.strings.deleteError, 'error');
                });
            }

            refreshFoodsList() {
                location.reload(); // For simplicity, we'll just reload the page
                // In a production environment, you might want to use AJAX to refresh just the foods list
            }
        }
    }

    // Initialize when document is ready
    if (typeof window.foodManager === 'undefined') {
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof window.FoodManagerComponent !== 'undefined') {
                window.foodManager = new window.FoodManagerComponent();
            }
        });
    }
})(); 