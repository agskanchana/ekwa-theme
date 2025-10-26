<?php 
$align = $block['align'];
$block_id = $block['id'];
if( !empty($block['anchor']) ) {
   $block_id = $block['anchor'];
}
$className = 'fontawesome-icon';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
$fa_class = 'fa-solid fa-house';
if(get_field('fa_class')){
    $fa_class = get_field('fa_class');
}
$link = get_field('link');
if(get_field('phone_number')){
    $link_src = 'tel:'.mobile_number(get_theme_mod('call_tracking_number'));
}else{
   if($link){
    $link_src = $link['url'];
   }
}
?>
<div id="<?php echo $block_id;?>" class="<?php echo $className;?> <?php echo $align;?>">

 <?php if($link || get_field('phone_number')):?>
    <a
    <?php 
    if(!get_field('phone_number')):
    if($link['target'] == '_blank'):
    ?>
    target="_blank" 
    <?php
     endif;
    endif;
    ?>
 aria-label="fa-icon" href="<?php echo $link_src;?>">
 <?php endif;?>
 <i  class="<?php echo $fa_class;?>"></i>
 <?php if($link || get_field('phone_number')):?>
    </a>
<?php endif;?>
</div>
<style>
    #<?php echo $block_id;?>.left{
        text-align: left;
    }
    #<?php echo $block_id;?>.center{
        text-align: center;
    }
    #<?php echo $block_id;?>.right{
        text-align: right;
    }
</style>