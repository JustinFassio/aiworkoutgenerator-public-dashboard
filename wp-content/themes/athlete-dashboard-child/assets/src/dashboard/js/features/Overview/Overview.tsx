import React from 'react';
import { OverviewProps } from './types';

export const Overview: React.FC<OverviewProps> = ({ features, currentUser }) => {
  const hasPermission = (permissions: string[]): boolean => {
    if (!permissions.length) return true;
    return permissions.some(permission => 
      currentUser.role === 'administrator' || 
      permission === currentUser.role
    );
  };

  return (
    <div className="dashboard-feature overview-feature">
      <header className="feature-header">
        <h1>Dashboard Overview</h1>
        <p className="feature-description">
          Welcome back, {currentUser.name}! Access your features and manage your training from here.
        </p>
      </header>

      <div className="feature-grid">
        {features.map(feature => {
          const isAccessible = feature.isEnabled && hasPermission(feature.permissions);
          
          return (
            <div 
              key={feature.id}
              className={`feature-card ${!isAccessible ? 'feature-card--disabled' : ''}`}
              data-feature={feature.id}
            >
              {feature.icon && (
                <div className="feature-icon">
                  <span className={`dashicons ${feature.icon}`} />
                </div>
              )}

              <div className="feature-content">
                <h2>{feature.title}</h2>
                {feature.description && <p>{feature.description}</p>}
              </div>

              {isAccessible ? (
                <a 
                  href={feature.route}
                  className="feature-link"
                  title={`Open ${feature.title}`}
                >
                  Open
                  <span className="dashicons dashicons-arrow-right-alt" />
                </a>
              ) : (
                <div className="feature-status">
                  {!feature.isEnabled ? (
                    <span className="status-text">Coming Soon</span>
                  ) : (
                    <span className="status-text">Restricted Access</span>
                  )}
                </div>
              )}
            </div>
          );
        })}
      </div>
    </div>
  );
}; 