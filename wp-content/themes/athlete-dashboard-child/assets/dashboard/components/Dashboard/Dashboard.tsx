import React, { useState, useCallback } from 'react';
import { Modal } from '@/components/Modal';
import { DashboardProps } from './types';

export const Dashboard: React.FC<DashboardProps> = ({ config }) => {
  const [activeModal, setActiveModal] = useState<string | null>(null);
  const [isMenuOpen, setIsMenuOpen] = useState(false);

  const handleModalClose = useCallback(() => {
    setActiveModal(null);
  }, []);

  const handleModalOpen = useCallback((modalId: string) => {
    setActiveModal(modalId);
  }, []);

  const toggleMenu = useCallback(() => {
    setIsMenuOpen(prev => !prev);
  }, []);

  return (
    <div className="athlete-dashboard">
      {/* Header */}
      <header className="dashboard-header">
        <div className="header-brand">
          <h1>Athlete Dashboard</h1>
        </div>

        <nav className="header-nav">
          <ul className="header-menu">
            {config.features.map(feature => (
              <li key={feature.id} className={feature.isActive ? 'current' : ''}>
                <a href={feature.route}>
                  {feature.icon && <span className={`dashicons ${feature.icon}`} />}
                  {feature.title}
                </a>
              </li>
            ))}
          </ul>
        </nav>

        <div className="user-menu">
          <button 
            type="button" 
            className="user-menu-toggle"
            onClick={toggleMenu}
            aria-expanded={isMenuOpen}
          >
            {config.currentUser.avatar ? (
              <img 
                src={config.currentUser.avatar} 
                alt={config.currentUser.name}
                className="user-avatar"
              />
            ) : (
              <span className="dashicons dashicons-admin-users" />
            )}
            <span className="user-name">{config.currentUser.name}</span>
          </button>

          {isMenuOpen && (
            <div className="user-menu-dropdown">
              <ul>
                <li>
                  <a href="#profile" onClick={() => handleModalOpen('profile')}>
                    Profile Settings
                  </a>
                </li>
                <li>
                  <a href="#logout">Logout</a>
                </li>
              </ul>
            </div>
          )}
        </div>
      </header>

      {/* Sidebar */}
      <aside className="dashboard-sidebar">
        <nav className="sidebar-nav">
          <ul className="feature-menu">
            {config.features.map(feature => (
              <li key={feature.id} className={feature.isActive ? 'current' : ''}>
                <a href={feature.route}>
                  {feature.icon && <span className={`dashicons ${feature.icon}`} />}
                  {feature.title}
                </a>
              </li>
            ))}
          </ul>
        </nav>
      </aside>

      {/* Main Content */}
      <main className="dashboard-content">
        {/* Content will be rendered by WordPress template */}
      </main>

      {/* Footer */}
      <footer className="dashboard-footer">
        <p>&copy; {new Date().getFullYear()} Athlete Dashboard. All rights reserved.</p>
      </footer>

      {/* Modals */}
      {Object.entries(config.modals).map(([id, modalProps]) => (
        <Modal
          key={id}
          {...modalProps}
          isOpen={activeModal === id}
          onClose={handleModalClose}
        />
      ))}
    </div>
  );
}; 