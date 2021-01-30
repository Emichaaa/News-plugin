<?php


class NewsPluginCustomPostType
{
    public function __construct() {
        add_action( 'init', array( $this, 'np_custom_post_type' ) );
        add_action( 'init', array( $this, 'np_register_category_taxonomy' ) );
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
                'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions' )
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
}