<?php
 $slides = get_field('slides');
if($slides):
$transtition = 'slide';
if(get_field('transition')){
    $transtition = get_field('transition');
}
?>

<style>
 .carousel,.carousel-inner,.carousel-item{position:relative}.carousel.pointer-event{touch-action:pan-y}.carousel-inner{width:100%;overflow:hidden}.carousel-inner::after{display:block;clear:both;content:""}.carousel-item{display:none;float:left;width:100%;margin-right:-100%;backface-visibility:hidden;transition:transform .6s ease-in-out}.carousel-item-next,.carousel-item-prev,.carousel-item.active{display:block}.active.carousel-item-right,.carousel-item-next:not(.carousel-item-left){transform:translateX(100%)}.active.carousel-item-left,.carousel-item-prev:not(.carousel-item-right){transform:translateX(-100%)}.carousel-fade .carousel-item{opacity:0;transition-property:opacity;transform:none}.carousel-fade .carousel-item-next.carousel-item-left,.carousel-fade .carousel-item-prev.carousel-item-right,.carousel-fade .carousel-item.active{z-index:1;opacity:1}.carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-right{z-index:0;opacity:0;transition:opacity 0s .6s}.carousel-control-next,.carousel-control-prev{position:absolute;top:0;bottom:0;z-index:1;display:flex;align-items:center;justify-content:center;width:15%;color:#fff;text-align:center;opacity:.5;transition:opacity .15s}.carousel-control-next:focus,.carousel-control-next:hover,.carousel-control-prev:focus,.carousel-control-prev:hover{color:#fff;text-decoration:none;outline:0;opacity:.9}.carousel-control-prev{left:0}.carousel-control-next{right:0}.carousel-control-next-icon,.carousel-control-prev-icon{display:inline-block;width:20px;height:20px;background:50%/100% 100% no-repeat}.carousel-control-prev-icon{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath d='M5.25 0l-4 4 4 4 1.5-1.5L4.25 4l2.5-2.5L5.25 0z'/%3e%3c/svg%3e")}.carousel-control-next-icon{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath d='M2.75 0l-1.5 1.5L3.75 4l-2.5 2.5L2.75 8l4-4-4-4z'/%3e%3c/svg%3e")}.carousel-indicators{position:absolute;right:0;bottom:0;left:0;z-index:15;display:flex;justify-content:center;padding-left:0;margin-right:15%;margin-left:15%;list-style:none}.carousel-indicators li{box-sizing:content-box;flex:0 1 auto;width:30px;height:3px;margin-right:3px;margin-left:3px;text-indent:-999px;cursor:pointer;background-color:#fff;background-clip:padding-box;border-top:10px solid transparent;border-bottom:10px solid transparent;opacity:.5;transition:opacity .6s}@media (prefers-reduced-motion:reduce){.carousel-control-next,.carousel-control-prev,.carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-right,.carousel-indicators li,.carousel-item{transition:none}}.carousel-indicators .active{opacity:1}.carousel-caption{position:absolute;right:15%;bottom:20px;left:15%;z-index:10;padding-top:20px;padding-bottom:20px;color:#fff;text-align:center}
</style>

<section class="home-page-slider">

<div id="carouselOneIndicators" class="carousel slide ekwa-carousel  <?php echo $transtition;?>" data-ride="carousel">
  <ol class="carousel-indicators">
    <?php foreach( $slides as  $key => $slide ) : ?>
    <li data-target="#carouselOneIndicators" data-slide-to="<?php echo $key;?>" <?php if($key == 0 ){echo 'class="active"';}?> ></li>
    <?php endforeach; ?>
  </ol>
  <div class="carousel-inner">
    <?php foreach( $slides as  $key => $slide ) : ?>
    <div class="carousel-item <?php if($key == 0 ){echo 'active'; }?>">
	    <?php
           $slider_image = $slide['slider_image'];
           if($slider_image):
        ?>
			<picture>
				<source srcset="<?php echo $slide['webp_image'];?>" type="image/webp">
				<?php
				$mobile_banner = get_field('mobile_banner_jpg');
				?>
				<img height="<?php echo $slider_image['height']; ?>" width="<?php echo $slider_image['width']; ?>" class="carousel-img" src="<?php echo $slider_image['url']; ?>" alt="<?php echo $slider_image['alt']; ?>">
			</picture>

		<?php endif;?>

	  <div style="text-align: <?php echo $slide['align'];?>;"  class="carousel-caption d-none d-md-block caption-<?php echo $key;?>">
           <!--caption -->
			<?php if($slide['caption_one']):?>
		   <div style="font-size: <?php echo $slide['caption_one_size'];?>px;" class="caption-one"  data-animation="animate__animated animate__<?php echo  $slide['animation'];?>">
			<?php echo $slide['caption_one'];?>
		   </div>
		   <?php endif;?>
		   <?php if($slide['caption_two']):?>
		   <div style="font-size: <?php echo $slide['caption_two_size'];?>px;"  class="caption-two"  data-animation="animate__animated animate__<?php echo  $slide['animation'];?>">
			<?php echo $slide['caption_two'];?>
		   </div>
		   <?php endif;?>
		   <?php if($slide['button_text']):?>
		   <div class="slide-btn-wrapper"     data-animation="animate__animated animate__<?php echo  $slide['animation'];?>">
		   <a
		   <?php if( $slide['page_link_to'] && $slide['page_link_to']['target'] == '_blank'):?>
			target="_blank"
		   <?php endif;?>
		   href="<?php
		   if($slide['call_us_button']){
              if(isset( $_COOKIE['adward_number'] ) || isset( $_GET['ads'] ) ){
				echo  'tel:' . mobile_number(get_theme_mod('adsense_number'));
			  }else{
				echo  'tel:' . mobile_number(get_theme_mod('call_tracking_number'));
			  }

		    }else{
			 if($slide['page_link_to']){
			  echo $slide['page_link_to']['url'];
			 }
		   }
		   ?>" class="btn btn-large">
		   <?php
		   echo $slide['button_text'];
		   if($slide['call_us_button']){
			if(isset( $_COOKIE['adward_number'] ) || isset( $_GET['ads'] ) ){
				echo  ' ' . get_theme_mod('adsense_number');
			  }else{
				echo  ' ' . get_theme_mod('call_tracking_number');
			  }
			}


		   ?>
		   </a>
		   </div>
		   <?php endif;?>

	  </div>
    </div>
    <?php endforeach; ?>
  </div>
  <a class="carousel-control-prev" href="#carouselOneIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselOneIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</section>
<style>
 .caption-one{
	 margin-bottom: 15px;
  animation-delay: 800ms;
 }
 .caption-two{
  animation-delay: 1000ms;
 }
 .slide-btn-wrapper{
  animation-delay: 1600ms;
 }
    .ekwa-body .home-page-slider{
		width: 100vw;
		left: 50%;
		right: 50%;
		margin-left: -50vw;
		margin-right: -50vw;
    }
    .home-page-slider{
        position: relative;
    }
    .wp-admin  .home-page-slider{
        background: #f7f7f7;
        min-height: 250px;
    }
	.ekwa-carousel .carousel-img{
	 width: 100%;
	}
	.carousel-caption p{
	 font-family: var(--heading_h1);
	 margin-bottom: 0;
	}
	.caption-two{
	 margin-bottom: 15px;
	}
	.carousel-caption{
	 bottom: auto !important;
	 top: 50%;
	 transform: translateY(-50%);
	  left:  0 !important;
	  right:  0 !important;
	  margin-left: auto !important;
	  margin-right: auto !important;
	  max-width: 1300px;
	  padding-left: 80px;
	  padding-right: 80px;
	}
	.carousel-indicators{
		bottom: 25px !important;
	}
	.carousel-caption{
		/* padding-top: 80px !important; */
	}
	@media screen and (max-width: 1024px){
		.carousel-indicators{
			bottom: 0 !important;
		}
		.slide-btn-wrapper{
			margin-top: 10px !important;
		}
	}
	.carousel-control-prev, .carousel-control-next{
		width: 40px !important;
	}
	.carousel-control-prev{
		left: 40px !important;
	}
	.carousel-control-next{
		right: 40px !important;
	}
	/*animate css */
	:root{--animate-duration:1s;--animate-delay:1s;--animate-repeat:1}.animate__animated{-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-duration:var(--animate-duration);animation-duration:var(--animate-duration);-webkit-animation-fill-mode:both;animation-fill-mode:both}@-webkit-keyframes fadeInLeft{from{opacity:0;-webkit-transform:translate3d(-100%,0,0);transform:translate3d(-100%,0,0)}to{opacity:1;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}@keyframes fadeInLeft{from{opacity:0;-webkit-transform:translate3d(-100%,0,0);transform:translate3d(-100%,0,0)}to{opacity:1;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}.animate__fadeInLeft{-webkit-animation-name:fadeInLeft;animation-name:fadeInLeft}@-webkit-keyframes fadeIn{from{opacity:0}to{opacity:1}}@keyframes fadeIn{from{opacity:0}to{opacity:1}}.animate__fadeIn{-webkit-animation-name:fadeIn;animation-name:fadeIn}@-webkit-keyframes fadeInDown{from{opacity:0;-webkit-transform:translate3d(0,-100%,0);transform:translate3d(0,-100%,0)}to{opacity:1;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}@keyframes fadeInDown{from{opacity:0;-webkit-transform:translate3d(0,-100%,0);transform:translate3d(0,-100%,0)}to{opacity:1;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}.animate__fadeInDown{-webkit-animation-name:fadeInDown;animation-name:fadeInDown}@-webkit-keyframes fadeInRight{from{opacity:0;-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}to{opacity:1;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}@keyframes fadeInRight{from{opacity:0;-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}to{opacity:1;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}.animate__fadeInRight{-webkit-animation-name:fadeInRight;animation-name:fadeInRight}@-webkit-keyframes fadeInUp{from{opacity:0;-webkit-transform:translate3d(0,100%,0);transform:translate3d(0,100%,0)}to{opacity:1;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}@keyframes fadeInUp{from{opacity:0;-webkit-transform:translate3d(0,100%,0);transform:translate3d(0,100%,0)}to{opacity:1;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}.animate__fadeInUp{-webkit-animation-name:fadeInUp;animation-name:fadeInUp}@-webkit-keyframes flipInX{from{-webkit-transform:perspective(400px) rotate3d(1,0,0,90deg);transform:perspective(400px) rotate3d(1,0,0,90deg);-webkit-animation-timing-function:ease-in;animation-timing-function:ease-in;opacity:0}40%{-webkit-transform:perspective(400px) rotate3d(1,0,0,-20deg);transform:perspective(400px) rotate3d(1,0,0,-20deg);-webkit-animation-timing-function:ease-in;animation-timing-function:ease-in}60%{-webkit-transform:perspective(400px) rotate3d(1,0,0,10deg);transform:perspective(400px) rotate3d(1,0,0,10deg);opacity:1}80%{-webkit-transform:perspective(400px) rotate3d(1,0,0,-5deg);transform:perspective(400px) rotate3d(1,0,0,-5deg)}to{-webkit-transform:perspective(400px);transform:perspective(400px)}}@keyframes flipInX{from{-webkit-transform:perspective(400px) rotate3d(1,0,0,90deg);transform:perspective(400px) rotate3d(1,0,0,90deg);-webkit-animation-timing-function:ease-in;animation-timing-function:ease-in;opacity:0}40%{-webkit-transform:perspective(400px) rotate3d(1,0,0,-20deg);transform:perspective(400px) rotate3d(1,0,0,-20deg);-webkit-animation-timing-function:ease-in;animation-timing-function:ease-in}60%{-webkit-transform:perspective(400px) rotate3d(1,0,0,10deg);transform:perspective(400px) rotate3d(1,0,0,10deg);opacity:1}80%{-webkit-transform:perspective(400px) rotate3d(1,0,0,-5deg);transform:perspective(400px) rotate3d(1,0,0,-5deg)}to{-webkit-transform:perspective(400px);transform:perspective(400px)}}.animate__flipInX{-webkit-backface-visibility:visible!important;backface-visibility:visible!important;-webkit-animation-name:flipInX;animation-name:flipInX}@-webkit-keyframes zoomIn{from{opacity:0;-webkit-transform:scale3d(.3,.3,.3);transform:scale3d(.3,.3,.3)}50%{opacity:1}}@keyframes zoomIn{from{opacity:0;-webkit-transform:scale3d(.3,.3,.3);transform:scale3d(.3,.3,.3)}50%{opacity:1}}.animate__zoomIn{-webkit-animation-name:zoomIn;animation-name:zoomIn}@-webkit-keyframes slideInDown{from{-webkit-transform:translate3d(0,-100%,0);transform:translate3d(0,-100%,0);visibility:visible}to{-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}@keyframes slideInDown{from{-webkit-transform:translate3d(0,-100%,0);transform:translate3d(0,-100%,0);visibility:visible}to{-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}.animate__slideInDown{-webkit-animation-name:slideInDown;animation-name:slideInDown}@-webkit-keyframes slideInUp{from{-webkit-transform:translate3d(0,100%,0);transform:translate3d(0,100%,0);visibility:visible}to{-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}@keyframes slideInUp{from{-webkit-transform:translate3d(0,100%,0);transform:translate3d(0,100%,0);visibility:visible}to{-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}.animate__slideInUp{-webkit-animation-name:slideInUp;animation-name:slideInUp}
<?php
if(get_field('slider_css')):
    echo get_field('slider_css');
endif;
?>
</style>


<?php

endif;
?>

<?php
  wp_enqueue_script('bscarouseljs', get_template_directory_uri().'/layouts/bootstrap/js/carousel.js', array(), '1.0.0', true);
?>