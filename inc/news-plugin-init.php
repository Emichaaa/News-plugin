<?php


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
        add_action( 'admin_enqueue_scripts', array( $this, 'np_enqueue' ) );
        add_filter( "plugin_action_links_$this->plugin", array( $this, 'np_settings_link' ) );
    }

    function np_enqueue() {
        // enqueue all our scripts
        wp_enqueue_style( 'mypluginstyle', plugins_url( '/assets/news-plugin.css', __FILE__ ) );
        wp_enqueue_script( 'mypluginscript', plugins_url( '/assets/news-script.js', __FILE__ ) );
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
}