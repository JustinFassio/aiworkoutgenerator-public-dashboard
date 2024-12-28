export interface Profile {
  id: number;
  name: string;
  email: string;
  bio?: string;
  avatarUrl?: string;
  stats: ProfileStats;
  preferences: ProfilePreferences;
}

export interface ProfileStats {
  workoutsCompleted: number;
  totalMinutes: number;
  averageIntensity: number;
  streakDays: number;
}

export interface ProfilePreferences {
  notifications: boolean;
  weeklyGoal: number;
  preferredWorkoutTypes: string[];
  availableDays: string[];
  timePreference: 'morning' | 'afternoon' | 'evening';
}

export interface ProfileFormData {
  name: string;
  email: string;
  bio: string;
  notifications: boolean;
  weeklyGoal: number;
  preferredWorkoutTypes: string[];
  availableDays: string[];
  timePreference: string;
}

export interface ProfileError {
  field: keyof ProfileFormData;
  message: string;
}

export type ProfileUpdateResponse = {
  success: boolean;
  profile?: Profile;
  errors?: ProfileError[];
}; 