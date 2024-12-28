import { ProfileModal } from './components/profile-modal';
import { Events as DashboardEvents } from '@dashboard/js/events';
import './types/profile.types';

// Initialize profile feature
document.addEventListener('DOMContentLoaded', () => {
    // Initialize profile modal
    const modal = new ProfileModal({
        id: 'profile-modal',
        title: 'Your Profile',
        submitText: 'Save Profile',
        closeText: 'Close'
    });

    // Listen for global profile events
    DashboardEvents.on('profile:update', (e) => {
        console.log('Profile updated:', e.detail);
    });

    // Emit ready event
    DashboardEvents.emit('profile:ready');
}); 