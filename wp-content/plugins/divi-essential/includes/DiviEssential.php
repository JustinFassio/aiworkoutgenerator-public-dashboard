<?php

class DNXTE_DiviEssential extends DiviExtension {

    /**
     * The gettext domain for the extension's translations.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $gettext_domain = 'dnxte-divi-essential';

    /**
     * The extension's WP Plugin name.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $name = 'divi-essential';

    /**
     * The extension's version
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $version = DIVI_ESSENTIAL_VERSION;

    /**
     * DNXTE_DiviEssential constructor.
     *
     * @param string $name
     * @param array  $args
     */
    public function __construct($name = 'divi-essential', $args = array()) {
        $this->plugin_dir = plugin_dir_path(__FILE__);
        $this->plugin_dir_url = plugin_dir_url($this->plugin_dir);

        parent::__construct($name, $args);

    }
}

new DNXTE_DiviEssential;
