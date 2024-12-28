import React from 'react';
import { Workout } from '../types';

interface WorkoutListProps {
  workouts: Workout[];
  onEdit: (workout: Workout) => void;
  onDelete: (id: number) => Promise<void>;
  onStatusChange: (id: number, status: Workout['status']) => Promise<void>;
}

export const WorkoutList: React.FC<WorkoutListProps> = ({
  workouts,
  onEdit,
  onDelete,
  onStatusChange
}) => {
  const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
      weekday: 'short',
      month: 'short',
      day: 'numeric'
    });
  };

  const getStatusColor = (status: Workout['status']) => {
    switch (status) {
      case 'completed':
        return 'status-success';
      case 'in_progress':
        return 'status-warning';
      default:
        return 'status-info';
    }
  };

  const getStatusLabel = (status: Workout['status']) => {
    switch (status) {
      case 'completed':
        return 'Completed';
      case 'in_progress':
        return 'In Progress';
      default:
        return 'Planned';
    }
  };

  return (
    <div className="workout-list">
      {workouts.map(workout => (
        <div key={workout.id} className="workout-card">
          <div className="workout-header">
            <div className="workout-title">
              <h3>{workout.title}</h3>
              <span className={`status-badge ${getStatusColor(workout.status)}`}>
                {getStatusLabel(workout.status)}
              </span>
            </div>
            <div className="workout-actions">
              <button
                type="button"
                onClick={() => onEdit(workout)}
                className="button button-small"
                title="Edit workout"
              >
                <span className="dashicons dashicons-edit" />
              </button>
              <button
                type="button"
                onClick={() => onDelete(workout.id)}
                className="button button-small button-danger"
                title="Delete workout"
              >
                <span className="dashicons dashicons-trash" />
              </button>
            </div>
          </div>

          <div className="workout-meta">
            <span className="workout-date">
              <span className="dashicons dashicons-calendar-alt" />
              {formatDate(workout.date)}
            </span>
            <span className="workout-type">
              <span className="dashicons dashicons-tag" />
              {workout.type}
            </span>
            <span className="workout-duration">
              <span className="dashicons dashicons-clock" />
              {workout.duration} minutes
            </span>
          </div>

          <div className="workout-exercises">
            <h4>Exercises</h4>
            <ul className="exercise-list">
              {workout.exercises.map((exercise, index) => (
                <li key={index} className="exercise-item">
                  <span className="exercise-name">{exercise.name}</span>
                  <span className="exercise-details">
                    {exercise.sets} × {exercise.reps} @ {exercise.weight}kg
                  </span>
                </li>
              ))}
            </ul>
          </div>

          {workout.notes && (
            <div className="workout-notes">
              <h4>Notes</h4>
              <p>{workout.notes}</p>
            </div>
          )}

          <div className="workout-footer">
            <select
              value={workout.status}
              onChange={e => onStatusChange(workout.id, e.target.value as Workout['status'])}
              className="status-select"
            >
              <option value="planned">Planned</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
            </select>
          </div>
        </div>
      ))}
    </div>
  );
}; 