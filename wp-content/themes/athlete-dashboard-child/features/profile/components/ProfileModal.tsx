import React from 'react';
import { useProfile } from '../hooks/useProfile';
import type { ProfileFormData } from '../types/Profile';
import { LoadingSpinner } from '@components/LoadingSpinner';
import './ProfileModal.scss';

interface ProfileModalProps {
  isOpen: boolean;
  onClose: () => void;
}

export function ProfileModal({ isOpen, onClose }: ProfileModalProps) {
  const {
    profile,
    isLoading,
    error,
    updateProfile,
    isUpdating,
    updateAvatar,
    isUpdatingAvatar,
  } = useProfile({
    onUpdateSuccess: (data) => {
      if (data.success) {
        onClose();
      }
    },
  });

  if (!isOpen) return null;

  const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    const form = event.currentTarget;
    const formData = new FormData(form);

    const data: ProfileFormData = {
      name: formData.get('name') as string,
      email: formData.get('email') as string,
      bio: formData.get('bio') as string,
      notifications: formData.get('notifications') === 'on',
      weeklyGoal: parseInt(formData.get('weeklyGoal') as string, 10),
      preferredWorkoutTypes: formData.getAll('workoutTypes') as string[],
      availableDays: formData.getAll('availableDays') as string[],
      timePreference: formData.get('timePreference') as string,
    };

    updateProfile(data);
  };

  const handleAvatarChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const file = event.target.files?.[0];
    if (file) {
      updateAvatar(file);
    }
  };

  return (
    <div className="modal">
      <div className="modal__backdrop" onClick={onClose} />
      <div className="modal__content">
        <div className="modal__header">
          <h2 className="modal__title">Edit Profile</h2>
          <button
            type="button"
            className="modal__close"
            onClick={onClose}
            aria-label="Close"
          >
            ×
          </button>
        </div>

        <div className="modal__body">
          {isLoading ? (
            <LoadingSpinner />
          ) : error ? (
            <div className="error-message">
              Failed to load profile. Please try again later.
            </div>
          ) : profile ? (
            <form className="profile-form" onSubmit={handleSubmit}>
              <div className="profile-form__avatar">
                <img
                  src={profile.avatarUrl || '/wp-content/themes/athlete-dashboard-child/assets/images/default-avatar.png'}
                  alt={profile.name}
                />
                <input
                  type="file"
                  accept="image/*"
                  onChange={handleAvatarChange}
                  disabled={isUpdatingAvatar}
                />
              </div>

              <div className="profile-form__group">
                <label className="profile-form__label" htmlFor="name">
                  Name
                </label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  className="profile-form__field"
                  defaultValue={profile.name}
                  required
                />
              </div>

              <div className="profile-form__group">
                <label className="profile-form__label" htmlFor="email">
                  Email
                </label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  className="profile-form__field"
                  defaultValue={profile.email}
                  required
                />
              </div>

              <div className="profile-form__group">
                <label className="profile-form__label" htmlFor="bio">
                  Bio
                </label>
                <textarea
                  id="bio"
                  name="bio"
                  className="profile-form__field"
                  defaultValue={profile.bio}
                  rows={4}
                />
              </div>

              <div className="profile-form__group">
                <label className="profile-form__label">
                  <input
                    type="checkbox"
                    name="notifications"
                    defaultChecked={profile.preferences.notifications}
                  />
                  Enable notifications
                </label>
              </div>

              <div className="profile-form__group">
                <label className="profile-form__label" htmlFor="weeklyGoal">
                  Weekly Workout Goal
                </label>
                <input
                  type="number"
                  id="weeklyGoal"
                  name="weeklyGoal"
                  className="profile-form__field"
                  defaultValue={profile.preferences.weeklyGoal}
                  min={1}
                  max={7}
                />
              </div>
            </form>
          ) : null}
        </div>

        <div className="modal__footer">
          <button
            type="button"
            className="button button--secondary"
            onClick={onClose}
          >
            Cancel
          </button>
          <button
            type="submit"
            form="profile-form"
            className="button button--primary"
            disabled={isUpdating}
          >
            {isUpdating ? 'Saving...' : 'Save Changes'}
          </button>
        </div>
      </div>
    </div>
  );
} 