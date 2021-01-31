<?php

/**
 * @package  NewsPlugin
 */

class NewsPluginActivate
{

    public static function np_activate() {
        if ( ! get_option( 'np_plugin_flush_rewrite_rules_flag' ) ) {
            add_option( 'np_plugin_flush_rewrite_rules_flag', true );
        }

        if( !get_page_by_title( 'News plugin page' ) ){
            $my_post = array(
                'post_title'    => wp_strip_all_tags( 'News plugin page' ),
                'post_content'  => '[np-show-news max_posts="10" category="all" featured_news="newest"]',
                'post_status'   => 'publish',
                'post_author'   => 1,
                'post_type'     => 'page',
                'meta_input'   => array(
                    '_wp_page_template' => 'page-templates/zig-zag-tpl.php',
                ),
            );

            wp_insert_post( $my_post );
        }
    }
}