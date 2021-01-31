<?php

/**
 * @package  NewsPlugin
 */
/*
Plugin Name: News Plugin
Plugin URI: http://news.emichaa.com
Description: EGT Plugin.
Version: 1.0
Author: Emil Atanasov
Author URI: http://emichaa.com
License: A "Slug" license name e.g. GPL2
Text Domain: egt-news-plugin
*/

defined( 'ABSPATH' ) or die( 'Good luck! :)' );

// Define CONSTANTS
define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PLUGIN', plugin_basename( __FILE__ ) );
define( 'NPTEXTDOMAIN', 'egt-news-plugin' );
define( 'SETTINGS_PAGE_SLUG', 'news_plugin' );
define( 'PLUGIN_NAME', 'News Plugin' );

if ( !class_exists( 'NewsPlugin' ) ) {

    class NewsPlugin
    {
        public $plugin;
        public $pluginSvgIcon;

        function __construct() {
            $this->plugin = PLUGIN;
            $this->pluginSvgIcon = base64_encode( file_get_contents(PLUGIN_PATH . 'assets/images/egt-logo.svg' ) );
            $this->np_init();
        }

        function np_activate() {
            require_once PLUGIN_PATH . 'inc/news-plugin-activate.php';
            NewsPluginActivate::np_activate();
        }

        function np_deactivate() {
            require_once PLUGIN_PATH . 'inc/news-plugin-deactivate.php';
            NewsPluginDeactivate::np_deactivate();
        }

        function np_init(){
            require_once PLUGIN_PATH . 'inc/news-plugin-init.php';
            $NewsPluginInit = new NewsPluginInit();
        }
    }

    // Init class
    $alecadddPlugin = new NewsPlugin();

    // activation
    register_activation_hook( __FILE__, array( $alecadddPlugin, 'np_activate' ) );

    // deactivation
    register_deactivation_hook( __FILE__, array( $alecadddPlugin, 'np_deactivate' ) );

}