 <?php
	foreach($categories as $category){
		
			$args_ba = array(
			  'post_type' => 'ekwa_before_after',
			  'posts_per_page' => -1,
			  'tax_query' => array(
					  array (
						  'taxonomy' => 'before-after-category',
						  'field' => 'term_id',
						  'terms' => $category->term_id,
					  )
				  )
			  );

		// The Query
		$beforeQuery = new WP_Query( $args_ba );
		 
		 if($beforeQuery->have_posts()){
		 echo '<div class="row ba-category" id="ba-category-'.$category->term_id.'">';
		 echo '<div class="col-md-12"><h2>'.$category->name.'</h2></div>';
			// The Loop
			while ( $beforeQuery->have_posts() ) {
				$beforeQuery->the_post();
				
				?>
				
				<div class="col-md-6">
					<div class="row ba-wrapper">
						<div class="col-12">
						   <?php
						   $thumb_id = get_post_thumbnail_id();
						   $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
						   $thumb_url = $thumb_url_array[0];
						   $alt = get_post_meta ( $thumb_id, '_wp_attachment_image_alt', true );
						?>
						<img  src="<?php echo $thumb_url;?>" alt="<?php echo $alt;?>">
						<p><?php echo the_title();?></p>
						</div>
                        <?php if(get_field('description', get_the_ID())):?>
                        <div class="col-12">
                            <div class="ba-description">
                                <div class="card">
                                    <div class="card-body">
                                      <?php echo get_field('description', get_the_ID());?>
                                    </div>
                                  </div>
                            </div>
                        </div>
                        <?php endif;?>
					</div>
				</div>
				
				<?php
			}
			echo "</div>";
		}
		 
		wp_reset_postdata();
	}
?>

<style type="text/css">
	.ba-wrapper p {
		text-align: center;
	}
	.col-md-6 {
		padding: 0 15px;
	}
	@media (min-width: 768px) {
		.row {
			display: flex;
			flex-direction: row;
			flex-wrap: wrap;
		}
		.col-12, .col-md-12 {
			width: 100%;
		}
		.col-md-6 {
			width: 50%;
			padding: 0 15px;
		}
	}
</style>