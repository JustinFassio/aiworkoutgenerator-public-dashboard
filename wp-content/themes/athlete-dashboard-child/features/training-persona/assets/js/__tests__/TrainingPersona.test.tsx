import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import { TrainingPersona } from '../TrainingPersona';
import type { DashboardUser } from '@dashboard/types/dashboard';

describe('TrainingPersona Component', () => {
    const mockUser: DashboardUser = {
        id: 1,
        roles: ['athlete']
    };

    const mockData = {
        level: 'intermediate',
        goals: ['Improve strength', 'Increase endurance'],
        preferences: {
            workoutDuration: 60,
            workoutFrequency: 4,
            preferredTypes: ['Strength', 'HIIT', 'Cardio']
        }
    };

    it('renders without crashing', () => {
        render(<TrainingPersona user={mockUser} data={mockData} />);
        expect(screen.getByText('Training Persona')).toBeInTheDocument();
    });

    it('displays training level correctly', () => {
        render(<TrainingPersona user={mockUser} data={mockData} />);
        expect(screen.getByText('Your Training Level')).toBeInTheDocument();
        expect(screen.getByText('intermediate')).toBeInTheDocument();
    });

    it('displays training goals correctly', () => {
        render(<TrainingPersona user={mockUser} data={mockData} />);
        expect(screen.getByText('Your Goals')).toBeInTheDocument();
        mockData.goals.forEach(goal => {
            expect(screen.getByText(goal)).toBeInTheDocument();
        });
    });

    it('displays training preferences correctly', () => {
        render(<TrainingPersona user={mockUser} data={mockData} />);
        expect(screen.getByText('Training Preferences')).toBeInTheDocument();
        expect(screen.getByText('60 minutes')).toBeInTheDocument();
        expect(screen.getByText('4 times per week')).toBeInTheDocument();
        mockData.preferences.preferredTypes.forEach(type => {
            expect(screen.getByText(type, { exact: false })).toBeInTheDocument();
        });
    });

    it('opens edit modal when clicking edit button', () => {
        render(<TrainingPersona user={mockUser} data={mockData} />);
        fireEvent.click(screen.getByText('Edit Training Persona'));
        expect(screen.getByRole('dialog')).toBeInTheDocument();
        expect(screen.getByText('Edit Training Persona')).toBeInTheDocument();
    });

    describe('Edit Form', () => {
        beforeEach(() => {
            render(<TrainingPersona user={mockUser} data={mockData} />);
            fireEvent.click(screen.getByText('Edit Training Persona'));
        });

        it('pre-fills form with current data', () => {
            expect(screen.getByDisplayValue('intermediate')).toBeInTheDocument();
            expect(screen.getByDisplayValue('60')).toBeInTheDocument();
            expect(screen.getByDisplayValue('4')).toBeInTheDocument();
        });

        it('shows all training level options', () => {
            const select = screen.getByLabelText('Training Level');
            expect(select).toBeInTheDocument();
            ['Beginner', 'Intermediate', 'Advanced'].forEach(level => {
                expect(screen.getByText(level)).toBeInTheDocument();
            });
        });

        it('allows updating workout duration', () => {
            const input = screen.getByLabelText('Workout Duration');
            fireEvent.change(input, { target: { value: '45' } });
            expect(input).toHaveValue(45);
        });

        it('allows updating workout frequency', () => {
            const input = screen.getByLabelText('Weekly Frequency');
            fireEvent.change(input, { target: { value: '3' } });
            expect(input).toHaveValue(3);
        });

        it('shows current training goals as tags', () => {
            mockData.goals.forEach(goal => {
                expect(screen.getByText(goal)).toBeInTheDocument();
            });
        });

        it('allows removing training goals', () => {
            const firstGoal = mockData.goals[0];
            const removeButton = screen.getByLabelText(`Remove ${firstGoal}`);
            fireEvent.click(removeButton);
            expect(screen.queryByText(firstGoal)).not.toBeInTheDocument();
        });

        it('allows adding new training goals', async () => {
            const input = screen.getByPlaceholderText('Type or select...');
            fireEvent.change(input, { target: { value: 'Weight loss' } });
            const suggestion = await screen.findByText('Weight loss');
            fireEvent.click(suggestion);
            expect(screen.getByText('Weight loss')).toBeInTheDocument();
        });

        it('closes modal when clicking cancel', () => {
            fireEvent.click(screen.getByText('Cancel'));
            expect(screen.queryByRole('dialog')).not.toBeInTheDocument();
        });

        it('shows loading state when saving', async () => {
            fireEvent.click(screen.getByText('Save Changes'));
            expect(screen.getByText('Saving...')).toBeInTheDocument();
            await waitFor(() => {
                expect(screen.queryByText('Saving...')).not.toBeInTheDocument();
            });
        });
    });
}); 