import React from 'react';

interface LoadingSpinnerProps {
    size?: 'small' | 'medium' | 'large';
    color?: string;
    className?: string;
}

export const LoadingSpinner: React.FC<LoadingSpinnerProps> = ({
    size = 'medium',
    color = 'currentColor',
    className = ''
}) => {
    const sizeMap = {
        small: 16,
        medium: 24,
        large: 32
    };

    const dimensions = sizeMap[size];

    return (
        <div
            className={`loading-spinner ${className}`}
            role="status"
            aria-label="Loading"
            style={{
                display: 'inline-block',
                width: dimensions,
                height: dimensions
            }}
        >
            <svg
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                style={{
                    width: '100%',
                    height: '100%',
                    animation: 'spin 1s linear infinite'
                }}
            >
                <circle
                    cx="12"
                    cy="12"
                    r="10"
                    stroke={color}
                    strokeWidth="4"
                    strokeDasharray="31.4 31.4"
                    transform="rotate(0 12 12)"
                    opacity="0.25"
                />
                <circle
                    cx="12"
                    cy="12"
                    r="10"
                    stroke={color}
                    strokeWidth="4"
                    strokeDasharray="31.4 31.4"
                    transform="rotate(0 12 12)"
                >
                    <animateTransform
                        attributeName="transform"
                        type="rotate"
                        from="0 12 12"
                        to="360 12 12"
                        dur="1s"
                        repeatCount="indefinite"
                    />
                </circle>
            </svg>
            <style jsx>{`
                @keyframes spin {
                    from {
                        transform: rotate(0deg);
                    }
                    to {
                        transform: rotate(360deg);
                    }
                }
            `}</style>
        </div>
    );
}; 