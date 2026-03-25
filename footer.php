
<?php
if (class_exists('ACF')) {
 if(get_field('custom_footer') && get_field('select_footer')){
         $footerID = get_field('select_footer');
         $footer = get_post($footerID);
         // Custom processing - run shortcode directly, bypass the_content filter
         $raw_content = $footer->post_content;
         $output = do_shortcode($raw_content);
         // Apply only essential filters
         $output = wptexturize($output);
         $output = convert_smilies($output);
         $output = convert_chars($output);
         echo ekwa_content($output);
   }
   else{
      $footerID = get_theme_mod('select_footer', 1);

      if($footerID != 1 && $footerID != NULL){
         $footer = get_post($footerID);
         if($footer){
           // Same approach for the default footer
           $pre_processed = do_shortcode($footer->post_content);
           remove_filter('the_content', 'wpautop');
           $output = apply_filters('the_content', $pre_processed);
           add_filter('the_content', 'wpautop');
           echo ekwa_content($output);
         }
      }
   }
}
get_template_part('template-parts/search');
 wp_footer();
?>
<style>
   div#cookie_directive_container *{box-sizing:content-box}div#cookie_directive_container{position:fixed;bottom:-100px;background:#000; color: #fff; font-size: 12px; max-width:100%;width:100%;text-align:center;border-top:5px solid #666;display:block;transition:1s all ease;z-index:10005}div#cookie_directive_container .content-wrapper{max-width:1200px;margin:auto;padding:10px}div#cookie_directive_container button{display:inline-block;margin:0 10px;width:100px;line-height:36px;border:0;border-radius:4px;background:#666;color:#fff;transition:.25s all ease}div#cookie_directive_container .text-content{display:inline-block}div#cookie_directive_container button:hover{box-shadow:0 0 1px 1px rgba(0,0,0,.25)}div#cookie_directive_container a{color:#fff; font-weight: bold; text-decoration: underline;}
@media screen and (max-width: 991px){
div#cookie_directive_container{
 height: auto !important;
    width: 180px !important;
    bottom: 92px !important;
    padding: 10px !important;
    left: 15px;
}
}


@media screen and (min-width: 1024px){
   .scrollup {
	     bottom: 20px;
	     height: 45px;
	     width: 45px;
	     position: fixed;
	     background: none;
	     right: 30px;
	     border: none;
	     z-index: 1500;
	     padding: 0;
	     outline: none !important;
		 cursor: pointer;
	}
	 .scrollup .hide {
	     display: none;
	}
	 .scrollup>svg{
	     -webkit-animation-name: scrollup-bob;
	     animation-name: scrollup-bob;
	     -webkit-animation-duration:2s;
	     animation-duration: 2s;
	     -webkit-animation-delay: 0s;
	     animation-delay: 0s;
	     -webkit-animation-timing-function: ease-in-out;
	     animation-timing-function:ease-in-out;
	     -webkit-animation-iteration-count: infinite;
	     animation-iteration-count:infinite;
	     -webkit-animation-fill-mode: forwards;
	     animation-fill-mode: forwards;
	     -webkit-animation-direction: normal;
	     animation-direction: normal;
	}
	 .scrollup > svg{
	 	border-radius: 0;
	     height: 35px;
	     width: 35px;
	     background: var(--color_one);
	     padding: 10px;
	     box-shadow: 0px 0px 1px 2px var(--color_five);
	     fill: var(--color_five);
	     -webkit-transform: perspective(1px) translateZ(0);
	     transform: perspective(1px) translateZ(0);
	     transition-duration: 0.3s;
	}
	.scrollup > svg:hover{
		background: var(--color_two);
		fill: var(--color_five);
		box-shadow: 0px 0px 1px 2px var(--color_five);
	}
	 @-webkit-keyframes scrollup-bob {
	     0% {
	         -webkit-transform: translateY(-16px);
	         transform: translateY(-16px);
	    }
	     50% {
	         -webkit-transform: translateY(-4px);
	         transform: translateY(-4px);
	    }
	     100% {
	         -webkit-transform: translateY(-16px);
	         transform: translateY(-16px);
	    }
	}
	@keyframes scrollup-bob {
     0% {
         -webkit-transform: translateY(-16px);
         transform: translateY(-16px);
    }
     50% {
         -webkit-transform: translateY(-4px);
         transform: translateY(-4px);
    }
     100% {
         -webkit-transform: translateY(-16px);
         transform: translateY(-16px);
    }
	}
	 @-webkit-keyframes scrollup-bob {
	     0% {
	         -webkit-transform: translateY(-16px);
	         transform: translateY(-16px);
	    }
	     50% {
	         -webkit-transform: translateY(-4px);
	         transform: translateY(-4px);
	    }
	     100% {
	         -webkit-transform: translateY(-16px);
	         transform: translateY(-16px);
	    }
	}
	@keyframes scrollup-bob {
     0% {
         -webkit-transform: translateY(-16px);
         transform: translateY(-16px);
    }
     50% {
         -webkit-transform: translateY(-4px);
         transform: translateY(-4px);
    }
     100% {
         -webkit-transform: translateY(-16px);
         transform: translateY(-16px);
    }
	}
}
@media screen and (max-width: 1023px){
   .scrollup-desktop{
	display: none !important;
   }
}

