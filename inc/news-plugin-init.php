<?php

/**
 * @package  NewsPlugin
 */

class NewsPluginInit
{
    public $plugin;
    public function __construct() {
        $this->plugin = PLUGIN;
        $this->np_register();
        $this->np_create_post_type();
        $this->np_register_shortcodes();
        $this->np_admin_menu();
        $this->np_create_page_templates();
    }

    function np_register() {
        add_action( 'wp_enqueue_scripts', array( $this, 'np_register_assets' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'np_admin_enqueue' ) );
        add_action( 'wp_footer', array( $this, 'np_enqueue_script_single' ) );
        add_filter( "plugin_action_links_$this->plugin", array( $this, 'np_settings_link' ) );
        add_action( 'init', array( $this, 'np_init_flush' ) );
    }

    function np_admin_enqueue() {
        wp_enqueue_style( 'mypluginstyle', plugins_url( '/assets/news-plugin.css', __FILE__ ) );
        wp_enqueue_script( 'mypluginscript', plugins_url( '/assets/news-script.js', __FILE__ ) );
    }

    function np_register_assets() {
        wp_register_style( 'news-global', PLUGIN_URL .'templates/show-news-shortcode/news-global.css' );
        wp_register_style( 'news-section', PLUGIN_URL . 'templates/show-news-shortcode/news-section.css' );
        wp_register_style( 'bootstrap', PLUGIN_URL . 'assets/css/bootstrap.min.css' );
        wp_register_script( 'bootstrap', PLUGIN_URL . 'assets/js/bootstrap.min.js', array( 'jquery' ),'',true );
        wp_register_style( 'news-single', PLUGIN_URL .'templates/show-news-shortcode/news-single.css' );
    }

    function np_enqueue_script_single(){
        if( is_singular( 'news' ) ){
            wp_enqueue_style( 'news-global' );
            wp_enqueue_style( 'news-single' );
            wp_enqueue_style( 'bootstrap' );
            wp_enqueue_script( 'bootstrap' );
        }
    }

    public function np_settings_link( $links ) {
        $settings_link = '<a href="admin.php?page='.SETTINGS_PAGE_SLUG.'">' . __( "Settings", NPTEXTDOMAIN ) . '</a>';
        array_push( $links, $settings_link );
        return $links;
    }

    function np_create_post_type() {
        require_once PLUGIN_PATH . 'inc/news-plugin-custom-post-type.php';
        $newsPluginCustomPostType = new newsPluginCustomPostType();
    }

    function np_register_shortcodes() {
        require_once PLUGIN_PATH . 'inc/news-plugin-shortcodes.php';
        $newsPluginShortcodes = new NewsPluginShortcodes();
    }

    function np_admin_menu(){
        require_once PLUGIN_PATH . 'inc/news-plugin-admin.php';
        $newsPluginAdmin = new NewsPluginAdmin();
    }

    function np_create_page_templates(){
        require_once PLUGIN_PATH . 'inc/news-plugin-page-template.php';
        $newsPluginPageTemplate = new NewsPluginPageTemplate();
    }

    function np_init_flush(){
        if ( get_option( 'np_plugin_flush_rewrite_rules_flag' ) ) {
            flush_rewrite_rules();
            delete_option( 'np_plugin_flush_rewrite_rules_flag' );
        }
    }
}