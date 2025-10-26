<?php



$pageID   = get_theme_mod('select_article_design', 1);

$articlesPost   = get_post( $pageID );

//var_dump($articlesPost);

    global $post;
    $category= $post->post_name;
    //$articlesTitles = array();
    
    if(is_front_page()){
       
           $category = "featured-articles";
           $cat_heading = "Featured articles";
       }else{
            $cat_heading = "Related articles";
       }
    $args_articles = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'category_name' => $category 
    );
    
        // The Query
    $the_query = new WP_Query( $args_articles );
     
    // The Loop
    if ( $the_query->have_posts() ) {
        // hv posts 
        while ( $the_query->have_posts() ) {
           $the_query->the_post();
            $articles[] =
            array(
                  'title' => get_the_title(),
                  'featured_img' => get_the_post_thumbnail_url(get_the_ID(),'full'),
                  'excerpt' => limit_content(18),
                  'link' => get_permalink(),
                  'month' => get_the_date('M'),
                  'date' => get_the_date('d')
                );
            
        }
    } else {
        // no posts found
    }
    /* Restore original Post Data */
    wp_reset_postdata();

if($articles):
?>

<section class="related-articles-section <?php if(get_theme_mod('enable_articles_carousel')): ?> lazyload <?php endif;?>"
<?php if(get_theme_mod('enable_articles_carousel')): ?>
         data-script="<?php echo get_template_directory_uri(); ?>/plugins/owl-carousel/owl.carousel.min.js"
         data-link="<?php echo get_template_directory_uri(); ?>/plugins/owl-carousel/assets/owl.carousel.css"
         data-expand="<?php echo ekwa_get_value('articles_offset', -10);?>"
 <?php endif;?>
>
    <div class="container">
        <h2 class="section-heading"><span><?php echo $cat_heading;?> </span></h2>
    </div>
    <div class="container">
        <?php
            $classes = get_item_classes('enable_articles_carousel', 'articles-item-class', 'articles');
            
            if(get_theme_mod('enable_articles_carousel', 'false')){
                $image_class = 'owl-lazy';
            }else{
                $image_class = 'lazyload';
            }
            //$reviews  = get_theme_mod( 'reviews-fields', '' );
            
            if($pageID != 1 && $articlesPost != NULL && $pageID  != ""){
            $resourceID = get_field( "theme_resource_id", $pageID );
            
            include( get_template_directory().'/template-parts/sections/related-articles-designs/template-'.$resourceID.'/'.'index.php');
            }else{
                include( get_template_directory().'/template-parts/sections/related-articles-designs/custom-template.php');
            }
        ?>  
    </div>
    
    <!--  loading script variables   -->
    <?php echo  section_carousel_variables('enable_articles_carousel', 'articles');?>
</section>
<?php
    endif;
?>

