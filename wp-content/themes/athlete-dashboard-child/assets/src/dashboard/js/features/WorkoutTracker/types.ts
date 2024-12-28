export interface Exercise {
  id: number;
  name: string;
  sets: number;
  reps: number;
  weight: number;
  notes?: string;
}

export interface Workout {
  id: number;
  title: string;
  date: string;
  type: string;
  duration: number;
  exercises: Exercise[];
  notes?: string;
  status: 'planned' | 'in_progress' | 'completed';
}

export interface WorkoutFormData {
  title: string;
  type: string;
  date: string;
  duration: number;
  exercises: Omit<Exercise, 'id'>[];
  notes?: string;
}

export interface WorkoutTrackerProps {
  workouts: Workout[];
  workoutTypes: Array<{
    id: string;
    name: string;
  }>;
  onSaveWorkout: (workout: WorkoutFormData) => Promise<void>;
  onUpdateWorkout: (id: number, workout: Partial<Workout>) => Promise<void>;
  onDeleteWorkout: (id: number) => Promise<void>;
} 