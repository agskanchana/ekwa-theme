<?php
if(is_front_page() || is_admin()){
  if(is_mobile()){
    include("mobile.php");
   }
   if(is_tab() || !is_mobile()){
    include("desktop.php");
   }
 }
 
 if(is_admin()){
  include("mobile.php");
 }
 
 
?>