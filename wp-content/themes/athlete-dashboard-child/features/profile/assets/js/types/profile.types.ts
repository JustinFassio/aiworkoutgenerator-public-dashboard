import { DashboardEvents } from '@dashboard/js/events';

export interface ProfileData {
    first_name: string;
    last_name: string;
    email: string;
    phone?: string;
    height: number;
    height_unit: 'metric' | 'imperial';
    weight: number;
    weight_unit: 'metric' | 'imperial';
    date_of_birth: string;
    gender?: 'male' | 'female' | 'other' | 'prefer_not_to_say';
}

export interface ProfileConfig {
    ajaxurl: string;
    nonce: string;
    user_id: number;
    i18n: {
        saveSuccess: string;
        saveError: string;
    };
}

export interface ProfileFormConfig {
    endpoint: string;
    additionalData?: Record<string, any>;
    customFields?: Record<string, (element: HTMLElement) => void>;
}

export interface ProfileModalConfig {
    id: string;
    title: string;
    submitText?: string;
    closeText?: string;
}

// Extend Window interface to include our global config
declare global {
    interface Window {
        profileConfig: ProfileConfig;
    }
}

// Export event types
export type ProfileEvents = {
    'profile:update': ProfileData;
    'profile:save:success': ProfileData;
    'profile:save:error': { message: string };
    'profile:modal:open': void;
    'profile:modal:close': void;
};

// Add type safety to dashboard events
declare module '@dashboard/js/events' {
    interface DashboardEventMap extends ProfileEvents {}
} 