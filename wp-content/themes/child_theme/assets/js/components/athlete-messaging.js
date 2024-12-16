/**
 * AthleteMessaging Module
 * Handles all messaging-related functionality for the athlete dashboard
 */
const AthleteMessaging = (function($) {
    'use strict';

    // Private variables
    let config = {
        selectors: {
            messagingContainer: '.athlete-messaging',
            messageList: '.message-list',
            messageForm: '#send-message-form',
            messageContent: '#message-content',
            messageThread: '.message-thread',
            unreadCount: '.unread-count',
            messageModal: '#message-modal'
        },
        updateInterval: 60000 // 1 minute
    };

    /**
     * Initialize messaging form
     */
    function initializeMessagingForm() {
        $(config.selectors.messageForm).on('submit', function(e) {
            e.preventDefault();
            submitMessage($(this));
        });
    }

    /**
     * Submit new message
     */
    function submitMessage($form) {
        const $submitButton = $form.find('button[type="submit"]');
        const formData = $form.serialize();

        // Disable submit button to prevent double submission
        $submitButton.prop('disabled', true);

        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: formData + '&action=athlete_dashboard_send_message&nonce=' + window.athleteDashboard.nonce,
            success: function(response) {
                if (response.success) {
                    $form[0].reset();
                    refreshMessageThread();
                    showNotification('Message sent successfully!', 'success');
                } else {
                    console.error('Error sending message:', response.data.message);
                    showNotification('Error: ' + response.data.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error sending message:', error);
                showNotification('An error occurred while sending the message. Please try again.', 'error');
            },
            complete: function() {
                // Re-enable submit button
                $submitButton.prop('disabled', false);
            }
        });
    }

    /**
     * Load message thread
     */
    function loadMessageThread(threadId) {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_message_thread',
                thread_id: threadId,
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    $(config.selectors.messageThread).html(response.data.html);
                    scrollToLatestMessage();
                    markThreadAsRead(threadId);
                } else {
                    console.error('Error loading message thread:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error loading message thread:', error);
            }
        });
    }

    /**
     * Refresh message thread
     */
    function refreshMessageThread() {
        const threadId = $(config.selectors.messageThread).data('thread-id');
        if (threadId) {
            loadMessageThread(threadId);
        }
    }

    /**
     * Mark thread as read
     */
    function markThreadAsRead(threadId) {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_mark_thread_read',
                thread_id: threadId,
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    updateUnreadCount();
                } else {
                    console.error('Error marking thread as read:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error marking thread as read:', error);
            }
        });
    }

    /**
     * Update unread message count
     */
    function updateUnreadCount() {
        $.ajax({
            url: window.athleteDashboard.ajax_url,
            type: 'POST',
            data: {
                action: 'athlete_dashboard_get_unread_count',
                nonce: window.athleteDashboard.nonce
            },
            success: function(response) {
                if (response.success) {
                    const count = response.data.count;
                    $(config.selectors.unreadCount).text(count);
                    if (count > 0) {
                        $(config.selectors.unreadCount).show();
                    } else {
                        $(config.selectors.unreadCount).hide();
                    }
                } else {
                    console.error('Error updating unread count:', response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error updating unread count:', error);
            }
        });
    }

    /**
     * Scroll to latest message
     */
    function scrollToLatestMessage() {
        const $thread = $(config.selectors.messageThread);
        $thread.scrollTop($thread[0].scrollHeight);
    }

    /**
     * Show notification message
     */
    function showNotification(message, type) {
        if (typeof window.AthleteUI !== 'undefined' && window.AthleteUI.showNotification) {
            window.AthleteUI.showNotification(message, type);
        } else {
            alert(message);
        }
    }

    /**
     * Start periodic updates
     */
    function startPeriodicUpdates() {
        setInterval(function() {
            refreshMessageThread();
            updateUnreadCount();
        }, config.updateInterval);
    }

    /**
     * Initialize event listeners
     */
    function initializeEventListeners() {
        // Load thread when clicking on a message in the list
        $(document).on('click', '.message-preview', function(e) {
            e.preventDefault();
            const threadId = $(this).data('thread-id');
            loadMessageThread(threadId);
        });

        // New message modal
        $(document).on('click', '.new-message', function(e) {
            e.preventDefault();
            const $modal = $(config.selectors.messageModal);
            $modal.modal('show');
        });

        // Handle file attachments
        $(document).on('change', 'input[type="file"]', function() {
            const fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });
    }

    /**
     * Initialize all messaging components
     */
    function initialize() {
        if ($(config.selectors.messagingContainer).length) {
            initializeMessagingForm();
            initializeEventListeners();
            updateUnreadCount();
            startPeriodicUpdates();

            // Load active thread if any
            const activeThreadId = $(config.selectors.messageThread).data('thread-id');
            if (activeThreadId) {
                loadMessageThread(activeThreadId);
            }
        }
    }

    // Public API
    return {
        initialize,
        refreshMessageThread,
        updateUnreadCount,
        loadMessageThread
    };

})(jQuery);

// Initialize when document is ready
jQuery(document).ready(function() {
    AthleteMessaging.initialize();
}); 