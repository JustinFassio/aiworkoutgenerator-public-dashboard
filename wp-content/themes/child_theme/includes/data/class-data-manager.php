<?php
/**
 * Base Data Manager Class
 * 
 * Provides common functionality for all data managers
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

abstract class Athlete_Dashboard_Data_Manager {
    /**
     * Cache group for this data manager
     *
     * @var string
     */
    protected $cache_group;

    /**
     * Initialize the data manager
     *
     * @param string $cache_group The cache group for this manager
     */
    public function __construct($cache_group = '') {
        if ($cache_group) {
            $this->cache_group = $cache_group;
        }
        
        $this->init();
    }

    /**
     * Initialize any specific settings
     * Child classes should override this if needed
     */
    protected function init() {}

    /**
     * Get cached data
     *
     * @param string $key Cache key
     * @param callable $callback Callback to generate data if not cached
     * @param int $expiration Cache expiration in seconds
     * @return mixed Cached data
     */
    protected function get_cached_data($key, $callback, $expiration = 3600) {
        $cached = wp_cache_get($key, $this->cache_group);
        if ($cached !== false) {
            return $cached;
        }

        $data = $callback();
        wp_cache_set($key, $data, $this->cache_group, $expiration);

        return $data;
    }

    /**
     * Clear cached data
     *
     * @param string $key Cache key
     * @return bool True on success, false on failure
     */
    protected function clear_cached_data($key) {
        return wp_cache_delete($key, $this->cache_group);
    }

    /**
     * Clear all cached data for this group
     */
    protected function clear_all_cached_data() {
        wp_cache_delete_group($this->cache_group);
    }

    /**
     * Sanitize a value based on type
     *
     * @param mixed $value The value to sanitize
     * @param string $type The type of sanitization to perform
     * @return mixed Sanitized value
     */
    protected function sanitize_value($value, $type = 'text') {
        switch ($type) {
            case 'int':
                return intval($value);
            case 'float':
                return floatval($value);
            case 'email':
                return sanitize_email($value);
            case 'url':
                return esc_url_raw($value);
            case 'textarea':
                return sanitize_textarea_field($value);
            case 'array':
                return array_map(array($this, 'sanitize_value'), (array) $value);
            case 'html':
                return wp_kses_post($value);
            default:
                return sanitize_text_field($value);
        }
    }

    /**
     * Validate data against a schema
     *
     * @param array $data The data to validate
     * @param array $schema The validation schema
     * @return array|WP_Error Validated data or error object
     */
    protected function validate_data($data, $schema) {
        $errors = new WP_Error();
        $validated = array();

        foreach ($schema as $field => $rules) {
            // Check required fields
            if (!empty($rules['required']) && !isset($data[$field])) {
                $errors->add(
                    'missing_required',
                    sprintf(__('Field "%s" is required', 'athlete-dashboard'), $field)
                );
                continue;
            }

            // Skip if field is not present and not required
            if (!isset($data[$field])) {
                continue;
            }

            $value = $data[$field];

            // Type validation
            if (!empty($rules['type'])) {
                switch ($rules['type']) {
                    case 'number':
                        if (!is_numeric($value)) {
                            $errors->add(
                                'invalid_type',
                                sprintf(__('Field "%s" must be a number', 'athlete-dashboard'), $field)
                            );
                            continue 2;
                        }
                        break;
                    case 'boolean':
                        if (!is_bool($value) && $value !== '0' && $value !== '1') {
                            $errors->add(
                                'invalid_type',
                                sprintf(__('Field "%s" must be a boolean', 'athlete-dashboard'), $field)
                            );
                            continue 2;
                        }
                        break;
                    case 'array':
                        if (!is_array($value)) {
                            $errors->add(
                                'invalid_type',
                                sprintf(__('Field "%s" must be an array', 'athlete-dashboard'), $field)
                            );
                            continue 2;
                        }
                        break;
                }
            }

            // Range validation for numbers
            if (is_numeric($value)) {
                if (isset($rules['min']) && $value < $rules['min']) {
                    $errors->add(
                        'out_of_range',
                        sprintf(__('Field "%s" must be at least %s', 'athlete-dashboard'), $field, $rules['min'])
                    );
                    continue;
                }
                if (isset($rules['max']) && $value > $rules['max']) {
                    $errors->add(
                        'out_of_range',
                        sprintf(__('Field "%s" must not exceed %s', 'athlete-dashboard'), $field, $rules['max'])
                    );
                    continue;
                }
            }

            // Length validation for strings
            if (is_string($value)) {
                if (isset($rules['minLength']) && strlen($value) < $rules['minLength']) {
                    $errors->add(
                        'too_short',
                        sprintf(__('Field "%s" must be at least %d characters', 'athlete-dashboard'), $field, $rules['minLength'])
                    );
                    continue;
                }
                if (isset($rules['maxLength']) && strlen($value) > $rules['maxLength']) {
                    $errors->add(
                        'too_long',
                        sprintf(__('Field "%s" must not exceed %d characters', 'athlete-dashboard'), $field, $rules['maxLength'])
                    );
                    continue;
                }
            }

            // Pattern validation
            if (!empty($rules['pattern']) && !preg_match($rules['pattern'], $value)) {
                $errors->add(
                    'pattern_mismatch',
                    sprintf(__('Field "%s" has an invalid format', 'athlete-dashboard'), $field)
                );
                continue;
            }

            // Custom validation
            if (!empty($rules['validate']) && is_callable($rules['validate'])) {
                $validation_result = call_user_func($rules['validate'], $value);
                if (is_wp_error($validation_result)) {
                    $errors->add(
                        'custom_validation',
                        sprintf(__('Field "%s": %s', 'athlete-dashboard'), $field, $validation_result->get_error_message())
                    );
                    continue;
                }
            }

            // Sanitization
            if (!empty($rules['sanitize'])) {
                $value = $this->sanitize_value($value, $rules['sanitize']);
            }

            $validated[$field] = $value;
        }

        if ($errors->has_errors()) {
            return $errors;
        }

        return $validated;
    }

    /**
     * Log an error message
     *
     * @param string $message Error message
     * @param mixed $data Optional data to log
     */
    protected function log_error($message, $data = null) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log(sprintf(
                '[%s] %s - Data: %s',
                get_class($this),
                $message,
                print_r($data, true)
            ));
        }
    }

    /**
     * Check if user has required capability
     *
     * @param string $capability The capability to check
     * @param int $object_id Optional. Object ID to check capability against
     * @return bool True if user has capability, false otherwise
     */
    protected function user_can($capability, $object_id = null) {
        if (!is_user_logged_in()) {
            return false;
        }

        if ($object_id) {
            return current_user_can($capability, $object_id);
        }

        return current_user_can($capability);
    }
} 