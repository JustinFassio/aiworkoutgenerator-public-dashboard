import React, { useState } from 'react';
import { Modal } from '../../components/Modal';
import { WorkoutForm } from './components/WorkoutForm';
import { WorkoutList } from './components/WorkoutList';
import { WorkoutTrackerProps, Workout, WorkoutFormData } from './types';

export const WorkoutTracker: React.FC<WorkoutTrackerProps> = ({
  workouts: initialWorkouts,
  workoutTypes,
  onSaveWorkout,
  onUpdateWorkout,
  onDeleteWorkout
}) => {
  const [workouts, setWorkouts] = useState(initialWorkouts);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [editingWorkout, setEditingWorkout] = useState<Workout | null>(null);

  const handleSave = async (data: WorkoutFormData) => {
    try {
      await onSaveWorkout(data);
      setIsModalOpen(false);
      setEditingWorkout(null);
      // Refresh workouts from server
    } catch (error) {
      console.error('Failed to save workout:', error);
    }
  };

  const handleEdit = (workout: Workout) => {
    setEditingWorkout(workout);
    setIsModalOpen(true);
  };

  const handleDelete = async (id: number) => {
    if (!confirm('Are you sure you want to delete this workout?')) {
      return;
    }

    try {
      await onDeleteWorkout(id);
      setWorkouts(prev => prev.filter(w => w.id !== id));
    } catch (error) {
      console.error('Failed to delete workout:', error);
    }
  };

  const handleStatusChange = async (id: number, status: Workout['status']) => {
    try {
      await onUpdateWorkout(id, { status });
      setWorkouts(prev =>
        prev.map(workout =>
          workout.id === id ? { ...workout, status } : workout
        )
      );
    } catch (error) {
      console.error('Failed to update workout status:', error);
    }
  };

  return (
    <div className="dashboard-feature workout-tracker">
      <header className="feature-header">
        <div className="feature-title">
          <h1>Workout Tracker</h1>
          <p>Track and manage your workouts</p>
        </div>
        <button
          type="button"
          onClick={() => {
            setEditingWorkout(null);
            setIsModalOpen(true);
          }}
          className="button button-primary"
        >
          Add Workout
        </button>
      </header>

      <div className="workout-filters">
        <div className="filter-group">
          <label htmlFor="status-filter">Status</label>
          <select id="status-filter" className="form-control">
            <option value="all">All</option>
            <option value="planned">Planned</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
          </select>
        </div>

        <div className="filter-group">
          <label htmlFor="type-filter">Type</label>
          <select id="type-filter" className="form-control">
            <option value="all">All Types</option>
            {workoutTypes.map(type => (
              <option key={type.id} value={type.id}>
                {type.name}
              </option>
            ))}
          </select>
        </div>
      </div>

      <WorkoutList
        workouts={workouts}
        onEdit={handleEdit}
        onDelete={handleDelete}
        onStatusChange={handleStatusChange}
      />

      <Modal
        id="workout-form-modal"
        title={editingWorkout ? 'Edit Workout' : 'Add Workout'}
        isOpen={isModalOpen}
        onClose={() => {
          setIsModalOpen(false);
          setEditingWorkout(null);
        }}
      >
        <WorkoutForm
          initialData={editingWorkout ?? undefined}
          workoutTypes={workoutTypes}
          onSubmit={handleSave}
          onCancel={() => {
            setIsModalOpen(false);
            setEditingWorkout(null);
          }}
        />
      </Modal>
    </div>
  );
}; 