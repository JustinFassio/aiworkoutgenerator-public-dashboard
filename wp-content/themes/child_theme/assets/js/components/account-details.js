/**
 * Account Details Component
 */
if (typeof AccountDetailsComponent === 'undefined') {
    class AccountDetailsComponent {
        constructor() {
            this.form = document.querySelector('.account-details-form');
            this.init();
        }

        init() {
            if (!this.form) return;

            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        }

        handleSubmit(e) {
            e.preventDefault();
            const formData = new FormData(this.form);
            formData.append('action', 'update_account_details');
            formData.append('nonce', athleteDashboardData.nonce);

            this.form.classList.add('loading');

            fetch(athleteDashboardData.ajaxurl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.athleteDashboard.showNotification(data.data.message, 'success');
                } else {
                    window.athleteDashboard.showNotification(data.data, 'error');
                }
            })
            .catch(error => {
                window.athleteDashboard.showNotification('Error updating account details', 'error');
            })
            .finally(() => {
                this.form.classList.remove('loading');
            });
        }
    }
} 