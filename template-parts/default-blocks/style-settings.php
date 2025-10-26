<style>
    

    <?php 
      // get_common_block_styles($block_id);
      
    ?>

    #<?php echo $block_id;?>{
        <?php if(get_field('media_1')):?>
            --media-1: url(<?php echo get_field('media_1');?>);
        <?php endif;
         if(get_field('media_2')):?>
            --media-2: url(<?php echo get_field('media_2');?>);
        <?php endif;
            //background color
             ekwa_acf('background-color', 'background_color');
            
        ?>
    }

<?php
/* conditional bg image */
if(get_field('desktop_only')){
    echo '@media screen and (min-width: 767px){';
        echo '#'.$block_id."{";
            ekwa_acf('background-image', 'image', false, true);
            ekwa_acf('background-size', 'background_size');
            ekwa_acf('background-position', 'background_position');
            ekwa_acf('background-repeat', 'background_repeat');
            ekwa_acf('background-attachment', 'background_attachment');
            
        echo "}";

    echo '}';
}else{
    if(get_field('image')){
    
    echo '#'.$block_id."{";
        if(!get_field('lazyload')){
        ekwa_acf('background-image', 'image', false, true);
        }
        ekwa_acf('background-size', 'background_size');
        ekwa_acf('background-position', 'background_position');
        ekwa_acf('background-repeat', 'background_repeat');
        ekwa_acf('background-attachment', 'background_attachment');
        
    echo "}";
}

}
// end of conditional bg image 

if(get_field('custom_css')):
    echo get_field('custom_css');
endif;
?>


</style>