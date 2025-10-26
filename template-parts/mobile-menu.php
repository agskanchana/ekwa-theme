<style>
 
.mm-spn li a, .mm-spn li span  {
    display: flex;
    display: -webkit-flex;
    align-items: center;
}
.mm-spn li a span, .mm-spn li span span{
    padding: 0;
}
.mm-spn li a i, .mm-spn li span span i {
    padding: 0;
    margin-right: 10px;
    font-size: 15px;
    width: 20px;
}
.mm-spn li.mm-close-btn:before {
    content: none;
}
.mm-spn li a:hover {
  color: #000;
}

#menu3 label {
  display: inline;
}
#menu3 li i {
  padding-top: 15px;
  margin-left: 20px;
}
#menu3 ul li:before {
  content: none;
}
.mmenu-close{
  position: absolute;
  top: 8px;
  right: 12px;
  width: auto;
  height: 50px;
  color: #000;
  display: block;
  cursor: pointer;
  z-index: 5000;
}
.mobile-slide-menu span.m-menu-icon {
  position: absolute;
  display: inline-block;
  padding: 0px;
  left: 8px;
}
</style>
<nav id="my-menu" class="mobile-slide-menu" aria-label="Mobile menu">
 <?php
      wp_nav_menu( array( 
      'theme_location' => 'mobile-menu', 
      'container' => false
      
      ) ); 
?>
<div class="mmenu-close" id="menu1Close">
  <i class="fas fa-times"></i>
</div>
</nav>

<nav id="menu2" class="mobile-slide-menu" aria-label="Treatment menu">
 <?php
      wp_nav_menu( array( 
      'theme_location' => 'mobile-menu-services', 
      'container' => false
      
      ) ); 
?>
<div class="mmenu-close" id="menu2Close">
  <i class="fas fa-times"></i>
</div>
</nav>

<nav id="menu3" class="mobile-slide-menu" aria-label="Phone numbers menu">
 <ul class="phone-menu">
  <li><i class="fa fa-phone"></i> New Patients: <label><a aria-label="phone" href="tel:<?php echo  mobile_number(get_theme_mod('call_tracking_number'));?>"><?php echo get_theme_mod('call_tracking_number');?></a></label></li>
  <li><i class="fa fa-phone"></i> Existing Patients: <label><a aria-label="phone" href="tel:<?php echo  mobile_number(get_theme_mod('existing_patients_phone'));?>"><?php echo get_theme_mod('existing_patients_phone');?></a></label></li>
 </ul>
<div class="mmenu-close" id="menu3Close">
  <i class="fas fa-times"></i>
</div>
</nav>