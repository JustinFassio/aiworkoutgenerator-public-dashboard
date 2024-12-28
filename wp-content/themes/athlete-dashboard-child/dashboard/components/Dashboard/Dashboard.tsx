import React from 'react';
import { Modal } from '@components/Modal';
import type { DashboardProps } from './types';

export const Dashboard: React.FC<DashboardProps> = ({
    children,
    modal
}) => {
    return (
        <div className="dashboard">
            <div className="dashboard__sidebar">
                {/* Sidebar content */}
            </div>
            <div className="dashboard__main">
                <div className="dashboard__content">
                    {children}
                </div>
            </div>
            {modal && <Modal {...modal} />}
        </div>
    );
}; 