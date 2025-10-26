<div class="gallery-container">
<?php
$categories = get_terms( array( 'taxonomy'   => 'before-after-category', 'hide_empty' => true ) );?>
		<div class="select-proceedure">
			<span>Select Procedure</span>
			<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ):?>
				<select id="before-after-categories">
					<option selected="selected" value="all">All</option>
					<?php foreach($categories as $category):?>
					<option value="<?php echo $category->term_id;?>"><?php echo $category->name;?></option>
					<?php endforeach;?>
				</select>
			
		</div>
	<?php endif;?>
    
    <?php if(get_field('carousel')):?>
    <?php
        require_once('carousel.php');
     ?>
    <?php else:?>
     <?php
        require_once('no-carousel.php');
     ?>
    <?php endif;?>
   
</div>
<style>
	.select-proceedure{
		margin-top: 30px;
		text-align: center;
	}
	.select-proceedure span{
		display: inline-block;
		margin-right: 20px;
	}
	.select-proceedure select{
		padding: 10px;
		max-width: 250px;
		width: 100%;
	}
	.ba-category{
		padding-top: 20px;
		padding-bottom: 20px;
		border-bottom: 1px solid #c0c0c0;
	}
	.ba-category h2{
		margin-bottom: 20px;
		text-align: center;
 	}
	.ba-category.hide{
		display: none;
	}
	.ba-wrapper{
		margin-bottom: 30px;
	}
	.ba-wrapper img{
		width: 100%;
	}
	.ba-wrapper span{
		display: block;
		padding-top: 10px;
		padding-bottom: 10px;
		text-align: center;
		background: <?php echo get_field('label_background');?>;
		color: <?php echo get_field('label_text_color');?>;
	}
    .ba-description{
        margin-top: 25px;
    }

</style>
<script>
	 
document.querySelector("#before-after-categories").addEventListener('change', function(){

console.log('workng');
	// document.querySelector("#ba-category-"+this.value).style.display  = 'none';

	var selected = 'ba-category-'+this.value;

	var categories = document.querySelectorAll(".ba-category")
	categories.forEach(function(category){

		category.classList.remove('hide');

		if(selected == 'ba-category-all'){
			return;
		}

		var catId  =  category.getAttribute("id");
		if(catId != selected){
			category.classList.add('hide');
		}

		
	})

})
	 
	 
</script>
<?php


 if(get_field('carousel')){
?>
    <script>
        var baPerPage = <?php echo get_field('per_page_desktop')?>;
        var baPerPageTab = <?php echo get_field('per_page_tab')?>;
        var baPerPageMobile =  <?php echo get_field('per_page_mobile')?>;
        var baGutter =  <?php echo get_field('gutter')?>;
        <?php if(get_field('dots')):?>
        var baDots =  true;
        <?php else:?>
        var baDots =  false;
        <?php endif;?>
        <?php if(get_field('navigation')):?>
        var baNavigation = true;
        <?php else:?>
        var baNavigation = false;
        <?php endif;?>
        
        
        
        
    </script>
<?php
    wp_enqueue_style('owl-carousel-css',get_template_directory_uri().'/plugins/owl-carousel/assets/owl.carousel.min.css', array(),'1.0.0','all', true);
    wp_enqueue_script('owl-carousel-js', get_template_directory_uri().'/plugins/owl-carousel/owl.carousel.min.js', array(), '1.0.0', true);
    wp_enqueue_script('owl-carousel-js-script', get_template_directory_uri().'/template-parts/theme-blocks/'.basename(dirname(__FILE__)).'/script.js', array(), '1.0.0', true);
 }
 wp_enqueue_style('cardcss',get_template_directory_uri().'/layouts/bootstrap/css/card.css', array(),'1.0.0','all', true);

?>
