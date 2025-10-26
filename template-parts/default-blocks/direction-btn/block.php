<?php
$block_id = $block['id'];
if( !empty($block['anchor']) ) {
   $block_id = $block['anchor'];
} 
  $mode = 'icon';
  if(get_field('mode')){
      $mode = get_field('mode');
  }
 $className = 'address_direction_link';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
$text_color =  '#000';
if(get_field('color')['text_color']){
    $text_color = get_field('color')['text_color'];
}
$icon_color =  '#000';
if(get_field('color')['icon_color']){
    $icon_color = get_field('color')['icon_color'];
}
$location = 1;
if(get_field('location')){
   $location = get_field('location');
}
?>
<a class="<?php echo $className;?> <?php if($mode == 'icon'){echo 'btn direction_ico_btn';}?>" 
id="<?php echo $block_id;?>"
 target="_blank" rel="noreferrer nofollow" aria-label="direction button" href="<?php echo get_location('direction', $location);?>">
    <i class="fas fa-map-marker-alt"></i>
    <?php if($mode == 'text'):?>
     <span class="direction_text">Directions</span>
    <?php endif;?>
    <?php if($mode == 'address'){
        echo get_address($location);
    }
    ?>
</a>
<style>
    <?php if($mode == 'address' || $mode == 'text'):
    ?>
    #<?php echo $block_id;?>{
        color: <?php echo $text_color;?>;
    }
    #<?php echo $block_id;?> i{
        color: <?php echo $icon_color;?>;
    }
    <?php endif;?>
</style>