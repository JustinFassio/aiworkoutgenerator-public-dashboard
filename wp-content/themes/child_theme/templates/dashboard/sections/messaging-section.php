<?php
/**
 * Messaging Section Template
 * 
 * @package AthleteDashboard
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$user_id = get_current_user_id();
$messaging_manager = new Athlete_Dashboard_Messaging_Manager();
$unread_count = $messaging_manager->get_unread_count($user_id);
$recent_messages = $messaging_manager->get_recent_messages($user_id, 5);
$notifications = $messaging_manager->get_notifications($user_id);
?>

<div class="messaging-container">
    <div class="section-header">
        <h2><?php _e('Messages & Notifications', 'athlete-dashboard'); ?></h2>
        <?php if ($unread_count > 0) : ?>
            <span class="unread-badge"><?php echo esc_html($unread_count); ?></span>
        <?php endif; ?>
        <button class="compose-message" data-action="compose-message">
            <?php _e('New Message', 'athlete-dashboard'); ?>
        </button>
    </div>

    <div class="messaging-content">
        <div class="messaging-tabs">
            <button class="tab-btn active" data-tab="messages">
                <?php _e('Messages', 'athlete-dashboard'); ?>
            </button>
            <button class="tab-btn" data-tab="notifications">
                <?php _e('Notifications', 'athlete-dashboard'); ?>
            </button>
        </div>

        <div class="tab-content">
            <div class="tab-pane active" id="messages-pane">
                <?php if (!empty($recent_messages)) : ?>
                    <div class="messages-list">
                        <?php foreach ($recent_messages as $message) : ?>
                            <div class="message-item <?php echo !$message->read ? 'unread' : ''; ?>" 
                                 data-message-id="<?php echo esc_attr($message->ID); ?>">
                                <div class="message-header">
                                    <div class="message-sender">
                                        <?php echo get_avatar($message->sender->ID, 32); ?>
                                        <span class="sender-name">
                                            <?php echo esc_html($message->sender->display_name); ?>
                                        </span>
                                    </div>
                                    <span class="message-date">
                                        <?php echo esc_html(human_time_diff(strtotime($message->date), current_time('timestamp'))); ?>
                                    </span>
                                </div>
                                <div class="message-preview">
                                    <h4><?php echo esc_html($message->subject); ?></h4>
                                    <p><?php echo wp_trim_words($message->content, 20); ?></p>
                                </div>
                                <div class="message-actions">
                                    <button class="reply-btn" data-action="reply" 
                                            data-message-id="<?php echo esc_attr($message->ID); ?>">
                                        <?php _e('Reply', 'athlete-dashboard'); ?>
                                    </button>
                                    <button class="delete-btn" data-action="delete" 
                                            data-message-id="<?php echo esc_attr($message->ID); ?>">
                                        <?php _e('Delete', 'athlete-dashboard'); ?>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="messages-footer">
                        <a href="#" class="view-all-messages">
                            <?php _e('View All Messages', 'athlete-dashboard'); ?>
                        </a>
                    </div>
                <?php else : ?>
                    <div class="no-messages">
                        <p><?php _e('No messages to display.', 'athlete-dashboard'); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="tab-pane" id="notifications-pane">
                <?php if (!empty($notifications)) : ?>
                    <div class="notifications-list">
                        <?php foreach ($notifications as $notification) : ?>
                            <div class="notification-item <?php echo !$notification->read ? 'unread' : ''; ?>"
                                 data-notification-id="<?php echo esc_attr($notification->ID); ?>">
                                <div class="notification-icon">
                                    <i class="<?php echo esc_attr($notification->icon); ?>"></i>
                                </div>
                                <div class="notification-content">
                                    <p><?php echo wp_kses_post($notification->content); ?></p>
                                    <span class="notification-time">
                                        <?php echo esc_html(human_time_diff(strtotime($notification->date), current_time('timestamp'))); ?>
                                    </span>
                                </div>
                                <button class="mark-read" data-action="mark-read" 
                                        data-notification-id="<?php echo esc_attr($notification->ID); ?>">
                                    <span class="screen-reader-text">
                                        <?php _e('Mark as read', 'athlete-dashboard'); ?>
                                    </span>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="no-notifications">
                        <p><?php _e('No notifications to display.', 'athlete-dashboard'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Message Compose Template -->
<script type="text/template" id="message-compose-template">
    <form id="compose-form" class="compose-form">
        <div class="form-group">
            <label for="message-to"><?php _e('To', 'athlete-dashboard'); ?></label>
            <select id="message-to" name="recipient" required>
                <?php
                $recipients = $messaging_manager->get_available_recipients($user_id);
                foreach ($recipients as $recipient) :
                ?>
                    <option value="<?php echo esc_attr($recipient->ID); ?>">
                        <?php echo esc_html($recipient->display_name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="message-subject"><?php _e('Subject', 'athlete-dashboard'); ?></label>
            <input type="text" id="message-subject" name="subject" required>
        </div>
        
        <div class="form-group">
            <label for="message-content"><?php _e('Message', 'athlete-dashboard'); ?></label>
            <textarea id="message-content" name="content" required></textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="send-message">
                <?php _e('Send Message', 'athlete-dashboard'); ?>
            </button>
            <button type="button" class="cancel-compose">
                <?php _e('Cancel', 'athlete-dashboard'); ?>
            </button>
        </div>
    </form>
</script>

<!-- Message View Template -->
<script type="text/template" id="message-view-template">
    <div class="message-view">
        <div class="message-view-header">
            <h3>{{subject}}</h3>
            <div class="message-meta">
                <span class="sender">{{sender_name}}</span>
                <span class="date">{{date}}</span>
            </div>
        </div>
        <div class="message-view-content">
            {{content}}
        </div>
        <div class="message-view-actions">
            <button class="reply-message">
                <?php _e('Reply', 'athlete-dashboard'); ?>
            </button>
            <button class="close-message">
                <?php _e('Close', 'athlete-dashboard'); ?>
            </button>
        </div>
    </div>
</script> 