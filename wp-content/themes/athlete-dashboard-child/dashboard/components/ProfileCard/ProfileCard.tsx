import { useState } from 'react';
import { useProfile } from '@features/profile/hooks/useProfile';
import type { Profile } from '@features/profile/types/Profile';
import { LoadingSpinner } from '../LoadingSpinner/LoadingSpinner';
import { ErrorMessage } from '../ErrorMessage/ErrorMessage';
import { ProfileModal } from '@features/profile/components/ProfileModal';
import './ProfileCard.scss';

export const ProfileCard: React.FC = () => {
    const [isModalOpen, setIsModalOpen] = useState(false);
    const { profile, isLoading, error } = useProfile();

    if (isLoading) {
        return <LoadingSpinner size="large" />;
    }

    if (error) {
        return <ErrorMessage message={error.message} />;
    }

    if (!profile) {
        return <ErrorMessage message="Profile not found" />;
    }

    const handleEditClick = () => {
        setIsModalOpen(true);
    };

    const handleCloseModal = () => {
        setIsModalOpen(false);
    };

    return (
        <div className="profile-card">
            <div className="profile-card__header">
                <div className="profile-card__avatar">
                    {profile.avatarUrl ? (
                        <img src={profile.avatarUrl} alt={profile.name} />
                    ) : (
                        <div className="profile-card__avatar-placeholder">
                            {profile.name.charAt(0)}
                        </div>
                    )}
                </div>
                <div className="profile-card__info">
                    <h2 className="profile-card__name">{profile.name}</h2>
                    <p className="profile-card__email">{profile.email}</p>
                </div>
            </div>

            <div className="profile-card__stats">
                <div className="profile-card__stat">
                    <span className="profile-card__stat-label">Workouts</span>
                    <span className="profile-card__stat-value">{profile.stats.workoutsCompleted}</span>
                </div>
                <div className="profile-card__stat">
                    <span className="profile-card__stat-label">Minutes</span>
                    <span className="profile-card__stat-value">{profile.stats.totalMinutes}</span>
                </div>
                <div className="profile-card__stat">
                    <span className="profile-card__stat-label">Streak</span>
                    <span className="profile-card__stat-value">{profile.stats.streakDays} days</span>
                </div>
            </div>

            {profile.bio && (
                <div className="profile-card__bio">
                    <p>{profile.bio}</p>
                </div>
            )}

            <div className="profile-card__actions">
                <button
                    className="profile-card__edit-button"
                    onClick={handleEditClick}
                >
                    Edit Profile
                </button>
            </div>

            {isModalOpen && (
                <ProfileModal
                    profile={profile}
                    onClose={handleCloseModal}
                />
            )}
        </div>
    );
}; 