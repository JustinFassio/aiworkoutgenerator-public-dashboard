/**
 * Athlete Dashboard Messaging Module
 */
import { UI } from './ui.js';

export class AthleteMessaging {
    constructor() {
        this.initialized = false;
        this.lastMessageCheck = new Date().toISOString();
        this.pollingInterval = null;
    }

    init() {
        if (this.initialized) return;
        this.bindEvents();
        this.initializeMessageForms();
        this.loadMessages();
        this.startMessagePolling();
        this.initialized = true;
    }

    bindEvents() {
        document.addEventListener('submit', (e) => {
            if (e.target.matches('.message-form')) {
                this.handleMessageSubmit(e);
            }
        });

        document.addEventListener('click', (e) => {
            if (e.target.matches('.message-delete-btn')) {
                this.handleMessageDelete(e);
            }
            if (e.target.matches('.message-reply-btn')) {
                this.handleMessageReply(e);
            }
            if (e.target.closest('.message-item')) {
                this.handleMessageClick(e);
            }
        });
    }

    async initializeMessageForms() {
        // Initialize recipient selector with custom dropdown
        document.querySelectorAll('.recipient-selector').forEach(selector => {
            this.initializeRecipientSelector(selector);
        });
    }

    async initializeRecipientSelector(selector) {
        const dropdown = UI.createElement('div', 'recipient-dropdown');
        const input = UI.createElement('input', 'recipient-search');
        input.type = 'text';
        input.placeholder = 'Search recipients...';
        
        dropdown.appendChild(input);
        const resultsContainer = UI.createElement('div', 'recipient-results');
        dropdown.appendChild(resultsContainer);
        
        selector.parentNode.replaceChild(dropdown, selector);

        let debounceTimeout;
        input.addEventListener('input', () => {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => this.searchRecipients(input.value, resultsContainer), 250);
        });
    }

    async searchRecipients(search, container) {
        if (!search) {
            container.innerHTML = '';
            return;
        }

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'search_recipients',
                    nonce: window.athleteDashboard.nonce,
                    search: search
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.renderRecipientResults(data.data, container);
            }
        } catch (error) {
            console.error('Recipient search error:', error);
        }
    }

    renderRecipientResults(recipients, container) {
        container.innerHTML = recipients
            .map(recipient => `
                <div class="recipient-option" data-id="${recipient.id}">
                    <img src="${recipient.avatar}" alt="${recipient.name}" class="recipient-avatar">
                    <span>${recipient.name}</span>
                </div>
            `)
            .join('');

        container.querySelectorAll('.recipient-option').forEach(option => {
            option.addEventListener('click', () => this.selectRecipient(option));
        });
    }

    selectRecipient(option) {
        const dropdown = option.closest('.recipient-dropdown');
        const input = dropdown.querySelector('.recipient-search');
        input.value = option.querySelector('span').textContent;
        input.dataset.selectedId = option.dataset.id;
        dropdown.querySelector('.recipient-results').innerHTML = '';
    }

    async loadMessages() {
        const container = document.getElementById('messages-container');
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_messages',
                    nonce: window.athleteDashboard.nonce
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.updateMessagesList(data.data);
            } else {
                this.showMessage('Error loading messages. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Messages loading error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    startMessagePolling() {
        // Clear existing interval if any
        if (this.pollingInterval) {
            clearInterval(this.pollingInterval);
        }
        // Poll for new messages every 30 seconds
        this.pollingInterval = setInterval(() => this.checkNewMessages(), 30000);
    }

    async checkNewMessages() {
        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'check_new_messages',
                    nonce: window.athleteDashboard.nonce,
                    last_check: this.lastMessageCheck
                })
            });

            const data = await response.json();
            
            if (data.success && data.data.has_new) {
                await this.loadMessages();
                this.showNotification('You have new messages');
            }
            this.lastMessageCheck = new Date().toISOString();
        } catch (error) {
            console.error('New messages check error:', error);
        }
    }

    async handleMessageSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const container = form.closest('.messaging-container');
        
        if (!container) return;

        const loader = UI.showLoading(container);
        const formData = new FormData(form);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'send_message',
                    nonce: window.athleteDashboard.nonce,
                    message_data: JSON.stringify(Object.fromEntries(formData))
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.showMessage('Message sent successfully!', 'success', container);
                form.reset();
                await this.loadMessages();
            } else {
                this.showMessage(data.data?.message || 'Error sending message. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Message submission error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    async handleMessageDelete(e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete this message?')) {
            return;
        }

        const messageId = e.target.dataset.messageId;
        const container = e.target.closest('.message-item');
        
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'delete_message',
                    nonce: window.athleteDashboard.nonce,
                    message_id: messageId
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.showMessage('Message deleted successfully!', 'success', container);
                await this.loadMessages();
            } else {
                this.showMessage(data.data?.message || 'Error deleting message. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Message deletion error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    handleMessageReply(e) {
        e.preventDefault();
        const messageItem = e.target.closest('.message-item');
        const recipientId = e.target.dataset.recipientId;
        const subject = messageItem.querySelector('.message-subject')?.textContent || '';
        
        // Set recipient in the compose form
        const recipientSearch = document.querySelector('.recipient-search');
        if (recipientSearch) {
            recipientSearch.dataset.selectedId = recipientId;
            recipientSearch.value = messageItem.querySelector('.message-sender')?.textContent || '';
        }
        
        // Set reply subject
        const subjectInput = document.getElementById('message-subject');
        if (subjectInput) {
            subjectInput.value = 'Re: ' + subject.replace(/^Re: /, '');
        }

        // Scroll to compose form
        const composeForm = document.getElementById('compose-message-form');
        if (composeForm) {
            composeForm.scrollIntoView({ behavior: 'smooth' });
        }
    }

    async handleMessageClick(e) {
        const messageItem = e.target.closest('.message-item');
        const messageId = messageItem.dataset.messageId;
        
        // Mark as read if unread
        if (messageItem.classList.contains('unread')) {
            await this.markMessageAsRead(messageId, messageItem);
        }

        // Load full message content
        await this.loadMessageContent(messageId);
    }

    async markMessageAsRead(messageId, messageItem) {
        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'mark_message_read',
                    nonce: window.athleteDashboard.nonce,
                    message_id: messageId
                })
            });

            const data = await response.json();
            
            if (data.success) {
                messageItem.classList.remove('unread');
                this.updateUnreadCount(-1);
            }
        } catch (error) {
            console.error('Mark as read error:', error);
        }
    }

    async loadMessageContent(messageId) {
        const container = document.getElementById('message-content-container');
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_message_content',
                    nonce: window.athleteDashboard.nonce,
                    message_id: messageId
                })
            });

            const data = await response.json();
            
            if (data.success) {
                container.innerHTML = data.data.content;
            } else {
                this.showMessage('Error loading message content. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Message content loading error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    updateMessagesList(data) {
        const container = document.getElementById('messages-list');
        if (container) {
            container.innerHTML = data.messages;
        }
        
        this.updateUnreadCount(data.unread_count);
    }

    updateUnreadCount(count) {
        document.querySelectorAll('.unread-count').forEach(element => {
            element.textContent = typeof count === 'number' ? 
                parseInt(element.textContent || '0') + count :
                count;
        });
    }

    showMessage(message, type, container) {
        const messageDiv = container.querySelector('.messaging-message') || 
            UI.createElement('div', 'messaging-message');
        
        messageDiv.className = `messaging-message ${type}`;
        messageDiv.textContent = message;
        
        if (!messageDiv.parentNode) {
            container.insertBefore(messageDiv, container.firstChild);
        }

        // Auto-hide message
        setTimeout(() => {
            messageDiv.classList.add('fade-out');
            setTimeout(() => messageDiv.remove(), 300);
        }, 3000);
    }

    async showNotification(message) {
        if (!('Notification' in window)) return;

        try {
            const permission = await Notification.requestPermission();
            if (permission === 'granted') {
                new Notification('Athlete Dashboard', {
                    body: message,
                    icon: '/path/to/notification-icon.png'
                });
            }
        } catch (error) {
            console.error('Notification error:', error);
        }
    }

    // Cleanup method to clear intervals when module is destroyed
    destroy() {
        if (this.pollingInterval) {
            clearInterval(this.pollingInterval);
        }
    }
}

// Export singleton instance
export const Messaging = new AthleteMessaging();

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => Messaging.init()); 