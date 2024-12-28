import React from 'react';
import type { FeatureProps } from '@dashboard/types/dashboard';

interface OverviewFeature {
    id: string;
    title: string;
    description: string;
    icon?: string;
    isEnabled: boolean;
    permissions: string[];
    route: string;
}

interface OverviewProps extends FeatureProps {
    features: OverviewFeature[];
}

export const Overview: React.FC<OverviewProps> = ({ features }) => {
    return (
        <div className="overview">
            <h1>Dashboard Overview</h1>
            <div className="feature-grid">
                {features.map(feature => (
                    <div key={feature.id} className={`feature-card ${!feature.isEnabled ? 'disabled' : ''}`}>
                        {feature.icon && <div className="feature-icon">{feature.icon}</div>}
                        <h3>{feature.title}</h3>
                        <p>{feature.description}</p>
                        {feature.isEnabled && (
                            <a href={feature.route} className="feature-link">
                                Access Feature
                            </a>
                        )}
                    </div>
                ))}
            </div>
        </div>
    );
}; 