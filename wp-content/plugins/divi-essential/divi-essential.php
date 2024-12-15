<?php
/*
Plugin Name: Divi Essential
Plugin URI:  www.diviessential.com
Description: Divi extension for next label modules.
Version:     4.7.2
Author:      Divi Next
Author URI:  www.divinext.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: dnxte-divi-essential
Update URI:  https://www.divinext.com
Domain Path: /languages

Divi Essential is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Divi Essential. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

if (!defined('ABSPATH')) {
    exit;
}


final class Divi_Essential {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '4.7.2';
    private static $instance;

    /**
     * Class construcotr
     */
    private function __construct() {

        $this->define_constants();
        register_activation_hook( __FILE__, array($this, 'activate' ) );
        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );

    }

    /**
     * Initializes a singleton instance
     *
     * @return \Divi_Essential
     */
    public static function instance() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Divi_Essential ) ) {
            self::$instance = new Divi_Essential();
            self::$instance->init();
            self::$instance->includes();
        }

        return self::$instance;
    }

    private function init() {
        add_action( 'divi_extensions_init', array( $this, 'initialize_extension' ) );
    }


    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'DIVI_ESSENTIAL_VERSION', self::version );
        define( 'DIVI_ESSENTIAL_FILE', __FILE__ );
        define( 'DIVI_ESSENTIAL_DIR', plugin_dir_path( __FILE__ ) );
        define( 'DIVI_ESSENTIAL_PATH', __DIR__ );
        define( 'DIVI_ESSENTIAL_URL', plugins_url( '', DIVI_ESSENTIAL_FILE ) );
        define( 'DIVI_ESSENTIAL_ASSETS', DIVI_ESSENTIAL_URL . '/assets/' );
        define( 'DIVI_ESSENTIAL_ICON', DIVI_ESSENTIAL_URL . '/includes/modules/' );

        
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {
            new Divi_Essential\Includes\Admin();
            new Divi_Essential\Includes\AssetsManager();
    }

    private function includes() {
        
        require_once DIVI_ESSENTIAL_DIR . 'includes/admin.php';
        require_once DIVI_ESSENTIAL_DIR . 'includes/assets-manager.php';
        require_once DIVI_ESSENTIAL_DIR . 'includes/functions.php';

        
    }

    public function initialize_extension() {
        require_once DIVI_ESSENTIAL_DIR . 'includes/DiviEssential.php';
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installed = get_option( 'divi_essential_installed' );

        if ( ! $installed ) {
            update_option( 'divi_essential_installed', time() );
        }

        update_option( 'divi_essential_version', DIVI_ESSENTIAL_VERSION );
    }
}


/**
 * Initializes the main plugin
 *
 * @return \Divi_Essential
 */
function divi_essential() {
    return Divi_Essential::instance();
}

// Kick--Off the plugin
divi_essential();


