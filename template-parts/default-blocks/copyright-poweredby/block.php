<?php 
$align = $block['align'];
$block_id = $block['id'];

if( !empty($block['anchor']) ) {
   $block_id = $block['anchor'];
}

$className = 'copyright-poweredby';
if( !empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
$text_color = '#000';
if(get_field('text_color')){
    $text_color = get_field('text_color');
}
$link_color = '#000';
if(get_field('link_color')){
    $link_color = get_field('link_color');
}
$link_color_hover = '#000';
if(get_field('link_color_hover')){
    $link_color_hover = get_field('link_color_hover');
}
?>

<div class="<?php echo $className." ".$align;?>" id="<?php echo $block_id;?>">
&copy; <?php echo date("Y");?> <?php echo get_theme_mod('practise_name', '');?>. All Rights Reserved. Powered by <a target="_blank" rel="noreferrer nofollow" href="https://www.ekwa.com">www.ekwa.com</a> 
</div>

<style>
    #<?php echo $block_id;?>.left{
        text-align: left;
    }
    #<?php echo $block_id;?>.right{
        text-align: right;
    }
    #<?php echo $block_id;?>.center{
        text-align: center;
    }
    #<?php echo $block_id;?>{
        color: <?php echo $text_color?>;
    }
    #<?php echo $block_id;?> a{
        color: <?php echo $link_color?>;
    }
    #<?php echo $block_id;?> a:hover{
        color: <?php echo $link_color_hover?>;
    }
</style>