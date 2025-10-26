<div 
  class="popup-modal shadow" 
  data-popup-modal="one">
  <i class="fas fa-2x fa-times popup-modal__close"></i>
    <div class="popup-content">
     <?php 
     $popupID   = get_theme_mod('select_popup', 1);
     if($popupID != 1){
			$popup = get_post($popupID);
			if($popup){
			echo apply_filters('the_content',$popup->post_content);
			}
		 }
     ?>
    </div>
</div>

<style>
  .popup-modal .wp-block-image{
        margin-bottom: 0;
    }
    .popup-modal {
      display: none;
    min-height: 365px;
    max-width: 850px;
    display: none;
    width: 92%;
    background-color: #fff;
    position: fixed;
    left: 0;
    right: 0;
    margin: auto;
    top: 50px;
    padding: 45px;
    opacity: 0;
    transition: all 300ms ease-in-out;
    z-index: 5011;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}
.popup-modal.is--visible {
  display: block;
  
}
.popup-modal__close {
  position: absolute;
  font-size: 1.2rem;
  right: -10px;
  top: -10px;
  cursor: pointer;
  background: #000;
  padding: 1rem;
  color: #fff;
  z-index: 6000;
}
:root {
  --animate-duration: 1s;
  --animate-delay: 1s;
  --animate-repeat: 1;
}
.animate__animated {
  -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-duration: var(--animate-duration);
  animation-duration: var(--animate-duration);
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}
/* Fading entrances  */
@-webkit-keyframes fadeIn {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}
@keyframes fadeIn {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}
.animate__fadeIn {
  -webkit-animation-name: fadeIn;
  animation-name: fadeIn;
  
}


/* Fading exits */
@-webkit-keyframes fadeOut {
  from {
    opacity: 1;
  }

  to {
    opacity: 0;
  }
}
@keyframes fadeOut {
  from {
    opacity: 1;
  }

  to {
    opacity: 0;
  }
}
.animate__fadeOut {
  -webkit-animation-name: fadeOut;
  animation-name: fadeOut;
}
</style>
<script>
 var popupModal = document.querySelector(".popup-modal");
 var popupCloseBtn = document.querySelector(".popup-modal__close");
 console.log(popupModal);
setTimeout(function(){
  popupModal.classList.add('animate__animated', 'animate__fadeIn', 'is--visible');
}, 2000);

function setPopupCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
setPopupCookie('popupCookie', 'true', 1);


popupCloseBtn.addEventListener('click', function(){

  popupModal.classList.remove('animate__fadeIn');
  popupModal.classList.add('animate__fadeOut');
  setTimeout(() => {
    popupModal.classList.remove('is--visible');
  }, 1000);
})
</script>