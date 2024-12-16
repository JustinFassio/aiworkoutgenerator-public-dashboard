/**
 * Athlete Dashboard Messaging Module
 */
(function($) {
    'use strict';

    const AthleteMessaging = {
        init: function() {
            this.bindEvents();
            this.initializeMessageForms();
            this.loadMessages();
            this.startMessagePolling();
        },

        bindEvents: function() {
            $(document).on('submit', '.message-form', this.handleMessageSubmit.bind(this));
            $(document).on('click', '.message-delete-btn', this.handleMessageDelete.bind(this));
            $(document).on('click', '.message-reply-btn', this.handleMessageReply.bind(this));
            $(document).on('click', '.message-item', this.handleMessageClick.bind(this));
        },

        initializeMessageForms: function() {
            // Initialize recipient selector
            $('.recipient-selector').each(function() {
                $(this).select2({
                    placeholder: 'Select recipient',
                    allowClear: true,
                    ajax: {
                        url: athleteDashboard.ajax_url,
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                action: 'search_recipients',
                                nonce: athleteDashboard.nonce,
                                search: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.success ? data.data : []
                            };
                        }
                    }
                });
            });
        },

        loadMessages: function() {
            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_messages',
                    nonce: athleteDashboard.nonce
                },
                success: function(response) {
                    if (response.success) {
                        this.updateMessagesList(response.data);
                    }
                }.bind(this)
            });
        },

        startMessagePolling: function() {
            // Poll for new messages every 30 seconds
            setInterval(this.checkNewMessages.bind(this), 30000);
        },

        checkNewMessages: function() {
            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'check_new_messages',
                    nonce: athleteDashboard.nonce,
                    last_check: this.lastMessageCheck
                },
                success: function(response) {
                    if (response.success && response.data.has_new) {
                        this.loadMessages();
                        this.showNotification('You have new messages');
                    }
                    this.lastMessageCheck = new Date().toISOString();
                }.bind(this)
            });
        },

        handleMessageSubmit: function(e) {
            e.preventDefault();
            const $form = $(e.target);
            const formData = new FormData($form[0]);

            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'send_message',
                    nonce: athleteDashboard.nonce,
                    message_data: Object.fromEntries(formData)
                },
                success: function(response) {
                    if (response.success) {
                        this.showMessage('Message sent successfully!', 'success');
                        $form[0].reset();
                        this.loadMessages();
                    } else {
                        this.showMessage('Error sending message. Please try again.', 'error');
                    }
                }.bind(this)
            });
        },

        handleMessageDelete: function(e) {
            e.preventDefault();
            if (!confirm('Are you sure you want to delete this message?')) {
                return;
            }

            const messageId = $(e.target).data('message-id');

            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'delete_message',
                    nonce: athleteDashboard.nonce,
                    message_id: messageId
                },
                success: function(response) {
                    if (response.success) {
                        this.showMessage('Message deleted successfully!', 'success');
                        this.loadMessages();
                    } else {
                        this.showMessage('Error deleting message. Please try again.', 'error');
                    }
                }.bind(this)
            });
        },

        handleMessageReply: function(e) {
            e.preventDefault();
            const messageId = $(e.target).data('message-id');
            const recipientId = $(e.target).data('recipient-id');

            // Set recipient in the compose form
            $('.recipient-selector').val(recipientId).trigger('change');
            
            // Set reply subject
            const subject = $(e.target).closest('.message-item').find('.message-subject').text();
            $('#message-subject').val('Re: ' + subject.replace(/^Re: /, ''));

            // Scroll to compose form
            $('html, body').animate({
                scrollTop: $('#compose-message-form').offset().top
            }, 500);
        },

        handleMessageClick: function(e) {
            const messageId = $(e.currentTarget).data('message-id');
            
            // Mark as read if unread
            if ($(e.currentTarget).hasClass('unread')) {
                this.markMessageAsRead(messageId);
            }

            // Load full message content
            this.loadMessageContent(messageId);
        },

        markMessageAsRead: function(messageId) {
            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'mark_message_read',
                    nonce: athleteDashboard.nonce,
                    message_id: messageId
                },
                success: function(response) {
                    if (response.success) {
                        $(`[data-message-id="${messageId}"]`).removeClass('unread');
                    }
                }
            });
        },

        loadMessageContent: function(messageId) {
            $.ajax({
                url: athleteDashboard.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_message_content',
                    nonce: athleteDashboard.nonce,
                    message_id: messageId
                },
                success: function(response) {
                    if (response.success) {
                        $('#message-content-container').html(response.data.content);
                    }
                }.bind(this)
            });
        },

        updateMessagesList: function(data) {
            const $container = $('#messages-list');
            $container.html(data.messages);
            
            // Update unread count
            $('.unread-count').text(data.unread_count);
        },

        showMessage: function(message, type) {
            const $messageDiv = $('.messaging-message');
            $messageDiv
                .removeClass('success error')
                .addClass(type)
                .text(message)
                .fadeIn()
                .delay(3000)
                .fadeOut();
        },

        showNotification: function(message) {
            if ('Notification' in window) {
                Notification.requestPermission().then(function(permission) {
                    if (permission === 'granted') {
                        new Notification('Athlete Dashboard', {
                            body: message,
                            icon: '/path/to/notification-icon.png'
                        });
                    }
                });
            }
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        AthleteMessaging.init();
    });

})(jQuery); 