</style>
<script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
  !function(){!function(){if("true"==function(e){for(var t=e+"=",o=document.cookie.split(";"),n=0;n<o.length;n++){for(var i=o[n];" "==i.charAt(0);)i=i.substring(1);if(0==i.indexOf(t))return i.substring(t.length,i.length)}return""}("cookie_banner"))return!1; var e; if(typeof window._wpemojiSettings == "object"){e ="<?php echo get_home_url(); ?>/cookie-policy/";}else {e="<?php echo get_home_url(); ?>/cookie-policy/";}var t=document.createElement("div"),o=' <div class="content-wrapper"> <div class="text-content">We use cookies to enhance your experience. By continuing to use our website, you consent to our use of <a href="'+e+'">cookies</a>. </div> <button class="js-cookie-acc-btn">Got It</button></div>';t.id="cookie_directive_container",t.innerHTML=o,setTimeout(function(){document.querySelector("#cookie_directive_container").style.bottom=0},1e3),document.getElementsByTagName("body")[0].insertAdjacentElement("beforeend",t),document.querySelector(".js-cookie-acc-btn").addEventListener("click",function(){!function(e,t,o){var n=new Date;n.setTime(n.getTime()+24*o*60*60*1e3);var i="expires="+n.toGMTString();document.cookie=e+"="+t+"; "+i + "; path=/"}("cookie_banner","true",360),document.querySelector("#cookie_directive_container").style.display="none"})}();function jqMoveElem(){if((typeof jQuery=='undefined')){setTimeout(jqMoveElem, 500);}else{$('body').append($('#cookie_directive_container').detach());}}setTimeout(jqMoveElem, 5000);}();
</script>
</div>

<button aria-label="Scroll Up" onclick="topFunction()" id="scrollup" class="scrollup scrollup-desktop" href="#">
		<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-up" class="svg-inline--fa fa-arrow-up fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M34.9 289.5l-22.2-22.2c-9.4-9.4-9.4-24.6 0-33.9L207 39c9.4-9.4 24.6-9.4 33.9 0l194.3 194.3c9.4 9.4 9.4 24.6 0 33.9L413 289.4c-9.5 9.5-25 9.3-34.3-.4L264 168.6V456c0 13.3-10.7 24-24 24h-32c-13.3 0-24-10.7-24-24V168.6L69.2 289.1c-9.3 9.8-24.8 10-34.3.4z"></path></svg>
		<span class="hide">Scroll Up</span>
	</button>
</body>
</html>
