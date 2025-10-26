<?php 
 $block_id = $block['id'];
 if( !empty($block['anchor']) ) {
    $block_id = $block['anchor'];
}
 $className = 'container';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if(get_field('lazyload')){
    $className .='  lazyload';
}
?>
<div 
class="<?php echo $className;?>" 
id="<?php echo $block_id;?>"

data-bg="<?php if(get_field('lazyload')){ echo get_field('image'); }?>"
>
    <InnerBlocks />
</div>
<?php if(is_admin()):?>
<style>
    .wp-admin .container{
        padding: 30px;
        border: 1px dashed grey;
    }
</style>
<?php endif;?>
<?php include( get_template_directory(). "/template-parts/default-blocks/style-settings.php");?>

