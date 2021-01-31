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
            <p><?php _e( 'This is a simple <b>'.PLUGIN_NAME.'</b>. You can create News posts and show them with shortcode provided by the <b>'.PLUGIN_NAME.'</b>.', NPTEXTDOMAIN );?></p>
            <p><?php _e( 'One of the additional options allows you to choose Featured news in the shortcode.', NPTEXTDOMAIN );?></p>

            <h3><?php _e( 'Plugin Workflow', NPTEXTDOMAIN );?></h3>
            <p><?php _e( 'As soon as the plugin is activated a Custom Post Type called “News” is created.', NPTEXTDOMAIN );?></p>
            <p><?php _e( 'Also inside pages you will see a new page “News plugin page” included the shortcode with all options.', NPTEXTDOMAIN );?></p>

            <h3><?php _e( 'Shortcode', NPTEXTDOMAIN );?></h3>
            <p><?php _e( 'This basic plugin has only one shortcode, which allows you to show all your news with pretty layout inside any page or post.', NPTEXTDOMAIN );?></p>
            <p><?php _e( '<b>[np-show-news max_posts="10" category="all" featured_news="newest"]</b>', NPTEXTDOMAIN );?></p>
            <p><?php _e( 'The shortcode has 3 available attributes. You are able to use the plugin without this attributes.', NPTEXTDOMAIN );?></p>
            <p><?php _e( '- max_posts - default value = 10. The max number of the posts which will be shown.', NPTEXTDOMAIN );?></p>
            <p><?php _e( '- category - default value = "all". This attribute allows you to choose only one category to show. Leave empty to use all available categories.', NPTEXTDOMAIN );?></p>
            <p><?php _e( '- featured_news - default value = "newest". The Featured_news attribute selects one news, showing it bigger than the other ones. If you leave it empty, or use "newest", the shortcode will show the newest published post. If you use “featured” instead “newest” the shortcode will show that post, whose option “Featured News” is checked (you are able to see that option inside every single post).  If you have more that one post with “Featured News” option selected, the shortcode will show the newest one. If you insert/use PostID instead "newest" or ”featured”, the shortcode will show the post with the corresponding ID.', NPTEXTDOMAIN );?></p>
            <p><?php _e( 'All attributes are optional.', NPTEXTDOMAIN );?></p>

            <h3><?php _e( 'Plugin page', NPTEXTDOMAIN );?></h3>
            <p><?php _e( 'The <b>'.PLUGIN_NAME.'</b> creates a page "News plugin page" after its activation. This page uses a clear plugin template with the shortcode already loaded.', NPTEXTDOMAIN );?></p>
            <p><?php _e( 'You can access the page <a href="/news-plugin-page" target="_blank">here</a>.', NPTEXTDOMAIN );?></p>

            <h3><?php _e( 'Uninstall plugin', NPTEXTDOMAIN );?></h3>
            <p><?php _e( 'When you uninstall the <b>'.PLUGIN_NAME.'</b> all posts inside the Custom post type News will be deleted permanently. The plugin page will be deleted too.', NPTEXTDOMAIN );?></p>

            <p><?php _e( 'Enjoy!', NPTEXTDOMAIN );?></p>
        </div>
        <?php
    }

}