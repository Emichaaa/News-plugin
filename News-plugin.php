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
*/

defined( 'ABSPATH' ) or die( 'Good luck! :)' );

if ( !class_exists( 'NewsPlugin' ) ) {

    class NewsPlugin
    {

        public $plugin;
        public $pluginSvgIcon;

        function __construct() {
            $this->plugin = plugin_basename( __FILE__ );
            $this->pluginSvgIcon = base64_encode( file_get_contents(plugin_dir_path( __FILE__ ) . 'assets/images/egt-logo.svg' ) );
        }

        function np_register() {
            add_action( 'admin_enqueue_scripts', array( $this, 'np_enqueue' ) );
            $this->np_create_post_type();

            add_action( 'admin_menu', array( $this, 'np_add_admin_pages' ) );

            add_filter( "plugin_action_links_$this->plugin", array( $this, 'np_settings_link' ) );
        }

        public function np_settings_link( $links ) {
            $settings_link = '<a href="admin.php?page=news_plugin">Settings</a>';
            array_push( $links, $settings_link );
            return $links;
        }

        public function np_add_admin_pages() {
            add_menu_page( 'News Plugin', 'News', 'manage_options', 'news_plugin', array( $this, 'np_admin_index' ), "data:image/svg+xml;base64, ".$this->pluginSvgIcon, 110 );
        }

        public function np_admin_index() {
            require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';
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
            require_once plugin_dir_path( __FILE__ ) . 'inc/news-plugin-activate.php';
            NewsPluginActivate::np_activate();
        }

        function np_deactivate() {
            require_once plugin_dir_path( __FILE__ ) . 'inc/news-plugin-deactivate.php';
            NewsPluginDeactivate::np_deactivate();
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