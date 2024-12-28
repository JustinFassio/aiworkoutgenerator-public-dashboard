import React, { useEffect, useCallback } from 'react';
import { createPortal } from 'react-dom';
import { ModalProps } from './types';

export const Modal: React.FC<ModalProps> = ({
  id,
  title,
  size = 'medium',
  className = '',
  isOpen,
  onClose,
  buttons = [],
  children,
}) => {
  const handleEscape = useCallback((event: KeyboardEvent) => {
    if (event.key === 'Escape') {
      onClose();
    }
  }, [onClose]);

  useEffect(() => {
    if (isOpen) {
      document.addEventListener('keydown', handleEscape);
      document.body.style.overflow = 'hidden';
    }

    return () => {
      document.removeEventListener('keydown', handleEscape);
      document.body.style.overflow = '';
    };
  }, [isOpen, handleEscape]);

  if (!isOpen) return null;

  const modalContent = (
    <div 
      id={id} 
      className={`dashboard-modal ${className} ${isOpen ? 'is-active' : ''}`}
      role="dialog"
      aria-modal="true"
      aria-labelledby={`${id}-title`}
    >
      <div 
        className="modal-backdrop"
        onClick={onClose}
        role="presentation"
      />
      
      <div className={`modal-container modal-container--${size}`}>
        <div className="modal-header">
          <h2 id={`${id}-title`}>{title}</h2>
          <button 
            type="button" 
            className="modal-close"
            onClick={onClose}
            aria-label="Close modal"
          >
            <span className="dashicons dashicons-no-alt" />
          </button>
        </div>

        <div className="modal-content">
          {children}
        </div>

        {buttons.length > 0 && (
          <div className="modal-footer">
            {buttons.map((button, index) => (
              <button
                key={index}
                type="button"
                className={button.className}
                onClick={button.onClick}
                {...button.attrs}
              >
                {button.text}
              </button>
            ))}
          </div>
        )}
      </div>
    </div>
  );

  return createPortal(
    modalContent,
    document.body
  );
}; 