<?php 
$align = $block['align'];
$block_id = $block['id'];
if( !empty($block['anchor']) ) {
   $block_id = $block['anchor'];
}
$className = 'webp-img';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

?>
<?php if(get_field('link')):?>
<a <?php if(get_field('link')['target'] == '_blank'):?>  target="_blank" rel="noreferrer nofollow"  <?php endif; ?> href="<?php echo get_field('link')['url'];?>">
<?php endif;?>
<picture id="<?php echo $block_id;?>" class="<?php echo $className;?> <?php if($align){echo $align;}?>">
    <source srcset="<?php echo get_field('webp_image');?>" type="image/webp">
    <?php
     $fall_back_image = get_field('fall_back_image');
    ?>
    <img width="<?php echo $fall_back_image['width'];?>" height="<?php echo $fall_back_image['height'];?>" src="<?php echo $fall_back_image['url'];?>" alt="<?php echo $fall_back_image['alt'];?>">
</picture>
<?php if(get_field('link')):?>
</a>
<?php endif;?>
<style>
    .webp-img{
        display: block;
    }
    .webp-img img{
        vertical-align: bottom;
    }
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