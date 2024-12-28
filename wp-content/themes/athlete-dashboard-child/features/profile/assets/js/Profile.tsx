import React from 'react';
import type { FeatureProps } from '@dashboard/types/dashboard';

interface ProfileProps extends FeatureProps {}

export const Profile: React.FC<ProfileProps> = ({ user }) => {
    return (
        <div className="profile">
            <h1>Profile</h1>
            <div className="profile-content">
                <div className="profile-section">
                    <h2>Account Information</h2>
                    <div className="profile-field">
                        <label>User ID</label>
                        <div>{user.id}</div>
                    </div>
                    <div className="profile-field">
                        <label>Roles</label>
                        <div>{user.roles.join(', ')}</div>
                    </div>
                </div>
            </div>
        </div>
    );
}; 