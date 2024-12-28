import React from 'react';
import { render, screen } from '@testing-library/react';
import { Overview } from '../Overview';
import type { DashboardUser } from '@dashboard/types/dashboard';

describe('Overview Component', () => {
    const mockUser: DashboardUser = {
        id: 1,
        roles: ['athlete']
    };

    const mockFeatures = [
        {
            id: 'profile',
            title: 'Profile',
            description: 'Manage your profile settings',
            icon: 'person',
            isEnabled: true,
            permissions: ['read', 'write'],
            route: '/profile'
        },
        {
            id: 'workout',
            title: 'Workout Tracker',
            description: 'Track your workouts',
            icon: 'fitness',
            isEnabled: true,
            permissions: ['read', 'write'],
            route: '/workout'
        }
    ];

    it('renders without crashing', () => {
        render(<Overview features={mockFeatures} user={mockUser} />);
        expect(screen.getByText('Dashboard Overview')).toBeInTheDocument();
    });

    it('renders all enabled features', () => {
        render(<Overview features={mockFeatures} user={mockUser} />);
        
        mockFeatures.forEach(feature => {
            expect(screen.getByText(feature.title)).toBeInTheDocument();
            expect(screen.getByText(feature.description)).toBeInTheDocument();
        });
    });

    it('does not render disabled features', () => {
        const featuresWithDisabled = [
            ...mockFeatures,
            {
                id: 'disabled',
                title: 'Disabled Feature',
                description: 'This feature is disabled',
                icon: 'block',
                isEnabled: false,
                permissions: ['read'],
                route: '/disabled'
            }
        ];

        render(<Overview features={featuresWithDisabled} user={mockUser} />);
        expect(screen.queryByText('Disabled Feature')).not.toBeInTheDocument();
    });

    it('renders feature links correctly', () => {
        render(<Overview features={mockFeatures} user={mockUser} />);
        
        mockFeatures.forEach(feature => {
            const link = screen.getByRole('link', { name: /access feature/i });
            expect(link).toHaveAttribute('href', feature.route);
        });
    });

    it('renders feature icons when provided', () => {
        render(<Overview features={mockFeatures} user={mockUser} />);
        
        mockFeatures.forEach(feature => {
            const featureCard = screen.getByText(feature.title).closest('.feature-card');
            expect(featureCard).toHaveTextContent(feature.icon || '');
        });
    });

    it('applies correct styling for feature cards', () => {
        render(<Overview features={mockFeatures} user={mockUser} />);
        
        mockFeatures.forEach(feature => {
            const featureCard = screen.getByText(feature.title).closest('.feature-card');
            expect(featureCard).toHaveClass('feature-card');
            expect(featureCard).not.toHaveClass('disabled');
        });
    });
}); 