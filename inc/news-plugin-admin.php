<?php

/**
 * @package  NewsPlugin
 */

class newsPluginAdmin
{

    public $pluginSvgIcon;
    private $news_options;

    public function __construct() {
        $this->pluginSvgIcon = base64_encode( file_get_contents(PLUGIN_PATH . 'assets/images/egt-logo.svg' ) );
        add_action( 'admin_menu', array( $this, 'news_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'news_page_init' ) );
    }

    public function news_add_plugin_page() {
        add_menu_page(
            'News Options Page',
            'News Plugin',
            'manage_options',
            'news_plugin',
            array( $this, 'news_create_admin_page' ),
            "data:image/svg+xml;base64, ".$this->pluginSvgIcon,
            25
        );
    }

    public function news_create_admin_page() {
        $this->news_options = get_option( 'news_option_name' ); ?>

        <div class="wrap">
            <h2><?php _e( 'News Options Page', NPTEXTDOMAIN );?></h2>
            <p><?php _e( 'This is a News plugin option page.', NPTEXTDOMAIN );?></p>
            <?php settings_errors(); ?>

            <form method="post" action="options.php">
                <?php
                do_settings_sections( 'news-admin' );
                ?>
            </form>
        </div>
    <?php }

    public function news_page_init() {
        register_setting(
            'news_option_group',
            'news_option_name',
            array( $this, 'news_sanitize' )
        );

        add_settings_section(
            'news_setting_section',
            'More info about the plugin',
            array( $this, 'news_section_info' ),
            'news-admin'
        );
    }

    public function news_section_info() {
        ?>
        <div>
            <p><?php _e( 'Show more info', NPTEXTDOMAIN );?></p>
        </div>
        <?php
    }

}