<?php


class NewsPluginShortcodes
{
    public function __construct() {
        add_shortcode( 'np-show-news', array( $this, 'np_show_news' ) );
    }

    public function np_show_news( $attributes )
    {
        extract( shortcode_atts( array(
            'max_posts' => '10',
        ), $attributes ) );

        ob_start();
        require_once PLUGIN_PATH."/templates/show-news-shortcode.php";
        return ob_get_clean();
    }
}