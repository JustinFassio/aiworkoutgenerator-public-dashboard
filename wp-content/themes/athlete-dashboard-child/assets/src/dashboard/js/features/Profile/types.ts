export interface ProfileUser {
  name: string;
  email: string;
}

export interface ProfileFormData {
  name: string;
  email: string;
}

export interface ProfileProps {
  user: ProfileUser;
  onSave?: (data: ProfileFormData) => Promise<void>;
} 