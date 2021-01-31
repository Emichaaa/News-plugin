<?php

/**
 *
 * You can customize this template. Just copy this file and paste it to your-theme/templates/single-news.php
 *
 * @package  NewsPlugin
 */


get_header();

while ( have_posts() ) :
    the_post();

    $cats = "";
    $allTerms = get_the_terms( get_the_ID(), 'np_category' );
    if(!empty($allTerms)){
        foreach ( get_the_terms( get_the_ID(), 'np_category' ) as $tax ) {
            $cats .= __( $tax->name, NPTEXTDOMAIN ).", ";
        }
        $cats = rtrim( $cats, ", ");
    }
    $post_date = get_the_date( 'Y' );
    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
    $newsUrl = get_post_permalink();

    ?>
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="single-news">
                    <div class="single-header">
                        <p class="tag-post"><?php echo $cats; ?></p>
                        <h1><?php echo get_the_title(); ?></h1>
                        <span class="post-data"><?php echo $post_date; ?></span>
                    </div>
                    <hr>
                    <div class="single-content">
                        <img src="<?php echo $featured_img_url ?>" alt="">
                        <p>
                        <?php the_content(); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

    if ( is_attachment() ) {
        the_post_navigation(
            array(
                'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', NPTEXTDOMAIN ), '%title' ),
            )
        );
    }

    $single_news_next_label     = esc_html__( 'Next post', 'twentytwentyone' );
    $single_news_previous_label = esc_html__( 'Previous post', 'twentytwentyone' );

    the_post_navigation(
        array(
            'next_text' => '<p class="meta-nav">' . $single_news_next_label . '</p><p class="post-title">%title</p>',
            'prev_text' => '<p class="meta-nav">' . $single_news_previous_label . '</p><p class="post-title">%title</p>',
        )
    );
endwhile; // End of the loop.

get_footer();
