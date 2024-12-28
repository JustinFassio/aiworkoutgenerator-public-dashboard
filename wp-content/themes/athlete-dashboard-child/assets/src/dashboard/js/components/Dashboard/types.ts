import { ModalProps } from '../Modal';

export interface DashboardFeature {
  id: string;
  title: string;
  description: string;
  icon?: string;
  route: string;
  isActive: boolean;
}

export interface DashboardUser {
  id: number;
  name: string;
  email: string;
  avatar?: string;
  role: string;
}

export interface DashboardConfig {
  ajaxUrl: string;
  nonce: string;
  features: DashboardFeature[];
  currentUser: DashboardUser;
  modals: Record<string, Omit<ModalProps, 'isOpen' | 'onClose'>>;
}

export interface DashboardProps {
  config: DashboardConfig;
} 