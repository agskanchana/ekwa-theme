<section class="inner-page-banner <?php if(!has_post_thumbnail() && !get_field('common_banner')){ echo 'text_banner';}else{echo 'img_banner';}?>">
    <?php
    if(has_post_thumbnail()){
        
       //  the_post_thumbnail('full');
       if(is_mobile()){
         the_post_thumbnail('featured_mobile');
       }
       if(is_tab() || !is_mobile()){
            the_post_thumbnail('full');
        }
    }else{
         if(get_field('common_banner')){
            $common_banner = get_field('common_banner');
            echo '<img width="'.$common_banner['width'].'" height="'.$common_banner['height'].'"   src="'.$common_banner['url'].'" alt="'.$common_banner['alt'].'">';
         }
    }
    ?>  
    
    
    <div class="container inner-banner-container">
         <?php

        inner_page_heading(get_the_ID());
         ?>
        <div class="inner-page-breadcrumbs">
        <?php
           if ( function_exists('yoast_breadcrumb') ) 
           {yoast_breadcrumb('<span id="breadcrumbs">','</span>');}
        ?>
        </div>
        
    </div>
</section>

<?php
$padding = '180';
if(get_field('padding')){
    $padding = get_field('padding');
}
$opacity = '5';
if(get_field('opacity')){
    $opacity = get_field('opacity');
}
$heading_color = '#fff';
if(get_field('heading_color')){
    $heading_color = get_field('heading_color');
}
$breadcrumbs = '#fff';
if(get_field('breadcrumb_color')){
    $breadcrumbs = get_field('breadcrumb_color');
}
?>

<style>
    .inner-page-banner{
        text-align: center;
        position: relative;
        z-index: 10;
    }
    .inner-page-banner img{
        width: 100%;
        height: auto;
    }
    .inner-page-banner.text_banner{
        padding-top: <?php echo $padding;?>px;
        padding-bottom: <?php echo $padding;?>px;
    }
    .inner-caption-heading{
        font-size: 36px;
    }
    .inner-page-banner.img_banner  .inner-banner-container{
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        margin-left: auto;
        margin-right: auto;
        left: 0;
        right: 0;
        z-index: 200;
    }
    .inner-page-banner:before{
       content: "";
       display: block;
       position: absolute;
       top: 0;
       left: 0;
       width: 100%;
       height: 100%;
       z-index: 100;
       background: <?php echo get_field('background_color');?>;
       opacity: 0.<?php echo $opacity;?>
    }
    .inner-banner-container{
        position: relative;
        z-index: 200;
        color: <?php echo $heading_color;?>
    }
    .inner-banner-container h1{
        color: <?php echo $heading_color;?>
    }
 #breadcrumbs, #breadcrumbs a{
    color:  <?php echo $breadcrumbs;?>
 }
 <?php 
    if(get_field('custom_css')):
        echo get_field('custom_css');
    endif;
    ?>
</style>

<?php
    $thumb_id = get_post_thumbnail_id();
    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
    $thumb_url = $thumb_url_array[0];
?>