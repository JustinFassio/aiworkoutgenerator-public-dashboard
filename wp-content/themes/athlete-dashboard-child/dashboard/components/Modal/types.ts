import type { ReactNode } from 'react';

export interface ModalProps {
    isOpen: boolean;
    onClose: () => void;
    title: string;
    children: ReactNode;
    className?: string;
}

export interface Modal {
    open(): void;
    close(): void;
    destroy(): void;
} 