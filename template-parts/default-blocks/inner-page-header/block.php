<?php
 if(!is_front_page() && is_singular('page')):
     include('banner.php');
     endif;
 if(is_admin()){
    include('banner.php');
 }
     

