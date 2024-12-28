import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import { Profile } from '../Profile';
import type { DashboardUser } from '@dashboard/types/dashboard';

describe('Profile Component', () => {
    const mockUser: DashboardUser = {
        id: 1,
        roles: ['athlete'],
        profile: {
            firstName: 'John',
            lastName: 'Doe',
            email: 'john.doe@example.com',
            age: 30,
            height: 180,
            weight: 75,
            gender: 'male',
            fitnessLevel: 'intermediate',
            bio: 'Passionate about fitness and healthy living',
            avatar: 'path/to/avatar.jpg',
            preferences: {
                notifications: true,
                privacySettings: {
                    showProfile: true,
                    showWorkouts: true,
                    showProgress: true
                }
            }
        }
    };

    it('renders without crashing', () => {
        render(<Profile user={mockUser} />);
        expect(screen.getByText('Profile')).toBeInTheDocument();
    });

    it('displays user information correctly', () => {
        render(<Profile user={mockUser} />);
        expect(screen.getByText(`${mockUser.profile.firstName} ${mockUser.profile.lastName}`)).toBeInTheDocument();
        expect(screen.getByText(mockUser.profile.email)).toBeInTheDocument();
        expect(screen.getByText(`${mockUser.profile.age} years old`)).toBeInTheDocument();
        expect(screen.getByText(`${mockUser.profile.height} cm`)).toBeInTheDocument();
        expect(screen.getByText(`${mockUser.profile.weight} kg`)).toBeInTheDocument();
    });

    it('displays user bio', () => {
        render(<Profile user={mockUser} />);
        expect(screen.getByText(mockUser.profile.bio)).toBeInTheDocument();
    });

    it('displays user avatar', () => {
        render(<Profile user={mockUser} />);
        const avatar = screen.getByAltText('Profile Avatar') as HTMLImageElement;
        expect(avatar.src).toContain(mockUser.profile.avatar);
    });

    it('opens edit modal when clicking edit button', () => {
        render(<Profile user={mockUser} />);
        fireEvent.click(screen.getByText('Edit Profile'));
        expect(screen.getByRole('dialog')).toBeInTheDocument();
        expect(screen.getByText('Edit Profile')).toBeInTheDocument();
    });

    describe('Edit Form', () => {
        beforeEach(() => {
            render(<Profile user={mockUser} />);
            fireEvent.click(screen.getByText('Edit Profile'));
        });

        it('pre-fills form with current user data', () => {
            expect(screen.getByDisplayValue(mockUser.profile.firstName)).toBeInTheDocument();
            expect(screen.getByDisplayValue(mockUser.profile.lastName)).toBeInTheDocument();
            expect(screen.getByDisplayValue(mockUser.profile.email)).toBeInTheDocument();
            expect(screen.getByDisplayValue(mockUser.profile.age.toString())).toBeInTheDocument();
            expect(screen.getByDisplayValue(mockUser.profile.height.toString())).toBeInTheDocument();
            expect(screen.getByDisplayValue(mockUser.profile.weight.toString())).toBeInTheDocument();
        });

        it('allows updating personal information', () => {
            const firstNameInput = screen.getByLabelText('First Name');
            const lastNameInput = screen.getByLabelText('Last Name');
            const emailInput = screen.getByLabelText('Email');

            fireEvent.change(firstNameInput, { target: { value: 'Jane' } });
            fireEvent.change(lastNameInput, { target: { value: 'Smith' } });
            fireEvent.change(emailInput, { target: { value: 'jane.smith@example.com' } });

            expect(firstNameInput).toHaveValue('Jane');
            expect(lastNameInput).toHaveValue('Smith');
            expect(emailInput).toHaveValue('jane.smith@example.com');
        });

        it('allows updating physical attributes', () => {
            const ageInput = screen.getByLabelText('Age');
            const heightInput = screen.getByLabelText('Height (cm)');
            const weightInput = screen.getByLabelText('Weight (kg)');

            fireEvent.change(ageInput, { target: { value: '31' } });
            fireEvent.change(heightInput, { target: { value: '182' } });
            fireEvent.change(weightInput, { target: { value: '77' } });

            expect(ageInput).toHaveValue(31);
            expect(heightInput).toHaveValue(182);
            expect(weightInput).toHaveValue(77);
        });

        it('allows updating fitness level', () => {
            const select = screen.getByLabelText('Fitness Level');
            fireEvent.change(select, { target: { value: 'advanced' } });
            expect(select).toHaveValue('advanced');
        });

        it('allows updating bio', () => {
            const bioInput = screen.getByLabelText('Bio');
            fireEvent.change(bioInput, { target: { value: 'Updated bio text' } });
            expect(bioInput).toHaveValue('Updated bio text');
        });

        it('allows updating privacy settings', () => {
            const showProfileToggle = screen.getByLabelText('Show Profile');
            const showWorkoutsToggle = screen.getByLabelText('Show Workouts');
            const showProgressToggle = screen.getByLabelText('Show Progress');

            fireEvent.click(showProfileToggle);
            fireEvent.click(showWorkoutsToggle);
            fireEvent.click(showProgressToggle);

            expect(showProfileToggle).not.toBeChecked();
            expect(showWorkoutsToggle).not.toBeChecked();
            expect(showProgressToggle).not.toBeChecked();
        });

        it('allows updating notification preferences', () => {
            const notificationsToggle = screen.getByLabelText('Enable Notifications');
            fireEvent.click(notificationsToggle);
            expect(notificationsToggle).not.toBeChecked();
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

    describe('Avatar Upload', () => {
        it('allows uploading new avatar', async () => {
            render(<Profile user={mockUser} />);
            fireEvent.click(screen.getByText('Edit Profile'));

            const file = new File(['avatar'], 'avatar.png', { type: 'image/png' });
            const fileInput = screen.getByLabelText('Upload Avatar');

            Object.defineProperty(fileInput, 'files', {
                value: [file]
            });

            fireEvent.change(fileInput);

            expect(screen.getByText('Uploading...')).toBeInTheDocument();
            await waitFor(() => {
                expect(screen.queryByText('Uploading...')).not.toBeInTheDocument();
                expect(screen.getByText('Avatar updated successfully')).toBeInTheDocument();
            });
        });

        it('shows error message for invalid file type', async () => {
            render(<Profile user={mockUser} />);
            fireEvent.click(screen.getByText('Edit Profile'));

            const file = new File(['invalid'], 'invalid.txt', { type: 'text/plain' });
            const fileInput = screen.getByLabelText('Upload Avatar');

            Object.defineProperty(fileInput, 'files', {
                value: [file]
            });

            fireEvent.change(fileInput);

            expect(screen.getByText('Invalid file type. Please upload an image.')).toBeInTheDocument();
        });
    });
}); 