<?php

/**
 * You can customize this template. Just copy this file and paste it to your-theme/templates/show-news-shortcode.php
 *
 * @package  NewsPlugin
 */

// Custom WP query query
$main_args_query = array(
    'post_type' => array('news'),
    'post_status' => array('publish'),
    'order' => 'DESC',
);

$maxPosts       = ( !empty($allAttributes['max_posts']) ? $allAttributes['max_posts'] : "10" );
$category       = ( !empty($allAttributes['category']) ? $allAttributes['category'] : "all" );
$featured_news  = ( !empty($allAttributes['featured_news']) ? $allAttributes['featured_news'] : "newest" );;

if($maxPosts){
    $main_args_query['posts_per_page'] = $maxPosts - 1;
}

$sectionTitle = __( "EGT Digital News", NPTEXTDOMAIN);
if( $category != "all" ){
    $taxonomyArgs = array(
        'taxonomy' => 'np_category',
        'field' => 'name',
        'operator' => 'IN',
        'terms' => array($category),
    );
    $main_args_query['tax_query'] = array( $taxonomyArgs );
    $sectionTitle = $category;
}

$featuredNewsExist = false;
if( $featured_news ){
    $featured_args_query = $main_args_query;
    $featured_args_queryBK = $main_args_query;
    if ( $featured_news == "featured" ){
        $metaArgs = array(
            'key'     => 'np_news_featured',
            'value'   => 'checked',
            'compare' => '='
        );

        $featured_args_query['meta_query'] = array( $metaArgs );
    }
    elseif ( $featured_news == "newest" ){

    }
    else {
        $featured_args_query['p'] = $featured_news;
    }
    $featured_args_query['posts_per_page'] = 1;
    $featuredQuery = new WP_Query( $featured_args_query );
    if( $featured_news == "featured" && !$featuredQuery->posts){
        $featured_args_queryBK['posts_per_page'] = 1;
        $featuredQuery = new WP_Query( $featured_args_queryBK );
    }
    $featuredNewsExist = true;
}

wp_reset_postdata();

if( $featuredNewsExist ){
    $main_args_query['post__not_in'] = array($featuredQuery->posts[0]->ID);
}

$mainQuery = new WP_Query( $main_args_query );

if ( $mainQuery->have_posts() ) {
    ?>
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <span class="black-line"></span>
                <div class="section-header">
                    <h2 class="box-header"><?php echo $sectionTitle ?></h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="posts-wrapp">
    <?php
    while ( $mainQuery->have_posts() ) {
        $mainQuery->the_post();

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

                <article class="single-article">
                    <?php if($featured_img_url){ ?>
                        <a href="<?php echo $newsUrl ?>"><img src="<?php echo $featured_img_url ?>" alt=""></a>
                    <?php } else { ?>
                        <a href="<?php echo $newsUrl ?>"><img src="<?php echo PLUGIN_URL . 'assets/images/default-image.png' ?>" alt="default"></a>
                    <?php } ?>
                    <p class="tag-post"><?php echo $cats; ?></p>
                    <h3 class="post-title"><a href="<?php echo $newsUrl ?>"><?php echo get_the_title(); ?></a></h3>
                    <span class="post-data"><?php echo $post_date ?></span>
                </article>

        <?php
    }
    ?>
                </div>
            </div>
        <?php
        if( $featuredNewsExist ){
            if ( $featuredQuery->have_posts() ) {
                ?>
                <div class="col-md-6">
                    <div class="featured-artice-wrapp">
                <?php
                while ( $featuredQuery->have_posts() ) {
                    $featuredQuery->the_post();

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
                    ?>
                            <article class="featured-article">
                                <?php if($featured_img_url){ ?>
                                    <a href="<?php echo $newsUrl ?>"><img src="<?php echo $featured_img_url ?>" alt=""></a>
                                <?php } else { ?>
                                    <a href="<?php echo $newsUrl ?>"><img src="<?php echo PLUGIN_URL . 'assets/images/default-image.png' ?>" alt="default"></a>
                                <?php } ?>
                                <div class="featured-article-content">
                                    <div class="featured-left-content">
                                        <p class="tag-post"><?php echo $cats ?></p>
                                        <h3 class="post-title"><a href="<?php echo $newsUrl ?>"><?php echo get_the_title(); ?></a></h3>
                                    </div>
                                    <div class="featured-right-content">
                                        <div class="featured-details">
                                            <p class="tag-post"><?php echo get_the_author_meta('display_name') ?></p>
                                            <span class="post-data"><?php echo $post_date; ?></span>
                                        </div>
                                        <div class="featured-desc">
                                            <p><?php echo get_the_excerpt(); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                    <?php
                }
                ?>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        </div>
    </div>
        <?php
} else {
    ?>
<div class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <span class="black-line"></span>
            <div class="section-header">
                <h2 class="box-header"><?php echo $sectionTitle ?></h2>
                <p><?php echo __( 'The website news are empty yet', NPTEXTDOMAIN ); ?></p>
            </div>
        </div>
    </div>
</div>


    <?php
}

wp_reset_postdata();

?>


