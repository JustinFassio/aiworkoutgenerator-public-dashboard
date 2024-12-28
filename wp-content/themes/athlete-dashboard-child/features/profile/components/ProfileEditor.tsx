import React from 'react';
import { useProfile } from '../hooks/useProfile';
import type { ProfileFormData } from '../types/Profile';
import { LoadingSpinner } from '@components/LoadingSpinner';

export function ProfileEditor() {
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
        // Show success message
        console.log('Profile updated successfully');
      }
    },
    onUpdateError: (error) => {
      // Show error message
      console.error('Failed to update profile:', error);
    },
  });

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

  if (isLoading) {
    return <LoadingSpinner />;
  }

  if (error) {
    return (
      <div className="error-message">
        Failed to load profile. Please try again later.
      </div>
    );
  }

  if (!profile) {
    return null;
  }

  return (
    <div className="profile">
      <div className="profile__header">
        <div className="profile__avatar">
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
        <div className="profile__info">
          <h1 className="profile__name">{profile.name}</h1>
          <p className="profile__bio">{profile.bio}</p>
        </div>
      </div>

      <form className="profile-form" onSubmit={handleSubmit}>
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

        <div className="profile-form__actions">
          <button
            type="submit"
            className="profile-form__submit"
            disabled={isUpdating}
          >
            {isUpdating ? 'Saving...' : 'Save Changes'}
          </button>
        </div>
      </form>

      <div className="profile-stats">
        <div className="profile-stats__item">
          <div className="profile-stats__value">
            {profile.stats.workoutsCompleted}
          </div>
          <div className="profile-stats__label">Workouts Completed</div>
        </div>
        <div className="profile-stats__item">
          <div className="profile-stats__value">
            {profile.stats.totalMinutes}
          </div>
          <div className="profile-stats__label">Total Minutes</div>
        </div>
        <div className="profile-stats__item">
          <div className="profile-stats__value">
            {profile.stats.averageIntensity}
          </div>
          <div className="profile-stats__label">Average Intensity</div>
        </div>
        <div className="profile-stats__item">
          <div className="profile-stats__value">
            {profile.stats.streakDays}
          </div>
          <div className="profile-stats__label">Day Streak</div>
        </div>
      </div>
    </div>
  );
} 