# Workout Feature

## Overview

The Workout feature manages the creation, retrieval, updating, and deletion of workout plans in the Athlete Dashboard. It provides a REST API for managing workout data and registers a custom post type for storing workouts.

## Architecture

### Components

- `WorkoutFeature`: Main feature class implementing `FeatureInterface`
- `WorkoutEndpoints`: REST API endpoints for workout management

### Data Model

Workouts are stored as WordPress custom post type with the following structure:

- Post Type: `workout`
- Meta Fields:
  - `workout_data`: JSON object containing workout details

## API Endpoints

Base URL: `/athlete-dashboard/v1/workouts`

### List Workouts
- Method: `GET`
- Endpoint: `/`
- Response: Array of workout objects

### Get Single Workout
- Method: `GET`
- Endpoint: `/{id}`
- Response: Single workout object

### Create Workout
- Method: `POST`
- Endpoint: `/`
- Body:
  ```json
  {
    "title": "Workout Title",
    "workout_data": {
      // Workout specific data
    }
  }
  ```

### Update Workout
- Method: `PUT`
- Endpoint: `/{id}`
- Body: Same as create

### Delete Workout
- Method: `DELETE`
- Endpoint: `/{id}`

## Usage

To enable the feature:

```php
use AthleteDashboard\Features\Workout\WorkoutFeature;

// Register the feature
WorkoutFeature::register();
```

## Development

### Adding New Fields

1. Update the post type registration in `WorkoutFeature`
2. Add new fields to the meta data in `WorkoutEndpoints`
3. Update the response preparation in `prepare_workout_response`

### Testing

Run the feature tests:

```bash
composer test features/workout
``` 