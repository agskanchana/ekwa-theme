<?php
 if(get_field('menu_slug')){
    $menuslug = get_field('menu_slug');
 }else{
    $menuslug = 'site-map';
 }
?>

<div class="sitemap">
  <div id="sidetreecontrol"><a href="javascript:;"  >Collapse All</a>  |  <a href="javascript:;"  >Expand All</a></div>
<?php
      wp_nav_menu( array( 
      'theme_location' =>  $menuslug, 
      'container' => false,
      'menu_id' => 'tree'
      ) );
      
?>


<?php
  wp_enqueue_script('treeviewjs', get_template_directory_uri().'/template-parts/theme-blocks/'.basename(dirname(__FILE__)).'/treeview.js', array(), '1.0.0', true);
  wp_enqueue_style('treeviewcss',get_template_directory_uri().'/template-parts/theme-blocks/'.basename(dirname(__FILE__)).'/treeview.css', array(),'1.0.0','all', true);
?>

</div>