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
        add_action( 'admin_menu', array( $this, 'np_news_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'np_news_page_init' ) );
    }

    public function np_news_add_plugin_page() {
        add_menu_page(
            'News Options Page',
            'News Plugin',
            'manage_options',
            'news_plugin',
            array( $this, 'np_news_create_admin_page' ),
            "data:image/svg+xml;base64, ".$this->pluginSvgIcon,
            25
        );
    }

    public function np_news_create_admin_page() {
        $this->news_options = get_option( 'news_option_name' ); ?>

        <div class="wrap">
            <h2><?php _e( 'News Options Page', NPTEXTDOMAIN );?></h2>
<!--            <p>--><?php //_e( 'This is a News plugin option page.', NPTEXTDOMAIN );?><!--</p>-->
            <?php settings_errors(); ?>

            <form method="post" action="options.php">
                <?php
                do_settings_sections( 'news-admin' );
                ?>
            </form>
        </div>
    <?php }

    public function np_news_page_init() {
        register_setting(
            'news_option_group',
            'news_option_name',
            array( $this, 'news_sanitize' )
        );

        add_settings_section(
            'news_setting_section',
            '',
            array( $this, 'np_news_section_info' ),
            'news-admin'
        );
    }

    public function np_news_section_info() {
        ?>
        <div class="np_plugin_options_page_wrapper">
            <h3><?php _e( 'Plugin Description', NPTEXTDOMAIN );?></h3>
            <p><?php _e( 'This is a simple <b>News plugin</b>. You can create News posts and use them with shortcode provided by the <b>News plugin</b>.', NPTEXTDOMAIN );?></p>
            <p><?php _e( 'One of the additional options allows you to pick up Featured news in shortcode. Customizing plugin templates in active theme folder. ', NPTEXTDOMAIN );?></p>

            <h3><?php _e( 'Plugin Workflow', NPTEXTDOMAIN );?></h3>
            <p><?php _e( 'When you activate the plugin, first thing is to create Custom Post Type - News, create page with selected custom layout and included shortcode in content.', NPTEXTDOMAIN );?></p>
            <p><?php _e( 'After that plugin reflush rules and create plugin options page. At this version of the plugin, options page doesnt contain some specific field with options.', NPTEXTDOMAIN );?></p>
            <p><?php _e( 'If you already activate the plugin, you are free to use the shortcode in it.', NPTEXTDOMAIN );?></p>

            <h3><?php _e( 'Shortcode', NPTEXTDOMAIN );?></h3>
            <p><?php _e( 'This basic plugin has only one shortcode allowing to show News section in all pages or posts.', NPTEXTDOMAIN );?></p>
            <p><?php _e( '<b>[np-show-news max_posts="10" category="all" featured_news="newest"]</b>', NPTEXTDOMAIN );?></p>
            <p><?php _e( 'The shortcode has 3 available attributes. You can use the plugin without this attributes', NPTEXTDOMAIN );?></p>
            <p><?php _e( '- max_posts - default value = 10. This is the number of news within Featured post included.', NPTEXTDOMAIN );?></p>
            <p><?php _e( '- category - default value = "all". This attribute allows you to choose only one category to show. Leave empty to use all available categories.', NPTEXTDOMAIN );?></p>
            <p><?php _e( '- featured_news - default value = "newest". Featured_news attribute select one news and use show it bigger than other ones. If you leave it empty, or use "newest", the shortcode will show the newest published post with Checked custom field "Featured News?". If you insert PostID instead "newest", the inserted post will show at the front end.', NPTEXTDOMAIN );?></p>
            <p><?php _e( 'All attributes are optional.', NPTEXTDOMAIN );?></p>

            <h3><?php _e( 'Plugin page', NPTEXTDOMAIN );?></h3>
            <p><?php _e( '<b>News plugin</b> create page "News plugin page" when it\'s activated. This page use clear plugin template and already loaded shortcode.', NPTEXTDOMAIN );?></p>
            <p><?php _e( 'You can access this page <a href="/news-plugin-page" target="_blank">here</a>.', NPTEXTDOMAIN );?></p>

            <p><?php _e( 'Enjoy!', NPTEXTDOMAIN );?></p>
        </div>
        <?php
    }

}