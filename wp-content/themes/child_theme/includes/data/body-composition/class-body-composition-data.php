<?php
/**
 * Body Composition Data Manager
 * 
 * Handles data operations for body composition tracking
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Athlete_Dashboard_Body_Composition_Data extends Athlete_Dashboard_Data_Manager {
    /**
     * @var string
     */
    private $table_name;

    /**
     * Constructor
     */
    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'athlete_body_composition';
        parent::__construct('body_composition');
    }

    /**
     * Create the database table
     */
    public function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            user_id bigint(20) unsigned NOT NULL,
            date date NOT NULL,
            weight decimal(5,2),
            body_fat decimal(4,2),
            muscle_mass decimal(5,2),
            waist decimal(5,2),
            notes text,
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY user_id (user_id),
            KEY date (date)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Get user's body composition data
     *
     * @param int $user_id
     * @param array $args Optional arguments
     * @return array
     */
    public function get_user_data($user_id, $args = array()) {
        global $wpdb;

        $defaults = array(
            'metric' => 'weight',
            'start_date' => null,
            'end_date' => null,
            'limit' => null,
            'order' => 'DESC'
        );

        $args = wp_parse_args($args, $defaults);
        $where = array('user_id = %d');
        $query_args = array($user_id);

        if ($args['start_date']) {
            $where[] = 'date >= %s';
            $query_args[] = $args['start_date'];
        }

        if ($args['end_date']) {
            $where[] = 'date <= %s';
            $query_args[] = $args['end_date'];
        }

        $limit = $args['limit'] ? ' LIMIT ' . absint($args['limit']) : '';
        $order = sanitize_sql_orderby("date {$args['order']}");
        $where = implode(' AND ', $where);

        $query = $wpdb->prepare(
            "SELECT * FROM {$this->table_name} WHERE {$where} ORDER BY {$order}{$limit}",
            $query_args
        );

        return $wpdb->get_results($query, ARRAY_A);
    }

    /**
     * Save body composition data
     *
     * @param array $data
     * @return bool|int
     */
    public function save_data($data) {
        global $wpdb;

        $defaults = array(
            'weight' => null,
            'body_fat' => null,
            'muscle_mass' => null,
            'waist' => null,
            'notes' => ''
        );

        $data = wp_parse_args($data, $defaults);
        
        // Validate required fields
        if (empty($data['user_id']) || empty($data['date'])) {
            return false;
        }

        // Prepare data for insertion
        $insert_data = array(
            'user_id' => absint($data['user_id']),
            'date' => sanitize_text_field($data['date']),
            'weight' => $data['weight'] ? floatval($data['weight']) : null,
            'body_fat' => $data['body_fat'] ? floatval($data['body_fat']) : null,
            'muscle_mass' => $data['muscle_mass'] ? floatval($data['muscle_mass']) : null,
            'waist' => $data['waist'] ? floatval($data['waist']) : null,
            'notes' => sanitize_textarea_field($data['notes'])
        );

        $result = $wpdb->insert(
            $this->table_name,
            $insert_data,
            array(
                '%d', // user_id
                '%s', // date
                '%f', // weight
                '%f', // body_fat
                '%f', // muscle_mass
                '%f', // waist
                '%s'  // notes
            )
        );

        return $result ? $wpdb->insert_id : false;
    }

    /**
     * Get summary statistics
     *
     * @param int $user_id
     * @param string $metric
     * @return array
     */
    public function get_summary_stats($user_id, $metric = 'weight') {
        global $wpdb;

        $valid_metrics = array('weight', 'body_fat', 'muscle_mass', 'waist');
        if (!in_array($metric, $valid_metrics)) {
            $metric = 'weight';
        }

        $query = $wpdb->prepare(
            "SELECT 
                MIN({$metric}) as min_value,
                MAX({$metric}) as max_value,
                AVG({$metric}) as avg_value,
                (
                    SELECT {$metric}
                    FROM {$this->table_name}
                    WHERE user_id = %d AND {$metric} IS NOT NULL
                    ORDER BY date DESC
                    LIMIT 1
                ) as current_value,
                (
                    SELECT {$metric}
                    FROM {$this->table_name}
                    WHERE user_id = %d AND {$metric} IS NOT NULL
                    ORDER BY date ASC
                    LIMIT 1
                ) as starting_value
            FROM {$this->table_name}
            WHERE user_id = %d AND {$metric} IS NOT NULL",
            $user_id, $user_id, $user_id
        );

        $stats = $wpdb->get_row($query, ARRAY_A);
        
        // Calculate change
        $stats['total_change'] = $stats['current_value'] - $stats['starting_value'];
        $stats['percent_change'] = $stats['starting_value'] ? 
            (($stats['current_value'] - $stats['starting_value']) / $stats['starting_value']) * 100 : 0;

        return $stats;
    }

    /**
     * Delete an entry
     *
     * @param int $entry_id
     * @param int $user_id
     * @return bool
     */
    public function delete_entry($entry_id, $user_id) {
        global $wpdb;

        return $wpdb->delete(
            $this->table_name,
            array(
                'id' => $entry_id,
                'user_id' => $user_id
            ),
            array('%d', '%d')
        );
    }
} 