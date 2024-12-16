/**
 * AthleteNutrition Module
 * Handles all nutrition-related functionality for the athlete dashboard
 */
const AthleteNutrition = (function($) {
    'use strict';

    // Private variables
    let config = {
        selectors: {
            nutritionList: '.nutrition-list-scrollable',
            nutritionForm: '#log-nutrition-form',
            recentMeals: '#recent-meals',
            mealListScrollable: '.meal-list-scrollable',
            mealList: '.meal-list',
            noMeals: '.no-meals'
        },
        updateInterval: 300000, // 5 minutes
        isChartUpdateInProgress: false
    };

    /**
     * Initialize scrolling functionality
     */
    function initializeScrolling() {
        const scrollContainer = document.querySelector(config.selectors.nutritionList);
        if (scrollContainer) {
            scrollContainer.addEventListener('scroll', handleScroll);
        }
    }

    /**
     * Handle scroll events
     */
    function handleScroll() {
        // Implement infinite scrolling or load more functionality here
        // For example:
        // if (isNearBottom(scrollContainer)) {
        //     loadMoreNutritionEntries();
        // }
    }

    /**
     * Refresh nutrition list
     */
    function refreshNutrition() {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_recent_nutrition',
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $(config.selectors.nutritionList).html(response.data.html);
                } else {
                    console.error('Error refreshing nutrition:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error refreshing nutrition:', error);
            }
        });
    }

    /**
     * Update existing nutrition entry
     */
    function updateNutrition(nutritionId, updatedData) {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_update_nutrition',
                nonce: window.athleteDashboard.nonce,
                nutrition_id: nutritionId,
                nutrition_data: updatedData
            },
            success: function(response) {
                if (response.success) {
                    console.log('Nutrition entry updated successfully');
                    refreshNutrition();
                } else {
                    console.error('Error updating nutrition entry:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error updating nutrition entry:', error);
            }
        });
    }

    /**
     * Log new nutrition entry
     */
    function logNutrition(nutritionData) {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_log_nutrition',
                nonce: window.athleteDashboard.nonce,
                nutrition_data: nutritionData
            },
            success: function(response) {
                if (response.success) {
                    console.log('Nutrition entry logged successfully');
                    refreshNutrition();
                } else {
                    console.error('Error logging nutrition entry:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error logging nutrition entry:', error);
            }
        });
    }

    /**
     * Refresh recent meals
     */
    function refreshRecentMeals() {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_recent_meals',
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    displayRecentMeals(response.data.meals);
                } else {
                    console.error('Error refreshing recent meals:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error refreshing recent meals:', error);
            }
        });
    }

    /**
     * Display recent meals
     */
    function displayRecentMeals(meals) {
        const $container = $(config.selectors.recentMeals);
        $container.empty();

        if (meals.length === 0) {
            $container.append('<p class="no-meals">No recent meals found.</p>');
            return;
        }

        const $scrollableContainer = $('<div class="meal-list-scrollable"></div>');
        const $list = $('<div class="meal-list"></div>');

        meals.forEach(function(meal) {
            const formattedDateTime = new Date(meal.date + 'T' + meal.time).toLocaleString();
            const $item = $(`
                <div class="meal-card">
                    <div class="meal-header">
                        <h4 class="meal-date">${formattedDateTime}</h4>
                        <span class="meal-type">${meal.type}</span>
                    </div>
                    <div class="meal-details">
                        <p><strong>Name:</strong> ${meal.name}</p>
                        <p><strong>Calories:</strong> ${meal.calories}</p>
                        <p><strong>Protein:</strong> ${meal.protein.type} - ${meal.protein.quantity} ${meal.protein.unit}</p>
                        <p><strong>Fat:</strong> ${meal.fat.type} - ${meal.fat.quantity} ${meal.fat.unit}</p>
                        <p><strong>Carbs (Starch):</strong> ${meal.carb_starch.type} - ${meal.carb_starch.quantity} ${meal.carb_starch.unit}</p>
                        <p><strong>Carbs (Fruit):</strong> ${meal.carb_fruit.type} - ${meal.carb_fruit.quantity} ${meal.carb_fruit.unit}</p>
                        <p><strong>Carbs (Vegetable):</strong> ${meal.carb_vegetable.type} - ${meal.carb_vegetable.quantity} ${meal.carb_vegetable.unit}</p>
                        ${meal.description ? `<p><strong>Description:</strong> ${meal.description}</p>` : ''}
                    </div>
                </div>
            `);
            $list.append($item);
        });

        $scrollableContainer.append($list);
        $container.append($scrollableContainer);
    }

    /**
     * Initialize event listeners
     */
    function initializeEventListeners() {
        // Listen for "Update Nutrition" button clicks
        $(document).on('click', '.update-nutrition-btn', function() {
            const nutritionId = $(this).data('nutrition-id');
            const updatedData = getUpdatedNutritionData(nutritionId);
            updateNutrition(nutritionId, updatedData);
        });

        // Listen for "Log Nutrition" form submission
        $(config.selectors.nutritionForm).on('submit', function(e) {
            e.preventDefault();
            const nutritionData = $(this).serialize();
            logNutrition(nutritionData);
        });
    }

    /**
     * Start periodic updates
     */
    function startPeriodicUpdates() {
        setInterval(function() {
            refreshNutrition();
            refreshRecentMeals();
        }, config.updateInterval);
    }

    /**
     * Initialize all nutrition components
     */
    function initialize() {
        initializeScrolling();
        initializeEventListeners();
        refreshNutrition();
        refreshRecentMeals();
        startPeriodicUpdates();
    }

    // Public API
    return {
        initialize,
        refreshNutrition,
        updateNutrition,
        logNutrition,
        refreshRecentMeals
    };

})(jQuery);

// Initialize when document is ready
jQuery(document).ready(function() {
    AthleteNutrition.initialize();
}); 