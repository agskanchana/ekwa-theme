<?php 
$block_id = $block['id'];
if( !empty($block['anchor']) ) {
   $block_id = $block['anchor'];
}
$className = 'gmap-wrapper';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
$width = '100%';
if(get_field('width')){
    $width = get_field('width');
}
$height = '450px';
if(get_field('height'))
{
    $height = get_field('height');
}
$iframe = "";
if(get_field('iframe_source')){
    $iframe = get_field('iframe_source');
}

?>
<div class="<?php echo $className;?>">
    <iframe title="map" class="lazyload" data-src="<?php echo $iframe;?>" height="<?php echo $height;?>" width="<?php echo $width;?>" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>