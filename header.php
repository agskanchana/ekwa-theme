<?php
 if(isset($_GET['ads'])){
	setcookie("adward_number", "1", strtotime( '+14 days' ));
 }
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<?php if (is_paged() ): ?>
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<?php endif?>
    <?php require get_template_directory() . '/settings/customizer-font-end/index.php'; ?>
	<?php if(is_ie()):?>
	<script src="<?php echo get_template_directory_uri(); ?>/js/ie-11-fix.js"></script>
	<?php endif;?>
     <script type="text/javascript">
        var TEMPDIR = '<?php echo get_template_directory_uri(); ?>';
		var contactBlock = false;
		var appForm  = false;
		<?php if(is_mobile()):?>
		var mobileDevice = true;
		<?php else:?>
		var mobileDevice = false;
		<?php endif;?>
    </script>
</head>
<body <?php body_class(); ?>>
<div class="page-<?php echo get_the_ID();?>">

<?php
include( get_template_directory().'/template-parts/mobile-header.php');
$show_popup = false;
$show_popup = get_theme_mod('show_popup');
if($show_popup){
include( get_template_directory(). '/template-parts/popup/index.php');
}
if (class_exists('ACF')) {
	  if(get_field('custom_header') && get_field('select_header')){
			$headerID  = get_field('select_header');
			$header = get_post($headerID);
			echo apply_filters('the_content',$header->post_content);
	  }
	  else{
		 $headerID   = get_theme_mod('select_header', 1);
		 if($headerID != 1){
			$header = get_post($headerID);
			if($header){
			echo apply_filters('the_content',$header->post_content);
			}
		 }
	  }
}
?>
