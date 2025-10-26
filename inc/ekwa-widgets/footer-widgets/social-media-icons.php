<div class="social-media">
                              <?php foreach($sm_links as $sm_link):?>
                            <a  class="sm-icons" aria-label="<?php echo $sm_link['profile_name'];?>" rel="noreferrer" target="_blank" href="<?php echo $sm_link['social_media_link'];?>">
                                  <?php if($sm_link['social_media_icon_font']):?>
                                  <i class="<?php echo $sm_link['social_media_icon_font']?>"></i>
                                  <?php endif;?>
                                  <?php if($sm_link['social_media_icon_image']):?>
                                  <?php
                                      if ( ! wp_attachment_is_image( $sm_link['social_media_icon_image'] ) ){ $img_url = $sm_link['social_media_icon_image']['url']; } else { $img_url = wp_get_attachment_url($sm_link['social_media_icon_image']); }
                                  ?>
                                  <img src="<?php echo $img_url;?>" alt="<?php echo $sm_link['profile_name'];?>">
                                  <?php endif;?>
                              </a>
                              <?php endforeach;?>
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
                                    <i class="fab fa-twitter"></i>
                                     
                                 </a>
                                 <a aria-label="Pinterest" class="share-google pin-share-link" data-pin-do="buttonPin" href="https://www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" data-pin-custom="true">
                                 <i class="fab fa-pinterest-p"></i>
                                 </a>
                             </label>
                              
                           </button>
                            </div>
<style>
    
.social-media .sm-icons{
        font-size: 20px;
    }
    .social-media .sm-icons:hover, .social-media .addthis:hover{
        background: var(--footer-color-2);
        color: #fff;
    }
    .social-media .sm-icons, .social-media{
        line-height: 41px;
        margin-top: 20px;
        margin-bottom: 20px;
        font-size: 20px;
    }
    .social-media .sm-icons, .social-media .addthis{
        text-align: center;
        margin-right: 5px!important;
        display: inline-block;
        height: 44px;
        width: 44px;
        background: #fff;
        margin: 0 4px;
        border-radius: 0!important;
        color: var(--footer-color-1);
        /*overflow: hidden;*/
        position: relative;
        vertical-align: bottom;
        outline: none;
        border: 2px solid var(--footer-color-1);
        -webkit-border-radius: 50% !important;
        -moz-border-radius: 50% !important;
        border-radius: 50% !important;
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