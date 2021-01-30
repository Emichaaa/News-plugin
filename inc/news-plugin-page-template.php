<?php


class NewsPluginPageTemplate
{
    public $templates;

    public function __construct()
    {

        $this->templates = array(
            'page-templates/zig-zag-tpl.php' => 'Zig Zag Layout'
        );

        add_filter( 'theme_page_templates', array( $this, 'custom_template' ) );
        add_filter( 'template_include', array( $this, 'load_template' ) );
    }

    public function custom_template( $templates )
    {
        $templates = array_merge( $templates, $this->templates );

        return $templates;
    }

    public function load_template( $template )
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

        if ( file_exists( $file ) ) {
            return $file;
        }

        return $template;
    }
}