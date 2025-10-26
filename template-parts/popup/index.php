<?php
 if ( !isset( $_COOKIE['popupCookie'] ) && is_front_page() ): 
  if(!is_mobile()){
    include('desktop.php');
  }else{
    include('mobile.php');
  }
endif;
?>