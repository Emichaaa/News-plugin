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


if ( !class_exists( 'NewsPlugin' ) ) {

    class NewsPlugin
    {

        public $plugin;
        public $pluginSvgIcon;

        function __construct() {
            $this->plugin = PLUGIN;
            $this->pluginSvgIcon = base64_encode( file_get_contents(PLUGIN_PATH . 'assets/images/egt-logo.svg' ) );
            $this->np_create_post_type();
            $this->np_admin_menu();
        }

        function np_register() {
            add_action( 'admin_enqueue_scripts', array( $this, 'np_enqueue' ) );

            add_filter( "plugin_action_links_$this->plugin", array( $this, 'np_settings_link' ) );
        }

        public function np_settings_link( $links ) {
            $settings_link = '<a href="admin.php?page='.SETTINGS_PAGE_SLUG.'">' . __( "Settings", NPTEXTDOMAIN ) . '</a>';
            array_push( $links, $settings_link );
            return $links;

        }

        protected function np_create_post_type() {
            add_action( 'init', array( $this, 'np_custom_post_type' ) );
        }

        function np_custom_post_type() {
            register_post_type( 'news', ['public' => true, 'label' => 'News', 'menu_icon' => 'dashicons-admin-site-alt'] );
        }

        function np_enqueue() {
            // enqueue all our scripts
            wp_enqueue_style( 'mypluginstyle', plugins_url( '/assets/news-plugin.css', __FILE__ ) );
            wp_enqueue_script( 'mypluginscript', plugins_url( '/assets/news-script.js', __FILE__ ) );
        }

        function np_activate() {
            require_once PLUGIN_PATH . 'inc/news-plugin-activate.php';
            NewsPluginActivate::np_activate();
        }

        function np_deactivate() {
            require_once PLUGIN_PATH . 'inc/news-plugin-deactivate.php';
            NewsPluginDeactivate::np_deactivate();
        }

        function np_admin_menu(){
            require_once PLUGIN_PATH . 'inc/news-plugin-admin.php';
            $newsPluginAdmin = new NewsPluginAdmin();

        }
    }

    // Init class
    $alecadddPlugin = new NewsPlugin();
    $alecadddPlugin->np_register();

    // activation
    register_activation_hook( __FILE__, array( $alecadddPlugin, 'np_activate' ) );

    // deactivation
    register_deactivation_hook( __FILE__, array( $alecadddPlugin, 'np_deactivate' ) );

}