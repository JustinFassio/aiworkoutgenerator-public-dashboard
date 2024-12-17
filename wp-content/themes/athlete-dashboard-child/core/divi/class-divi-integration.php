<?php
/**
 * Divi Integration Handler
 */

if (!defined('ABSPATH')) {
    exit;
}

class DiviIntegration {
    public function __construct() {
        $this->init();
    }

    private function init() {
        // Fix Divi pagebuilder path
        add_filter('theme_file_path', array($this, 'fix_pagebuilder_path'), 10, 2);
    }

    public function fix_pagebuilder_path($path, $file) {
        if ($file === '/et-pagebuilder/et-pagebuilder.php') {
            return get_template_directory() . $file;
        }
        return $path;
    }
} 