<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ekwa
 */

?>

<article class="<?php page_class();?>">
<?php
			ekwa_the_title($post->ID);
		$output =  apply_filters( 'the_content', $post->post_content );
			echo ekwa_content($output);

?>
			
</article>
