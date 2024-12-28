# Core Modal Component

## Exception to Feature-First Architecture

The Modal component is one of the few justified exceptions to our strict feature-first architecture. This document explains why this exception exists and how to properly use the component.

### Justification

1. **Consistent User Experience**
   - Modal behavior should be consistent across all features
   - Includes accessibility, keyboard navigation, and animations
   - Maintains a predictable user interface pattern

2. **Technical Considerations**
   - Manages document body scroll locking
   - Handles proper stacking order (z-index)
   - Provides consistent focus management
   - Implements standard keyboard interactions (Escape to close)

3. **Code Efficiency**
   - Prevents duplication of complex modal logic
   - Centralizes bug fixes and improvements
   - Reduces testing overhead

### Usage Guidelines

1. **Keep It Simple**
   - The core Modal component should remain purely presentational
   - No business logic or feature-specific code
   - Minimal dependencies (React only)

2. **Feature Integration**
   ```typescript
   // Example usage in a feature
   const FeatureComponent: React.FC = () => {
       const [isOpen, setIsOpen] = useState(false);
       return (
           <Modal
               isOpen={isOpen}
               onClose={() => setIsOpen(false)}
               title="Feature Modal"
           >
               {/* Feature-specific content */}
           </Modal>
       );
   };
   ```

3. **Feature-Specific Customization**
   - Create feature-specific wrappers when needed
   - Use className prop for custom styling
   - Keep feature-specific logic in the feature's code

### Interface

```typescript
interface ModalProps {
    isOpen: boolean;          // Control modal visibility
    onClose: () => void;      // Handle close events
    title: string;            // Modal title
    children: ReactNode;      // Modal content
    className?: string;       // Custom styling
}
```

### Best Practices

1. **Do**
   - Use for standard dialog/modal patterns
   - Keep modal content in the feature's code
   - Handle feature-specific state management within features
   - Use TypeScript interfaces for type safety

2. **Don't**
   - Add feature-specific logic to the core Modal
   - Create feature-dependent props
   - Modify core modal styles directly
   - Use for non-modal UI patterns

### Testing

1. **Core Testing**
   - Core modal functionality is tested centrally
   - Includes accessibility and keyboard interaction tests
   - Basic rendering and prop validation

2. **Feature Testing**
   - Features should test their specific modal content
   - Test feature-specific interactions
   - Mock modal behavior in feature tests

### Maintenance

The core Modal component should be reviewed periodically to ensure:
1. It remains feature-agnostic
2. No feature-specific code has been added
3. It follows current best practices
4. It maintains accessibility standards

This exception to our feature-first architecture is carefully considered and maintained to provide maximum benefit while minimizing the downsides of shared code. 