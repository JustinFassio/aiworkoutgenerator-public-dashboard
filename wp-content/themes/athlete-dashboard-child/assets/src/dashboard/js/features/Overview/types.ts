import { DashboardFeature } from '../../components/Dashboard/types';

export interface FeatureCard extends DashboardFeature {
  isEnabled: boolean;
  permissions: string[];
}

export interface OverviewProps {
  features: FeatureCard[];
  currentUser: {
    id: number;
    name: string;
    role: string;
  };
} 