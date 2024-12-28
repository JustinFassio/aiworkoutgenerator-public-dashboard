import React, { useState } from 'react';
import { WorkoutFormData, Exercise } from '../types';

interface WorkoutFormProps {
  initialData?: Partial<WorkoutFormData>;
  workoutTypes: Array<{ id: string; name: string; }>;
  onSubmit: (data: WorkoutFormData) => Promise<void>;
  onCancel: () => void;
}

export const WorkoutForm: React.FC<WorkoutFormProps> = ({
  initialData,
  workoutTypes,
  onSubmit,
  onCancel
}) => {
  const [formData, setFormData] = useState<WorkoutFormData>({
    title: initialData?.title ?? '',
    type: initialData?.type ?? workoutTypes[0]?.id ?? '',
    date: initialData?.date ?? new Date().toISOString().split('T')[0],
    duration: initialData?.duration ?? 60,
    exercises: initialData?.exercises ?? [],
    notes: initialData?.notes ?? ''
  });

  const [newExercise, setNewExercise] = useState<Omit<Exercise, 'id'>>({
    name: '',
    sets: 3,
    reps: 10,
    weight: 0,
    notes: ''
  });

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    await onSubmit(formData);
  };

  const addExercise = () => {
    if (newExercise.name) {
      setFormData(prev => ({
        ...prev,
        exercises: [...prev.exercises, newExercise]
      }));
      setNewExercise({
        name: '',
        sets: 3,
        reps: 10,
        weight: 0,
        notes: ''
      });
    }
  };

  const removeExercise = (index: number) => {
    setFormData(prev => ({
      ...prev,
      exercises: prev.exercises.filter((_, i) => i !== index)
    }));
  };

  return (
    <form onSubmit={handleSubmit} className="workout-form">
      <div className="form-group">
        <label htmlFor="title">Workout Title</label>
        <input
          type="text"
          id="title"
          value={formData.title}
          onChange={e => setFormData(prev => ({ ...prev, title: e.target.value }))}
          required
          className="form-control"
        />
      </div>

      <div className="form-group">
        <label htmlFor="type">Workout Type</label>
        <select
          id="type"
          value={formData.type}
          onChange={e => setFormData(prev => ({ ...prev, type: e.target.value }))}
          required
          className="form-control"
        >
          {workoutTypes.map(type => (
            <option key={type.id} value={type.id}>
              {type.name}
            </option>
          ))}
        </select>
      </div>

      <div className="form-row">
        <div className="form-group">
          <label htmlFor="date">Date</label>
          <input
            type="date"
            id="date"
            value={formData.date}
            onChange={e => setFormData(prev => ({ ...prev, date: e.target.value }))}
            required
            className="form-control"
          />
        </div>

        <div className="form-group">
          <label htmlFor="duration">Duration (minutes)</label>
          <input
            type="number"
            id="duration"
            value={formData.duration}
            onChange={e => setFormData(prev => ({ ...prev, duration: parseInt(e.target.value) }))}
            min="1"
            required
            className="form-control"
          />
        </div>
      </div>

      <div className="exercises-section">
        <h3>Exercises</h3>
        
        <div className="exercise-list">
          {formData.exercises.map((exercise, index) => (
            <div key={index} className="exercise-item">
              <div className="exercise-header">
                <h4>{exercise.name}</h4>
                <button
                  type="button"
                  onClick={() => removeExercise(index)}
                  className="button button-small button-danger"
                >
                  Remove
                </button>
              </div>
              <div className="exercise-details">
                <span>{exercise.sets} sets</span>
                <span>{exercise.reps} reps</span>
                <span>{exercise.weight}kg</span>
              </div>
              {exercise.notes && (
                <div className="exercise-notes">{exercise.notes}</div>
              )}
            </div>
          ))}
        </div>

        <div className="add-exercise">
          <div className="form-row">
            <input
              type="text"
              placeholder="Exercise name"
              value={newExercise.name}
              onChange={e => setNewExercise(prev => ({ ...prev, name: e.target.value }))}
              className="form-control"
            />
            <input
              type="number"
              placeholder="Sets"
              value={newExercise.sets}
              onChange={e => setNewExercise(prev => ({ ...prev, sets: parseInt(e.target.value) }))}
              min="1"
              className="form-control"
            />
            <input
              type="number"
              placeholder="Reps"
              value={newExercise.reps}
              onChange={e => setNewExercise(prev => ({ ...prev, reps: parseInt(e.target.value) }))}
              min="1"
              className="form-control"
            />
            <input
              type="number"
              placeholder="Weight (kg)"
              value={newExercise.weight}
              onChange={e => setNewExercise(prev => ({ ...prev, weight: parseInt(e.target.value) }))}
              min="0"
              className="form-control"
            />
          </div>
          <button
            type="button"
            onClick={addExercise}
            className="button button-secondary"
          >
            Add Exercise
          </button>
        </div>
      </div>

      <div className="form-group">
        <label htmlFor="notes">Notes</label>
        <textarea
          id="notes"
          value={formData.notes}
          onChange={e => setFormData(prev => ({ ...prev, notes: e.target.value }))}
          className="form-control"
          rows={4}
        />
      </div>

      <div className="form-actions">
        <button type="submit" className="button button-primary">
          Save Workout
        </button>
        <button
          type="button"
          onClick={onCancel}
          className="button button-secondary"
        >
          Cancel
        </button>
      </div>
    </form>
  );
}; 