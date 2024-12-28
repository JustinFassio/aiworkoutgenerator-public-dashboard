export interface ModalButton {
  text: string;
  className: string;
  onClick?: () => void;
  attrs?: Record<string, string>;
}

export interface ModalProps {
  id: string;
  title: string;
  size?: 'small' | 'medium' | 'large';
  className?: string;
  isOpen: boolean;
  onClose: () => void;
  buttons?: ModalButton[];
  children: React.ReactNode;
} 