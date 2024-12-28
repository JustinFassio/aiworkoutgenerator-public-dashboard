import React from 'react';
import './LoadingSpinner.scss';

interface LoadingSpinnerProps {
    style?: React.CSSProperties;
    size?: 'small' | 'medium' | 'large';
    'data-testid'?: string;
}

export const LoadingSpinner: React.FC<LoadingSpinnerProps> = ({ 
    style,
    size = 'medium',
    'data-testid': testId = 'loading-spinner'
}) => {
    return (
        <div 
            className={`loading-spinner loading-spinner--${size}`}
            style={style}
            data-testid={testId}
        >
            <div className="loading-spinner__circle" />
        </div>
    );
}; 