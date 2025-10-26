<?php

$color_one = get_theme_mod('color_one', '#000000');
$color_two = get_theme_mod('color_two', '#1e73be');
$color_three = get_theme_mod('color_three', '#30475e');
$color_four = get_theme_mod('color_four', '#f2a365');
$color_five = get_theme_mod('color_five', '#639a67');
$color_text = get_theme_mod('color_text', '#000000');
$color_link = get_theme_mod('color_link', '#1b315e');
$color_link_hover = get_theme_mod('color_link_hover', '#000000');
$color_headings = get_theme_mod('color_headings', '#000000');
$color_invert = get_theme_mod('color_invert', '#ffffff');



?>
<style>
    :root {
		--color_one: <?php echo $color_one;?>;
		--color_two: <?php echo $color_two;?>;
		--color_three: <?php echo $color_three;?>;
		--color_four: <?php echo $color_four;?>;
		--color_five: <?php echo $color_five;?>;
		--color_text: <?php echo $color_text;?>;
		--color_link: <?php echo $color_link;?>;
		--color_link_hover: <?php echo $color_link_hover;?>;
		--color_headings: <?php echo $color_headings;?>;
		--color_invert: <?php echo $color_invert;?>; 
	}
</style>

