/** @jest-environment jsdom */
import { describe, it, expect, vi } from 'vitest';
import { render, fireEvent } from '@testing-library/react';
import { Modal } from '../Modal';
import type { ModalProps } from '../types';

describe('Modal', () => {
    const defaultProps: ModalProps = {
        isOpen: true,
        onClose: vi.fn(),
        title: 'Test Modal',
        children: <div>Test Content</div>
    };

    beforeEach(() => {
        vi.clearAllMocks();
    });

    it('renders when isOpen is true', () => {
        const { getByText } = render(<Modal {...defaultProps} />);
        expect(getByText('Test Modal')).toBeInTheDocument();
        expect(getByText('Test Content')).toBeInTheDocument();
    });

    it('does not render when isOpen is false', () => {
        const { container } = render(<Modal {...defaultProps} isOpen={false} />);
        expect(container).toBeEmptyDOMElement();
    });

    it('calls onClose when clicking the close button', () => {
        const { getByRole } = render(<Modal {...defaultProps} />);
        fireEvent.click(getByRole('button', { name: /close modal/i }));
        expect(defaultProps.onClose).toHaveBeenCalledTimes(1);
    });

    it('calls onClose when clicking the overlay', () => {
        const { container } = render(<Modal {...defaultProps} />);
        const overlay = container.querySelector('.modal-overlay');
        if (overlay) {
            fireEvent.click(overlay);
            expect(defaultProps.onClose).toHaveBeenCalledTimes(1);
        }
    });

    it('calls onClose when pressing escape', () => {
        render(<Modal {...defaultProps} />);
        fireEvent.keyDown(document, { key: 'Escape' });
        expect(defaultProps.onClose).toHaveBeenCalledTimes(1);
    });

    it('applies custom className', () => {
        const { container } = render(
            <Modal {...defaultProps} className="custom-modal" />
        );
        const modal = container.firstChild as HTMLElement;
        expect(modal).toHaveClass('custom-modal');
    });

    it('manages body overflow style', () => {
        const { rerender } = render(<Modal {...defaultProps} />);
        expect(document.body.style.overflow).toBe('hidden');

        rerender(<Modal {...defaultProps} isOpen={false} />);
        expect(document.body.style.overflow).toBe('');
    });
}); 