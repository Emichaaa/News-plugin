<?php

/**
 * @package  NewsPlugin
 */

class NewsPluginPageTemplate
{
    public $templates;

    public function __construct()
    {

        $this->templates = array(
            'page-templates/zig-zag-tpl.php' => 'Zig Zag Layout'
        );

        add_filter( 'theme_page_templates', array( $this, 'np_custom_template' ) );
        add_filter( 'template_include', array( $this, 'np_load_template' ) );
        add_filter( 'single_template', array( $this, 'np_single_template' ) );
    }

    public function np_custom_template( $templates )
    {
        $templates = array_merge( $templates, $this->templates );

        return $templates;
    }

    public function np_load_template( $template )
    {
        global $post;

        if ( ! $post ) {
            return $template;
        }

        $template_name = get_post_meta( $post->ID, '_wp_page_template', true );

        if ( ! isset( $this->templates[$template_name] ) ) {
            return $template;
        }

        $file = PLUGIN_PATH . $template_name;

        if ( file_exists( get_stylesheet_directory() . '/templates/news-plugin/'.$template_name ) ) {
            return get_stylesheet_directory() . '/templates/news-plugin/'.$template_name;
        }
        elseif ( file_exists( $file ) ) {
            return $file;
        }

        return $template;
    }

    function np_single_template( $single ) {

        global $post;

        if ( $post->post_type == 'news' ) {

            if ( file_exists( get_stylesheet_directory() . '/templates/news-plugin/single-news.php' ) ) {
                return get_stylesheet_directory() . '/templates/news-plugin/single-news.php';
            }
            elseif ( file_exists( PLUGIN_PATH . 'templates/single-news.php' ) ) {
                return PLUGIN_PATH . 'templates/single-news.php';
            }
        }

        return $single;

    }
}