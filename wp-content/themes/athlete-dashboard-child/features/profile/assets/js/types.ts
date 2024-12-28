export interface ProfileUser {
  name: string;
  email: string;
  athlete_type: 'beginner' | 'intermediate' | 'advanced';
}

export interface ProfileFormData {
  name: string;
  email: string;
  athlete_type: 'beginner' | 'intermediate' | 'advanced';
}

export interface ProfileProps {
  user: ProfileUser;
  onSave?: (data: ProfileFormData) => Promise<void>;
} 