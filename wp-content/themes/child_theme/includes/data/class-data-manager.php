<?php
/**
 * Base Data Manager Class
 * 
 * Handles common data operations and caching for the theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

abstract class Athlete_Dashboard_Data_Manager {
    /**
     * Cache group for this data manager
     */
    protected $cache_group;

    /**
     * Cache expiration in seconds
     */
    protected $cache_expiration = 3600; // 1 hour default

    /**
     * Error messages
     */
    protected $errors = array();

    /**
     * Initialize the data manager
     */
    public function __construct($cache_group) {
        $this->cache_group = $cache_group;
        $this->init();
    }

    /**
     * Initialize any specific settings
     */
    abstract protected function init();

    /**
     * Get data with caching
     */
    protected function get_cached_data($key, $callback) {
        $cache_key = $this->get_cache_key($key);
        $data = wp_cache_get($cache_key, $this->cache_group);

        if (false === $data) {
            $data = $callback();
            if (!is_wp_error($data)) {
                wp_cache_set($cache_key, $data, $this->cache_group, $this->cache_expiration);
            }
        }

        return $data;
    }

    /**
     * Delete cached data
     */
    protected function delete_cached_data($key) {
        $cache_key = $this->get_cache_key($key);
        wp_cache_delete($cache_key, $this->cache_group);
    }

    /**
     * Generate a cache key
     */
    protected function get_cache_key($key) {
        return sprintf('%s_%s_%s', $this->cache_group, $key, get_current_user_id());
    }

    /**
     * Add an error
     */
    protected function add_error($code, $message, $data = array()) {
        $this->errors[] = new WP_Error($code, $message, $data);
    }

    /**
     * Get all errors
     */
    public function get_errors() {
        return $this->errors;
    }

    /**
     * Check if there are any errors
     */
    public function has_errors() {
        return !empty($this->errors);
    }

    /**
     * Clear all errors
     */
    protected function clear_errors() {
        $this->errors = array();
    }

    /**
     * Log an error
     */
    protected function log_error($message, $data = array()) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log(sprintf(
                '[%s] %s: %s',
                $this->cache_group,
                $message,
                print_r($data, true)
            ));
        }
    }

    /**
     * Begin a database transaction
     */
    protected function begin_transaction() {
        global $wpdb;
        $wpdb->query('START TRANSACTION');
    }

    /**
     * Commit a database transaction
     */
    protected function commit_transaction() {
        global $wpdb;
        $wpdb->query('COMMIT');
    }

    /**
     * Rollback a database transaction
     */
    protected function rollback_transaction() {
        global $wpdb;
        $wpdb->query('ROLLBACK');
    }

    /**
     * Execute a callback within a transaction
     */
    protected function transaction($callback) {
        $this->begin_transaction();
        
        try {
            $result = $callback();
            if ($this->has_errors()) {
                $this->rollback_transaction();
                return false;
            }
            $this->commit_transaction();
            return $result;
        } catch (Exception $e) {
            $this->rollback_transaction();
            $this->add_error('transaction_failed', $e->getMessage());
            $this->log_error('Transaction failed', array(
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ));
            return false;
        }
    }

    /**
     * Sanitize data before database operations
     */
    protected function sanitize_data($data, $format = array()) {
        global $wpdb;
        
        foreach ($data as $key => $value) {
            if (isset($format[$key])) {
                switch ($format[$key]) {
                    case '%d':
                        $data[$key] = intval($value);
                        break;
                    case '%f':
                        $data[$key] = floatval($value);
                        break;
                    case '%s':
                        $data[$key] = sanitize_text_field($value);
                        break;
                }
            } else {
                $data[$key] = sanitize_text_field($value);
            }
        }

        return $data;
    }

    /**
     * Validate required fields
     */
    protected function validate_required_fields($data, $required_fields) {
        foreach ($required_fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $this->add_error(
                    'missing_required_field',
                    sprintf(__('Missing required field: %s', 'athlete-dashboard'), $field)
                );
            }
        }

        return !$this->has_errors();
    }
} 