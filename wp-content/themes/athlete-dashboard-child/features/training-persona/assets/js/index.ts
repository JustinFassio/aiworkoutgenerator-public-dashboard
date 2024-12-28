import { TrainingPersona } from './TrainingPersona';
import { Events } from '@dashboard/events';
import type { TrainingPersonaData } from '../types/training-persona.types';

// Initialize feature
const container = document.getElementById('training-persona-root');
if (container) {
    const data = (window as any).trainingPersonaData as TrainingPersonaData;
    if (data) {
        Events.emit('training-persona:init', { data });
    }
}

export { TrainingPersona }; 