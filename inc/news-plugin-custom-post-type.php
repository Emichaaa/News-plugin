<?php

/**
 * @package  NewsPlugin
 */

class NewsPluginCustomPostType
{
    public function __construct() {
        add_action( 'init', array( $this, 'np_custom_post_type' ) );
        add_action( 'init', array( $this, 'np_register_category_taxonomy' ) );
        add_action( 'add_meta_boxes', array( $this, 'np_add_news_posts_metaboxes' ) );
        add_action( 'save_post', array( $this, 'np_news_features_save_meta' ), 10, 2 );
    }

    function np_custom_post_type() {
        register_post_type(
            'news',
            array(
                'label'              => 'News',
                'labels'             => 'News',
                'public'             => true,
                'menu_icon'          => 'dashicons-admin-site-alt',
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'news' ),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),
                'show_in_rest'       => true,
            )
        );
    }

    // Register Taxonomy Category
    function np_register_category_taxonomy() {

        $labels = array(
            'name'              => _x( 'Categories', 'taxonomy general name', NPTEXTDOMAIN ),
            'singular_name'     => _x( 'Category', 'taxonomy singular name', NPTEXTDOMAIN ),
            'search_items'      => __( 'Search Categories', NPTEXTDOMAIN ),
            'all_items'         => __( 'All Categories', NPTEXTDOMAIN ),
            'parent_item'       => __( 'Parent Category', NPTEXTDOMAIN ),
            'parent_item_colon' => __( 'Parent Category:', NPTEXTDOMAIN ),
            'edit_item'         => __( 'Edit Category', NPTEXTDOMAIN ),
            'update_item'       => __( 'Update Category', NPTEXTDOMAIN ),
            'add_new_item'      => __( 'Add New Category', NPTEXTDOMAIN ),
            'new_item_name'     => __( 'New Category Name', NPTEXTDOMAIN ),
            'menu_name'         => __( 'Category', NPTEXTDOMAIN ),
        );
        $args = array(
            'labels' => $labels,
            'description' => __( '', NPTEXTDOMAIN ),
            'hierarchical' => true,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'show_in_quick_edit' => true,
            'show_admin_column' => false,
            'show_in_rest' => true,
        );
        register_taxonomy( 'np_category', array('news'), $args );

    }

    function np_add_news_posts_metaboxes() {
        add_meta_box(
            'np_news_featured',
            'Select if this is a fuatured news',
            array( $this, 'np_news_featured_function' ),
            'news',
            'side',
            'default'
        );
    }

    function np_news_featured_function() {
        global $post;

        $featured_news = get_post_meta( $post->ID, 'np_news_featured', true );
        echo '<p><input type="checkbox" name="np_news_featured" value="checked" '.get_post_meta($post->ID, 'np_news_featured', true).'/><label for="np_news_featured">'.__('Featured News?', NPTEXTDOMAIN).'</label></p>';
    }

    function np_news_features_save_meta( $post_id, $post ) {
        if ( 'news' == $post->post_type ){

            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }

            if ( isset( $_POST[ 'np_news_featured' ] ) ) {
                update_post_meta( $post_id, 'np_news_featured', $_POST[ 'np_news_featured' ] );
            } else {
                delete_post_meta( $post_id, 'np_news_featured' );
            }

        }
    }
}