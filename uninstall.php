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
$books = get_posts( array( 'post_type' => 'news', 'numberposts' => -1 ) );

foreach( $books as $book ) {
    wp_delete_post( $book->ID, true );
}