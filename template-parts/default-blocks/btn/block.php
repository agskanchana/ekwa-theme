<?php
$align = $block['align'];
$block_id = $block['id'];
if( !empty($block['anchor']) ) {
   $block_id = $block['anchor'];
}
$className = 'btn';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
$link = get_field('link');



if(get_field('phone_number')){

    if(( isset( $_COOKIE['adward_number'] ) || isset( $_GET['ads'] ) )){
        $phone_number = mobile_number(get_theme_mod('adsense_number'));
        $phone_number_desktop = get_theme_mod('adsense_number');
    }else{
        $phone_number = mobile_number(get_theme_mod('call_tracking_number'));
        $phone_number_desktop = get_theme_mod('call_tracking_number');
    }

    $link_src = 'tel:'.$phone_number;
}else{
   if($link){
    $link_src = $link['url'];
   }
}


?>
<div
class="btn-wrapper  <?php if($align){echo $align;}?>"
id="<?php echo $block_id;?>"
>

<a

<?php if(get_field('custom_attribute')):

    echo get_field('attribute_name')."='".get_field('attribute_value')."'";

 endif;?>

class="<?php echo $className;?>"
 <?php if($link):?>
    <?php if($link['target'] == '_blank'):?>
    target="_blank"
    <?php endif;?>
 <?php endif;?>
 href="<?php if($link){echo $link_src;} if(get_field('phone_number')){echo $link_src;}?>">

 <?php
 echo get_field('text');
 if(get_field('phone_number')){
    if(!is_mobile()){
        echo $phone_number_desktop;
    }
 }
?>
 <?php if(get_field('icon')):?>
    <i class="<?php echo get_field('icon');?>"></i>
 <?php endif;?>
</a>
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
</style>
