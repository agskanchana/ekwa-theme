<?php
$font_one = get_theme_mod( 'font_one', [] );
$font_two = get_theme_mod( 'font_two', [] );
$font_three = get_theme_mod( 'font_three', [] );
$font_four = get_theme_mod( 'font_four', [] );
$font_five = get_theme_mod( 'font_five', [] );
?>

<style>
    :root {

        <?php if($font_two['font-family']):?>
        --font_two: <?php echo $font_two['font-family'];?>;
        --varient_two: <?php echo $font_two['font-weight'];?>;
        <?php endif;?>
        <?php if($font_three['font-family']):?>
        --font_three: <?php echo $font_three['font-family'];?>;
        --varient_three: <?php echo $font_three['font-weight'];?>;
        <?php endif;?>
        <?php if($font_four['font-family']):?>
        --font_four: <?php echo $font_four['font-family'];?>;
        --varient_four: <?php echo $font_four['font-weight'];?>;
        <?php endif;?>
        <?php if($font_five['font-family']):?>
        --font_five: <?php echo $font_five['font-family'];?>;
        --varient_five: <?php echo $font_five['font-weight'];?>;
        <?php endif;?>
	}
</style>
