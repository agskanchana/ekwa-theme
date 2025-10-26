<?php

/*  font size ****/

if(get_theme_mod('font_body')){
	$main_font = get_theme_mod('font_body');
}else{
	$main_font = array("font-family"=> "Helvetica", "font-weight" => 'normal', "font-style" => 'normal');
	
}
$main_font_mobile = array("font-family"=> "Helvetica", "font-weight" => 'normal', "font-style" => 'normal');

?>



<style>




    :root {
		--heading-h1-size: <?php  ekwa_get_value('font_size_h1','36');?><?php echo "px"?>;
		--heading-h2-size: <?php  ekwa_get_value('$heading_h2','24');?><?php echo "px"?>;
		--heading-h3-size: <?php  ekwa_get_value('font_size_h3','20');?><?php echo "px"?>;
        --body-font-size: <?php  ekwa_get_value('body_font_size','16');?><?php echo "px"?>;
		
		
		--font_body: <?php  ekwa_get_value('font_body',$main_font, 'font-family');?>;
		--body_variant: <?php  ekwa_get_value('font_body',$main_font, 'font-weight');?>;
		--body_style: <?php  ekwa_get_value('font_body',$main_font, 'font-style');?>;
		
		--mobile_body: <?php  ekwa_get_value('font_mobile', $main_font_mobile, 'font-family');?>;
		--mobile_variant: 'normal';
		--mobile_style: 'normal';
		
		--heading_h1: <?php  ekwa_get_value('typo_h1_fonts', $main_font, 'font-family');?>;
		--heading_h1_variant: bold
		--heading_h1_style:  <?php  ekwa_get_value('typo_h1_fonts', $main_font, 'font-style');?>;
		
		
		--heading_h2: <?php  ekwa_get_value('typo_h2_fonts', $main_font, 'font-family');?>;
		--heading_h2_variant: bold;
		--heading_h2_style:  <?php  ekwa_get_value('typo_h2_fonts', $main_font, 'font-style');?>;
		
		--heading_h3: <?php  ekwa_get_value('typo_h3_fonts', $main_font, 'font-family');?>;
		--heading_h3_variant: bold;
		--heading_h3_style:  <?php  ekwa_get_value('typo_h3_fonts', $main_font, 'font-style');?>;
		
		--font-1: <?php  ekwa_get_value('addtional_font_1', $main_font, 'font-family');?>; 
		--font-w-1: <?php  ekwa_get_value('addtional_font_1', $main_font, 'font-weight');?>; 
		--font-s-1:  <?php  ekwa_get_value('addtional_font_1', $main_font, 'font-style');?>; 
		
		--font-2: <?php  ekwa_get_value('addtional_font_2', $main_font, 'font-family');?>;
		--font-w-2: <?php  ekwa_get_value('addtional_font_2', $main_font, 'font-weight');?>; 
		--font-s-2:  <?php  ekwa_get_value('addtional_font_2', $main_font, 'font-style');?>; 
		
	}
</style>