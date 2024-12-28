import { describe, it, expect, vi } from 'vitest';
import { render, screen, fireEvent } from '@testing-library/react';
import { Modal } from '../Modal';

describe('Modal Component', () => {
  const defaultProps = {
    id: 'test-modal',
    title: 'Test Modal',
    isOpen: true,
    onClose: vi.fn(),
    children: <div>Modal Content</div>,
  };

  it('renders when isOpen is true', () => {
    render(<Modal {...defaultProps} />);
    
    expect(screen.getByRole('dialog')).toBeInTheDocument();
    expect(screen.getByText('Test Modal')).toBeInTheDocument();
    expect(screen.getByText('Modal Content')).toBeInTheDocument();
  });

  it('does not render when isOpen is false', () => {
    render(<Modal {...defaultProps} isOpen={false} />);
    
    expect(screen.queryByRole('dialog')).not.toBeInTheDocument();
  });

  it('calls onClose when clicking the close button', () => {
    render(<Modal {...defaultProps} />);
    
    const closeButton = screen.getByRole('button', { name: /close modal/i });
    fireEvent.click(closeButton);
    
    expect(defaultProps.onClose).toHaveBeenCalledTimes(1);
  });

  it('calls onClose when clicking the backdrop', () => {
    render(<Modal {...defaultProps} />);
    
    const backdrop = screen.getByRole('presentation');
    fireEvent.click(backdrop);
    
    expect(defaultProps.onClose).toHaveBeenCalledTimes(1);
  });

  it('calls onClose when pressing Escape key', () => {
    render(<Modal {...defaultProps} />);
    
    fireEvent.keyDown(document, { key: 'Escape' });
    
    expect(defaultProps.onClose).toHaveBeenCalledTimes(1);
  });

  it('renders with custom className', () => {
    render(<Modal {...defaultProps} className="custom-modal" />);
    
    expect(screen.getByRole('dialog')).toHaveClass('custom-modal');
  });

  it('renders with different sizes', () => {
    const { rerender } = render(<Modal {...defaultProps} size="small" />);
    
    expect(screen.getByRole('dialog')).toContainElement(
      screen.getByClassName('modal-container--small')
    );

    rerender(<Modal {...defaultProps} size="large" />);
    expect(screen.getByRole('dialog')).toContainElement(
      screen.getByClassName('modal-container--large')
    );
  });

  it('renders with buttons when provided', () => {
    const buttons = [
      { text: 'Cancel', className: 'button-secondary', onClick: vi.fn() },
      { text: 'Save', className: 'button-primary', onClick: vi.fn() }
    ];

    render(<Modal {...defaultProps} buttons={buttons} />);
    
    const cancelButton = screen.getByRole('button', { name: 'Cancel' });
    const saveButton = screen.getByRole('button', { name: 'Save' });

    expect(cancelButton).toBeInTheDocument();
    expect(saveButton).toBeInTheDocument();

    fireEvent.click(cancelButton);
    expect(buttons[0].onClick).toHaveBeenCalledTimes(1);

    fireEvent.click(saveButton);
    expect(buttons[1].onClick).toHaveBeenCalledTimes(1);
  });
}); 