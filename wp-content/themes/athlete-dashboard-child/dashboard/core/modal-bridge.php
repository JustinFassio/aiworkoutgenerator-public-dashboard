<?php
/**
 * Modal Bridge
 * 
 * Provides functionality to bridge PHP modal system with React modals
 */

namespace AthleteDashboard\Dashboard\Core;

if (!defined('ABSPATH')) {
    exit;
}

class ModalBridge {
    /**
     * Register modal scripts and styles
     */
    public static function init(): void {
        add_action('wp_enqueue_scripts', [self::class, 'enqueueAssets']);
    }

    /**
     * Enqueue modal assets
     */
    public static function enqueueAssets(): void {
        wp_enqueue_script(
            'athlete-dashboard-modal',
            get_stylesheet_directory_uri() . '/assets/dist/dashboard/js/components/Modal/index.js',
            ['react', 'react-dom'],
            filemtime(get_stylesheet_directory() . '/assets/dist/dashboard/js/components/Modal/index.js'),
            true
        );

        // Localize modal data
        wp_localize_script(
            'athlete-dashboard-modal',
            'athleteDashboardModal',
            [
                'nonce' => wp_create_nonce('athlete_dashboard_modal'),
                'ajaxUrl' => admin_url('admin-ajax.php'),
            ]
        );
    }

    /**
     * Render modal container
     * 
     * @param string $id Modal ID
     * @param array $data Modal data to pass to React
     */
    public static function render(string $id, array $data = []): void {
        ?>
        <div id="<?php echo esc_attr("react-modal-{$id}"); ?>"></div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modalRoot = document.getElementById('<?php echo esc_js("react-modal-{$id}"); ?>');
                if (modalRoot && window.athleteDashboard?.Modal) {
                    const modalData = <?php echo wp_json_encode($data); ?>;
                    ReactDOM.render(
                        React.createElement(athleteDashboard.Modal, modalData),
                        modalRoot
                    );
                }
            });
        </script>
        <?php
    }
} 