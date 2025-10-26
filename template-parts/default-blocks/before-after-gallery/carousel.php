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
         ?>
         <div class="owl-carousel ba-carousel owl-theme">
		<?php	// The Loop
			while ( $beforeQuery->have_posts() ) {
				$beforeQuery->the_post();
				
				?>
				
				<div class="before-after-item">
					<div class="row ba-wrapper">
						<div class="col-12">
						   <?php
						   $thumb_id = get_post_thumbnail_id();
						   $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
						   $thumb_url = $thumb_url_array[0];
						   $alt = get_post_meta ( $thumb_id, '_wp_attachment_image_alt', true );
						?>
						<img src="<?php echo $thumb_url;?>" alt="<?php echo $alt;?>">
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
			echo "</div>";
		}
		 
		wp_reset_postdata();
	}
?>
<style>
   .ba-category .owl-theme .owl-nav{
	  margin-top: 0 !important;
	  font-size: 24px;
	  color: var(--color_one);
   }
   .ba-category .owl-theme .owl-dots .owl-dot.active span,
   .ba-category .owl-theme .owl-dots .owl-dot:hover span,
   .ba-category .owl-theme .owl-dots .owl-dot span{
	  background: var(--color_one);
	  opacity: 1;
   }
   .ba-category .owl-theme .owl-dots .owl-dot span{
	  opacity: 0.5;
   }
   .ba-category .owl-theme .owl-nav [class*="owl-"]:hover{
	  background: none !important;
	  color: inherit;
   }
</style>