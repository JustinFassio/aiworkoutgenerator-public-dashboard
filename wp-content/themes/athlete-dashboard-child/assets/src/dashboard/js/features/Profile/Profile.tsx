import React, { useState } from 'react';
import { ProfileProps } from './types';

export const Profile: React.FC<ProfileProps> = ({ user, onSave }) => {
  const [formData, setFormData] = useState({
    name: user.name,
    email: user.email
  });

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (onSave) {
      await onSave(formData);
    }
  };

  return (
    <div className="dashboard-feature profile-feature">
      <div className="feature-header">
        <h2>Profile Settings</h2>
        <p>Update your personal information and preferences.</p>
      </div>

      <form onSubmit={handleSubmit} className="profile-form">
        <div className="form-group">
          <label htmlFor="name">Name</label>
          <input
            type="text"
            id="name"
            value={formData.name}
            onChange={e => setFormData(prev => ({ ...prev, name: e.target.value }))}
            className="form-control"
          />
        </div>

        <div className="form-group">
          <label htmlFor="email">Email</label>
          <input
            type="email"
            id="email"
            value={formData.email}
            onChange={e => setFormData(prev => ({ ...prev, email: e.target.value }))}
            className="form-control"
          />
        </div>

        <div className="form-actions">
          <button type="submit" className="button button-primary">
            Save Changes
          </button>
        </div>
      </form>
    </div>
  );
}; 