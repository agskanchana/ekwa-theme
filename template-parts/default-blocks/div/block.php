<?php 
 $block_id = $block['id'];
 if( !empty($block['anchor']) ) {
    $block_id = $block['anchor'];
}
 $className = 'inner-section';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if(get_field('lazyload')){
    $className .='  lazyload';
}
$enable = false;
$tag = 'div';
if(get_field('enable')){
    $enable  = true;
    $tag = 'a';
}
if(is_admin()){
    $tag = 'div';
}
include( get_template_directory(). "/template-parts/default-blocks/style-settings.php");
?>
<<?php echo $tag;?>

<?php 
if($enable && !is_admin()):
    if(get_field('link')):
?>
     href="<?php echo get_field('link')['url'];?>"
     <?php if(get_field('link')['target'] == '_blank'):?>
     target="_blank"
     rel="noreferrer nofollow"
     <?php endif;?>
<?php
endif; 
endif;
?>
class="<?php echo $className;?>" 
id="<?php echo $block_id;?>"

data-bg="<?php if(get_field('lazyload')){ echo get_field('image'); }?>"
>
 <InnerBlocks />   
</<?php echo $tag;?>>
<?php if(is_admin()):?>
<style>
    .wp-admin .inner-section{
        padding: 30px;
        border: 1px solid burlywood;
        display: block !important;
    }
</style>
<?php endif;?>
