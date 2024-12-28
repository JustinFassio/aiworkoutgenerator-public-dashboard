import React, { useState, useRef, useEffect } from 'react';
import type { GoalsManagerProps } from '../../types/training-persona.types';

export const GoalsManager: React.FC<GoalsManagerProps> = ({
    goals,
    suggestions,
    onChange,
    maxGoals = 5
}) => {
    const [input, setInput] = useState('');
    const [showSuggestions, setShowSuggestions] = useState(false);
    const [filteredSuggestions, setFilteredSuggestions] = useState<string[]>([]);
    const containerRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
        const filtered = suggestions.filter(
            suggestion =>
                suggestion.toLowerCase().includes(input.toLowerCase()) &&
                !goals.includes(suggestion)
        );
        setFilteredSuggestions(filtered);
    }, [input, suggestions, goals]);

    useEffect(() => {
        const handleClickOutside = (event: MouseEvent) => {
            if (
                containerRef.current &&
                !containerRef.current.contains(event.target as Node)
            ) {
                setShowSuggestions(false);
            }
        };

        document.addEventListener('mousedown', handleClickOutside);
        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, []);

    const handleAddGoal = (goal: string) => {
        if (goals.length >= maxGoals) {
            return;
        }

        const trimmedGoal = goal.trim();
        if (trimmedGoal && !goals.includes(trimmedGoal)) {
            onChange([...goals, trimmedGoal]);
            setInput('');
            setShowSuggestions(false);
        }
    };

    const handleRemoveGoal = (goalToRemove: string) => {
        onChange(goals.filter(goal => goal !== goalToRemove));
    };

    const handleKeyDown = (event: React.KeyboardEvent) => {
        if (event.key === 'Enter' && input) {
            event.preventDefault();
            handleAddGoal(input);
        }
    };

    return (
        <div className="goals-manager" ref={containerRef}>
            <label htmlFor="goals-input">Training Goals</label>
            <div className="goals-container">
                <div className="goals-list">
                    {goals.map(goal => (
                        <div key={goal} className="goal-tag">
                            <span className="goal-text">{goal}</span>
                            <button
                                type="button"
                                className="remove-goal"
                                onClick={() => handleRemoveGoal(goal)}
                                aria-label={`Remove ${goal}`}
                            >
                                ×
                            </button>
                        </div>
                    ))}
                </div>

                {goals.length < maxGoals && (
                    <div className="goals-input-container">
                        <input
                            id="goals-input"
                            type="text"
                            value={input}
                            onChange={e => setInput(e.target.value)}
                            onFocus={() => setShowSuggestions(true)}
                            onKeyDown={handleKeyDown}
                            placeholder="Type or select a goal..."
                            aria-label="Add a training goal"
                            maxLength={50}
                        />

                        {showSuggestions && filteredSuggestions.length > 0 && (
                            <div className="suggestions-list" role="listbox">
                                {filteredSuggestions.map(suggestion => (
                                    <div
                                        key={suggestion}
                                        className="suggestion-item"
                                        role="option"
                                        onClick={() => handleAddGoal(suggestion)}
                                        onKeyDown={e => {
                                            if (e.key === 'Enter' || e.key === ' ') {
                                                e.preventDefault();
                                                handleAddGoal(suggestion);
                                            }
                                        }}
                                        tabIndex={0}
                                    >
                                        {suggestion}
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                )}
            </div>
            {goals.length >= maxGoals && (
                <div className="goals-limit-message">
                    Maximum {maxGoals} goals reached
                </div>
            )}
        </div>
    );
}; 