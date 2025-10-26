<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ekwa
 */

get_header();
?>

  <img style="width: 100%;height: auto;" src="<?php echo get_template_directory_uri(); ?>/images/404.jpg" alt="Page not found">

<section class="main-content">
 <div class="container">
	<div class="inner-page">
	<h1>Page Not Found</h1>
	<p>The page you requested cannot be found. The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
	<p>Please try the following:</p>
	<ul>
			<li>Make sure the page address in the Address bar is spelled correctly.</li>
			<li>Navigate to the desired page from the below navigation.</li>
		</ul>
<div class="sitemap">
								<div id="sidetreecontrol"><a href="javascript:;"  >Collapse All</a>  |  <a href="javascript:;"  >Expand All</a></div>
								<?php
									  wp_nav_menu( array( 
									  'theme_location' =>  'site-map', 
									  'container' => false,
									  'menu_id' => 'tree'
									  ) );
									  
								?>
								
								
								</div>
 </div>
 </div>

</section>
<?php
get_footer();
