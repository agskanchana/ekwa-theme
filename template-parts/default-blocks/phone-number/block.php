<?php

$align = $block['align'];
$block_id = $block['id'];
if( !empty($block['anchor']) ) {
   $block_id = $block['anchor'];
}
$className = 'ek-phone-numbers-wrapper';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
$phone  = 'phone';
if(get_field('type')){
    $phone  = get_field('type');
}
$text = 'New Patients:';
 if(get_field('text')){
     $text = get_field('text');
 }
 $text_color = '#000';
 if(get_field('text_color')){
     $text_color = get_field('text_color');
 }
 $icon_color = '#000';
 if(get_field('icon_color')){
     $icon_color = get_field('icon_color');
 }
 $location = 1;
 if(get_field('location')){
    $location = get_field('location');
 }

 $show = true;

 $phone_number  = get_location($phone, $location);
 $mb_number =  mobile_number($phone_number);

 if( ( isset( $_COOKIE['adward_number'] ) || isset( $_GET['ads'] ) ) && $phone == 'phone' ) {
     $phone_number = get_theme_mod('adsense_number');
     $mb_number    = mobile_number(get_theme_mod('adsense_number'));
     $text = '';
 }
 if( ( isset( $_COOKIE['adward_number'] ) || isset( $_GET['ads'] ) ) && $phone == 'phone_ex' ) {
     $show = false;
 }



if($show):
?>


<div
class="<?php echo $className;?> <?php echo $align;?>"
id="<?php echo $block_id;?>"
>
<a aria-label="phone" href="tel:<?php echo $mb_number;?>">
<i class="fas fa-phone-alt"> </i>
<span> <?php echo $text;?> <?php echo $phone_number;?> </span>
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
    #<?php echo $block_id;?> span{
        color: <?php echo $text_color;?>;
    }
    #<?php echo $block_id;?> i{
        color: <?php echo $icon_color;?>;
    }
    <?php
endif;
    ?>
</style>