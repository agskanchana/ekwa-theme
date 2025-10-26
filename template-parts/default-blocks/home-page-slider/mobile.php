<style>
    .mobile-banner{
        position: relative;
    }
    .caption-wrapper{
        position: absolute;
        bottom: 30px;
        width: 100%;
        text-align: center
    }
    .caption{
        font-size: <?php echo get_field('caption_size');?>px;

        /* color: #fff; */
        /* text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.8); */

    }
    .caption p {
    line-height: 36px;
    margin-bottom: 5px;
    }

    .mobile-banner img{
       width: 100%;
       height: auto;
    }
    <?php
     $slide = get_field('slides')[0];
      $slide_image =  $slide['slider_image']['url'];
      $image_width = $slide['slider_image']['width'];
      $image_height = $slide['slider_image']['height'];
      $padding = $image_height / $image_width  * 100;
      $padding = (int) $padding;

    ?>
    @media screen and (min-width: 540px){
        .mobile-banner picture{
            display: none;
        }
        .mobile-banner{
            height: 0;
            padding-top: <?php echo $padding;?>%;
            background:  url(<?php echo $slide_image;?>) top center  no-repeat;
            background-size: cover;;
        }
        .caption{
            margin-bottom: 25px;
            font-size: <?php echo $slide['caption_one_size'];?>px;
        }
        .caption-wrapper{
            bottom: auto;
            padding-left: 40px;
            padding-right: 40px;
            top: 50%;
            transform: translateY(-50%);
            text-align: <?php echo $slide['align'];?>;
        }
    }

    <?php
    if(get_field('custom_css')):
        echo get_field('custom_css');
    endif;
    ?>

</style>
<div class="mobile-banner">
   <picture>
    <source srcset="<?php echo get_field('mobile_banner_webp');?>" type="image/webp">
    <?php
     $mobile_banner = get_field('mobile_banner_jpg');
    ?>
    <img width="<?php echo $mobile_banner['width'];?>" height="<?php echo $mobile_banner['height'];?>" src="<?php echo $mobile_banner['url'];?>" alt="<?php echo $mobile_banner['alt'];?>">
   </picture>
   <div class="caption-wrapper">
    <div class="caption"><?php echo get_field('caption_text');?></div>
    <a href="<?php
            if(isset( $_COOKIE['adward_number'] ) || isset( $_GET['ads'] ) ){
                $phone = mobile_number(get_theme_mod('adsense_number'));
            }else{
                $phone = mobile_number(get_theme_mod('call_tracking_number'));
            }


		   if(get_field('call_us_button')){ echo  'tel:' . $phone; }else{
			 if(get_field('link')){
                echo get_field('link');
			 }
		   }?>" class="btn"><?php echo get_field('button_text');?></a>
   </div>
</div>