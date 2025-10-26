<?php 
$block_id = $block['id'];
if( !empty($block['anchor']) ) {
   $block_id = $block['anchor'];
}
$className = 'conditional-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
?>

<div class="<?php echo $className;?>" id="<?php echo $block_id;?>" >
    <InnerBlocks />
</div>
<style>
   .wp-admin .conditional-block{
        padding: 30px;
        border: 1px solid orange;
        display: block !important;
    }
</style>