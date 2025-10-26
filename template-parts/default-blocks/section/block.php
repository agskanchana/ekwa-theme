<?php 
 $block_id = $block['id'];
 if( !empty($block['anchor']) ) {
    $block_id = $block['anchor'];
}
$html_element = 'section';
if(get_field('html_element')){
    $html_element = get_field('html_element');
}
 $className = $html_element;
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if(get_field('lazyload')){
    $className .='  lazyload';
}
 include( get_template_directory(). "/template-parts/default-blocks/style-settings.php");
 ?>
<<?php echo $html_element;?> 
class="<?php echo $className;?>" 
id="<?php echo $block_id;?>"

data-bg="<?php if(get_field('lazyload')){ echo get_field('image'); }?>"
>
 <InnerBlocks />   
</<?php echo $html_element;?> >
<?php if(is_admin()):?>
<style>
    .wp-admin .<?php echo $html_element;?>{
        padding: 30px;
        border: 1px solid burlywood;
    }
</style>
<?php endif;?>
<style>
    .ekwa-body #<?php echo $block_id;?>{
        position: relative;
        width: 100vw;
		left: 50%;
		right: 50%;
		margin-left: -50vw;
		margin-right: -50vw;
    }
</style>
