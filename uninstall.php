<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package  NewsPlugin
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

// Clear Database stored data
$news = get_posts( array( 'post_type' => 'news', 'numberposts' => -1 ) );

$plugin_page = get_page_by_title( 'News plugin page' );
$news = array_merge( $news, $plugin_page );

foreach( $news as $singleNews ) {
    wp_delete_post( $singleNews->ID, true );
}

