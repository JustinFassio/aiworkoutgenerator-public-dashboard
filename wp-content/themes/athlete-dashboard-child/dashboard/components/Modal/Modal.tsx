import React, { useEffect, useCallback } from 'react';
import type { ModalProps } from './types';

export const Modal: React.FC<ModalProps> = ({
    isOpen,
    onClose,
    title,
    children,
    className = ''
}) => {
    const handleEscape = useCallback((e: KeyboardEvent) => {
        if (e.key === 'Escape' && isOpen) {
            onClose();
        }
    }, [isOpen, onClose]);

    useEffect(() => {
        document.addEventListener('keydown', handleEscape);
        return () => {
            document.removeEventListener('keydown', handleEscape);
        };
    }, [handleEscape]);

    useEffect(() => {
        if (isOpen) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
        return () => {
            document.body.style.overflow = '';
        };
    }, [isOpen]);

    if (!isOpen) return null;

    return (
        <div className={`modal ${className}`}>
            <div className="modal-overlay" onClick={onClose} />
            <div className="modal-container">
                <div className="modal-header">
                    <h2>{title}</h2>
                    <button 
                        type="button" 
                        className="modal-close" 
                        onClick={onClose}
                        aria-label="Close modal"
                    >
                        &times;
                    </button>
                </div>
                <div className="modal-content">
                    {children}
                </div>
            </div>
        </div>
    );
}; 