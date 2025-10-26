<?php
$align = $block['align'];
$block_id = $block['id'];
if( !empty($block['anchor']) ) {
   $block_id = $block['anchor'];
}
$className = 'fontawesome-icon';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
?>
<div  id="<?php echo $block_id;?>" class="social-media-icons <?php echo $align;?>">
    <?php
  $icon_size = '20px';
  if(get_field('size')){
    $icon_size = get_field('size').'px';
  }
  $icon_gap = '10px';
  if(get_field('gap')){
      $icon_gap = get_field('gap').'px';
  }
  $icon_color = '#000';
  if(get_field('color')){
      $icon_color = get_field('color');
  }
  $hover_color = '#183153';
  if(get_field('hover_color')){
      $hover_color = get_field('hover_color');
  }
  $sm_links  = get_theme_mod( 'social_media_links', null );
  if($sm_links):?>

   <div class="social-media">
                             <?php foreach($sm_links as $sm_link):?>
                           <a  class="sm-icons" aria-label="<?php echo $sm_link['profile_name'];?>" rel="noreferrer" target="_blank" href="<?php echo $sm_link['social_media_link'];?>">
                                 <?php if($sm_link['social_media_icon_font']):?>
                                 <i class="<?php echo $sm_link['social_media_icon_font']?>"></i>
                                 <?php endif;?>
                                 <?php if($sm_link['social_media_icon_image']):?>
                                 <?php
                                     if ( ! wp_attachment_is_image( $sm_link['social_media_icon_image'] ) ){ $img_url = $sm_link['social_media_icon_image']; } else { $img_url = wp_get_attachment_url($sm_link['social_media_icon_image']); }
                                 ?>
                                 <img

                                  src="<?php echo $img_url;?>" alt="<?php echo $sm_link['profile_name'];?>">
                                 <?php endif;?>
                             </a>
                             <?php endforeach;?>
                             <?php
                             $hide_share_icon = false;
                             $hide_share_icon = get_field('hide_share_icon');
                             if(!$hide_share_icon):
                             ?>
                             <button  aria-label="Toggle Share" class="addthis hide-from-mobile" onclick="shareToggle()">
                             <i class="fas fa-share-alt"></i>
                             <span class="hide">Plus Icon</span>

                             <label id="share-toggle" class="share-toggle">
                                <a  aria-label="Facebook" class="share-facebook" rel="noreferrer" href="https://www.facebook.com/sharer/sharer.php?u=<?php  the_permalink(); ?>&t=<?php the_title();?>"
                                   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                   target="_blank" title="Share on Facebook">
                                   <i class="fab fa-facebook-f"></i>

                                </a>
                                <a  aria-label="Twitter" class="share-twit" rel="noreferrer" href="https://twitter.com/share?url=<?php the_permalink(); ?>&via=TWITTER_HANDLE&text=<?php the_title();?>"
                                   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                   target="_blank" title="Share on Twitter">
                                   <i class="fa-brands fa-x-twitter"></i>

                                </a>
                                <a aria-label="Pinterest" class="share-google pin-share-link" data-pin-do="buttonPin" href="https://www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" data-pin-custom="true">
                                <i class="fab fa-pinterest-p"></i>
                                </a>
                            </label>
                          </button>
                          <?php endif; ?>
                           </div>
<style>

.social-media .sm-icons{
       /* font-size: 20px; */
   }
   .social-media .sm-icons, .social-media .addthis{
       text-align: center;
       display: inline-block;
       border-radius: 0!important;
       /*overflow: hidden;*/
       position: relative;
       vertical-align: bottom;
       outline: none;
       border: none;
       background: none !important;
       padding: 0 !important;
       font-size: <?php echo $icon_size;?>;

   }
   #<?php echo $block_id;?> .social-media{
    display: flex;
    gap: <?php echo $icon_gap;?>;
   }
   #<?php echo $block_id;?> .social-media .sm-icons,
   #<?php echo $block_id;?> .social-media .addthis{
       font-size: <?php echo $icon_size;?>;
       color: <?php echo $icon_color;?>;
   }
   #<?php echo $block_id;?> .social-media .sm-icons:hover,
   #<?php echo $block_id;?> .social-media .addthis:hover{
       color: <?php echo $hover_color;?>;
   }
   #<?php echo $block_id;?>.left .social-media{
       justify-content: flex-end;
   }
   #<?php echo $block_id;?>.center .social-media{
       justify-content:  center;
   }
   #<?php echo $block_id;?>.right .social-media{
       justify-content:  right;
   }
   .social-media .addthis .share-toggle {
       z-index: 99;
       display: inline;
       visibility: hidden;
       opacity: 0;
       position: absolute;
       bottom: 100%;
       width: 95px;
       right: -25px;
       text-align: center;
       font-size: 14px;
   }
   .addthis span.hide{
       display: none;
   }
   .social-media .addthis .share-toggle a{
       color: #fff;
       padding: 10px 10px;
       display: block;
   }
   .share-toggle i{
       font-size: 20px;
   }
   .social-media .addthis .share-toggle .share-google {
       background: #C33;
   }
   .social-media .addthis .share-toggle .share-twit {
       background: #38A1F3;
   }
   .social-media .addthis .share-toggle .share-facebook {
       background: #3b5998;
   }
   .social-media .addthis .share-toggle.active{
       visibility: visible;
       opacity: 1;
   }
</style>
       <script>
           function shareToggle() {
       var element = document.getElementById("share-toggle");
       element.classList.toggle("active");
   }
       </script>
  <?php
   endif;
    ?>
</div>