import React from 'react';
import { ProfileCard } from './components/ProfileCard/ProfileCard';
import './styles/app.scss';

export const App: React.FC = () => {
    return (
        <div className="dashboard">
            <aside className="dashboard__sidebar">
                <ProfileCard />
            </aside>
            <main className="dashboard__main">
                {/* Feature components will be rendered here */}
            </main>
        </div>
    );
}; 