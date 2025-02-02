import React from 'react';

interface ErrorBoundaryProps {
    children: React.ReactNode;
    fallback: React.ComponentType<{ error: Error }>;
}

interface ErrorBoundaryState {
    error: Error | null;
}

export class ErrorBoundary extends React.Component<ErrorBoundaryProps, ErrorBoundaryState> {
    constructor(props: ErrorBoundaryProps) {
        super(props);
        this.state = { error: null };
    }

    static getDerivedStateFromError(error: Error): ErrorBoundaryState {
        return { error };
    }

    componentDidCatch(error: Error, errorInfo: React.ErrorInfo): void {
        // Log error to monitoring service
        console.error('Error caught by boundary:', error, errorInfo);
    }

    render(): React.ReactNode {
        const { error } = this.state;
        const { children, fallback: Fallback } = this.props;

        if (error) {
            return <Fallback error={error} />;
        }

        return children;
    }
} 