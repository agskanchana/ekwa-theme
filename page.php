<?php get_header(); ?>
<section class="main-content">
<div class="container">
	<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/content', 'page' );
		endwhile; // End of the loop.

	?>
</div>
</section>
<?php get_footer();
