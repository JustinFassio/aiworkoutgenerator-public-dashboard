/**
 * Athlete Dashboard Attendance Module
 */
import { UI } from './ui.js';

export class AthleteAttendance {
    constructor() {
        this.initialized = false;
    }

    init() {
        if (this.initialized) return;
        this.bindEvents();
        this.initializeAttendanceCalendar();
        this.loadAttendanceStats();
        this.initialized = true;
    }

    bindEvents() {
        document.addEventListener('click', (e) => {
            if (e.target.matches('.record-attendance-btn')) {
                this.handleRecordAttendance(e);
            }
        });

        document.addEventListener('change', (e) => {
            if (e.target.matches('.attendance-period-selector')) {
                this.handlePeriodChange(e);
            }
        });
    }

    initializeAttendanceCalendar() {
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

        this.loadAttendanceData(firstDay, lastDay);
    }

    async loadAttendanceData(startDate, endDate) {
        const container = document.getElementById('attendance-calendar-container');
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_attendance',
                    nonce: window.athleteDashboard.nonce,
                    start_date: this.formatDate(startDate),
                    end_date: this.formatDate(endDate)
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.renderAttendanceCalendar(data.data);
            } else {
                this.showMessage('Error loading attendance data. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Attendance data loading error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    async loadAttendanceStats() {
        const container = document.getElementById('attendance-stats-container');
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_attendance_stats',
                    nonce: window.athleteDashboard.nonce
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.updateAttendanceStats(data.data);
            } else {
                this.showMessage('Error loading attendance stats. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Attendance stats loading error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    async handleRecordAttendance(e) {
        e.preventDefault();
        const date = e.target.dataset.date;
        const container = e.target.closest('.attendance-container');
        
        if (!container) return;

        const loader = UI.showLoading(container);

        try {
            const response = await fetch(window.athleteDashboard.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'record_attendance',
                    nonce: window.athleteDashboard.nonce,
                    date: date
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.showMessage('Attendance recorded successfully!', 'success', container);
                await this.initializeAttendanceCalendar();
                await this.loadAttendanceStats();
            } else {
                this.showMessage(data.data?.message || 'Error recording attendance. Please try again.', 'error', container);
            }
        } catch (error) {
            this.showMessage('Server error. Please try again later.', 'error', container);
            console.error('Attendance recording error:', error);
        } finally {
            UI.hideLoading(loader);
        }
    }

    handlePeriodChange(e) {
        const period = e.target.value;
        const dates = this.getPeriodDates(period);
        this.loadAttendanceData(dates.start, dates.end);
    }

    getPeriodDates(period) {
        const today = new Date();
        let startDate, endDate;

        switch (period) {
            case 'week':
                startDate = new Date(today.setDate(today.getDate() - today.getDay()));
                endDate = new Date(today.setDate(today.getDate() + 6));
                break;
            case 'month':
                startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                break;
            case 'year':
                startDate = new Date(today.getFullYear(), 0, 1);
                endDate = new Date(today.getFullYear(), 11, 31);
                break;
            default:
                startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        }

        return { start: startDate, end: endDate };
    }

    renderAttendanceCalendar(data) {
        const calendar = document.getElementById('attendance-calendar');
        if (!calendar) return;

        // Update calendar HTML
        calendar.innerHTML = data.calendar;
        
        // Highlight attended days
        data.attended_dates.forEach(date => {
            const dayElement = calendar.querySelector(`[data-date="${date}"]`);
            if (dayElement) {
                dayElement.classList.add('attended');
            }
        });
    }

    updateAttendanceStats(stats) {
        const elements = {
            rate: document.getElementById('attendance-rate'),
            currentStreak: document.getElementById('current-streak'),
            bestStreak: document.getElementById('best-streak')
        };

        if (elements.rate) elements.rate.textContent = `${stats.attendance_rate}%`;
        if (elements.currentStreak) elements.currentStreak.textContent = `${stats.current_streak} days`;
        if (elements.bestStreak) elements.bestStreak.textContent = `${stats.best_streak} days`;
    }

    formatDate(date) {
        return date.toISOString().split('T')[0];
    }

    showMessage(message, type, container) {
        const messageDiv = container.querySelector('.attendance-message') || 
            UI.createElement('div', 'attendance-message');
        
        messageDiv.className = `attendance-message ${type}`;
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
}

// Export singleton instance
export const Attendance = new AthleteAttendance();

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => Attendance.init()); 