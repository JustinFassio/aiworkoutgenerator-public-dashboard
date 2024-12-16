<?php
/**
 * Membership Section Template
 * 
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$user_id = get_current_user_id();
$membership_manager = new Athlete_Dashboard_Membership_Manager();
$membership = $membership_manager->get_user_membership($user_id);
$subscription = $membership_manager->get_user_subscription($user_id);
?>

<div class="membership-container">
    <div class="section-header">
        <h2><?php _e('Membership Status', 'athlete-dashboard'); ?></h2>
        <?php if ($membership && $membership->is_active) : ?>
            <span class="status-badge active"><?php _e('Active', 'athlete-dashboard'); ?></span>
        <?php else : ?>
            <span class="status-badge inactive"><?php _e('Inactive', 'athlete-dashboard'); ?></span>
        <?php endif; ?>
    </div>

    <div class="membership-content">
        <?php if ($membership) : ?>
            <div class="membership-details">
                <div class="membership-type">
                    <h3><?php echo esc_html($membership->plan_name); ?></h3>
                    <p class="membership-description">
                        <?php echo esc_html($membership->plan_description); ?>
                    </p>
                </div>

                <?php if ($subscription) : ?>
                    <div class="subscription-details">
                        <div class="detail-item">
                            <span class="detail-label"><?php _e('Next Payment', 'athlete-dashboard'); ?></span>
                            <span class="detail-value">
                                <?php echo esc_html(date_i18n(get_option('date_format'), strtotime($subscription->next_payment_date))); ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label"><?php _e('Amount', 'athlete-dashboard'); ?></span>
                            <span class="detail-value">
                                <?php echo esc_html($membership_manager->format_price($subscription->amount)); ?>
                            </span>
                        </div>
                        <?php if ($subscription->trial_end_date) : ?>
                            <div class="detail-item">
                                <span class="detail-label"><?php _e('Trial Ends', 'athlete-dashboard'); ?></span>
                                <span class="detail-value">
                                    <?php echo esc_html(date_i18n(get_option('date_format'), strtotime($subscription->trial_end_date))); ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="subscription-actions">
                        <?php if ($subscription->can_upgrade) : ?>
                            <button class="upgrade-plan" data-action="upgrade-plan">
                                <?php _e('Upgrade Plan', 'athlete-dashboard'); ?>
                            </button>
                        <?php endif; ?>
                        <button class="manage-subscription" data-action="manage-subscription">
                            <?php _e('Manage Subscription', 'athlete-dashboard'); ?>
                        </button>
                    </div>
                <?php endif; ?>

                <div class="membership-features">
                    <h4><?php _e('Plan Features', 'athlete-dashboard'); ?></h4>
                    <ul class="features-list">
                        <?php foreach ($membership->features as $feature) : ?>
                            <li class="feature-item">
                                <i class="feature-icon <?php echo esc_attr($feature->icon); ?>"></i>
                                <span class="feature-text"><?php echo esc_html($feature->description); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php else : ?>
            <div class="no-membership">
                <p><?php _e('You currently don\'t have an active membership.', 'athlete-dashboard'); ?></p>
                <button class="select-plan" data-action="select-plan">
                    <?php _e('Select a Plan', 'athlete-dashboard'); ?>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($membership && $membership->is_active) : ?>
            <div class="membership-usage">
                <h4><?php _e('Usage Statistics', 'athlete-dashboard'); ?></h4>
                <?php
                $usage_stats = $membership_manager->get_usage_statistics($user_id);
                if (!empty($usage_stats)) :
                ?>
                    <div class="usage-grid">
                        <?php foreach ($usage_stats as $stat) : ?>
                            <div class="usage-item">
                                <span class="usage-label"><?php echo esc_html($stat->label); ?></span>
                                <span class="usage-value">
                                    <?php echo esc_html($stat->value); ?>
                                    <?php if ($stat->limit) : ?>
                                        <small><?php printf(__('of %s', 'athlete-dashboard'), esc_html($stat->limit)); ?></small>
                                    <?php endif; ?>
                                </span>
                                <?php if ($stat->limit) : ?>
                                    <div class="usage-bar">
                                        <div class="usage-progress" style="width: <?php echo esc_attr(min(100, ($stat->value / $stat->limit) * 100)); ?>%"></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Plan Selection Template -->
<script type="text/template" id="plan-selection-template">
    <div class="plan-selection">
        <h3><?php _e('Choose Your Plan', 'athlete-dashboard'); ?></h3>
        <div class="plans-grid">
            <?php
            $available_plans = $membership_manager->get_available_plans();
            foreach ($available_plans as $plan) :
            ?>
                <div class="plan-card" data-plan-id="<?php echo esc_attr($plan->ID); ?>">
                    <div class="plan-header">
                        <h4><?php echo esc_html($plan->name); ?></h4>
                        <div class="plan-price">
                            <span class="amount"><?php echo esc_html($membership_manager->format_price($plan->price)); ?></span>
                            <span class="period"><?php echo esc_html($plan->billing_period); ?></span>
                        </div>
                    </div>
                    <div class="plan-features">
                        <ul>
                            <?php foreach ($plan->features as $feature) : ?>
                                <li>
                                    <i class="feature-icon <?php echo esc_attr($feature->icon); ?>"></i>
                                    <?php echo esc_html($feature->description); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="plan-footer">
                        <button class="select-plan-btn" data-plan-id="<?php echo esc_attr($plan->ID); ?>">
                            <?php _e('Select Plan', 'athlete-dashboard'); ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</script> 