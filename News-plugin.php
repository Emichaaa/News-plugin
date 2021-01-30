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
        function np_register() {
            add_action( 'admin_enqueue_scripts', array( $this, 'np_enqueue' ) );
            $this->np_create_post_type();
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