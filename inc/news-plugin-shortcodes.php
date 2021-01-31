<?php

/**
 * @package  NewsPlugin
 */

class NewsPluginShortcodes
{
    public function __construct() {
        add_shortcode( 'np-show-news', array( $this, 'np_show_news' ) );
    }

    public function np_show_news( $attributes )
    {
        $allAttributes = shortcode_atts( array(
            'max_posts' => '10',
            'category'  => 'all',
            'featured_news' => "newest"
        ), $attributes );

        wp_enqueue_style( 'news-global' );
        wp_enqueue_style( 'news-section' );
        wp_enqueue_style( 'bootstrap' );
        wp_enqueue_script( 'bootstrap' );

        ob_start();
        if ( file_exists( get_stylesheet_directory() . '/templates/news-plugin/show-news-shortcode.php' ) ) {
            require_once get_stylesheet_directory() . '/templates/news-plugin/show-news-shortcode.php';
        }
        elseif ( PLUGIN_PATH."/templates/show-news-shortcode/show-news-shortcode.php" ) {
            require_once PLUGIN_PATH."/templates/show-news-shortcode/show-news-shortcode.php";
        }
        return ob_get_clean();
    }
}