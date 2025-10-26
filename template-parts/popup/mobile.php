<div class="mobile-popup">
    <div class="popup-modal__close">X</div>
<?php 
     $popupID   = get_theme_mod('select_mobile_popup', 1);
     if($popupID != 1){
			$popup = get_post($popupID);
			if($popup){
			echo apply_filters('the_content',$popup->post_content);
			}
		 }
     ?>
</div>
<style>
    .mobile-popup .wp-block-image{
        margin-bottom: 0;
    }
    .mobile-popup{
        min-height: 150px;
        position: relative;
    }
    .popup-modal__close{
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #000;
        color: #fff;
        position: absolute;
        top: 0;
        right: 0;
        cursor: pointer;
        width: 40px;
        height: 40px;
        font-family: cursive;
    }
    .mobile-popup.hide{
        display: none;
    }
</style>
<script>
 var popupModal = document.querySelector(".mobile-popup");
 var popupCloseBtn = document.querySelector(".popup-modal__close");

 function setPopupCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
setPopupCookie('popupCookie', 'true', 1);


popupCloseBtn.addEventListener('click', function(){
popupModal.classList.add('hide');
})
</script>