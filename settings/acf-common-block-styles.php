<?php 
function ekwa_acf($property, $acf_slug, $prefix = false, $bg = false){
			
            if(get_field($acf_slug)):?>
                <?php if($bg):?>
                    <?php echo $property;?> : url("<?php echo get_field($acf_slug);?>");
                <?php else:?>
                    <?php echo $property;?> : <?php echo get_field($acf_slug);?><?php if($prefix){echo $prefix;}?>;
                <?php endif;?>
        
            <?php 
            endif;
    }
        
function ekwa_advanced_border($direction){
    $unit 	=  get_field('border_unit');
    $border_advanced = get_field('border_advanced');
    $size 	=  $border_advanced['border_'.$direction];
    $type 	=  $border_advanced['type_'.$direction];
    $color	=  $border_advanced['color_'.$direction];
    ?>
    border-<?php echo $direction;?>: <?php echo $size;?><?php echo $unit;?> <?php echo $type;?> <?php echo $color;?>;
    <?php
}
function ekwa_advanced_bdrs($directionX, $directionY){
    $unit = get_field('bdrs_unit');
    $bdrs_advance = get_field('bdrs_advance');
    $radius = $bdrs_advance[$directionX.'_'.$directionY.'_radius'];

    if($bdrs_advance[$directionX.'_'.$directionY.'_radius']){
        echo "border-".$directionX."-".$directionY."-radius : ".$radius.$unit.";";
    }

}
        
function ekwa_padding_marging($type, $direction, $device=""){
    $unit = get_field('margin_units');

    $mp_advance = get_field($type.'_advance');
    if($device){
        $mp_advance = get_field($type.'_advance'.'_'.$device);
    }
    
    if($mp_advance[$type.'_'.$direction]){
        echo $type."-".$direction.": ".$mp_advance[$type.'_'.$direction].$unit.";";
    }
}

function ekwa_sizing($width_or_height){
    
    $dimension = get_field($width_or_height);

    if($dimension[$width_or_height.'_size']){
        
        $property = str_replace("_", "-", $width_or_height);

        echo $property.": ".$dimension[$width_or_height.'_size'].$dimension[$width_or_height.'_unit'].";";
    }
    
}

    function ekwa_positioning($direction){
    $position_values = get_field('position_values');
    $unit = get_field('position_units');
    if($position_values['position_'.$direction]){
        echo $direction.": ".$position_values['position_'.$direction].$unit.";";
    }
    }
        
        
        
function get_common_block_styles($block_id){

    if(is_plugin_active('advanced-custom-fields-pro/acf.php')){

        
        
    

        echo '#'.$block_id."{";

            
            // bg color 
            ekwa_acf('background-color', 'background_color');

        
            
            if(get_field('type') == 'Simple'):
                $border = get_field('border');
                if($border['size']):
            ?>
                    border: <?php echo $border['size'];?><?php echo get_field('border_unit');?>  <?php echo  $border['type_simple'];?>  <?php echo $border['border_color'];?>;
            <?php 
                endif;
            endif;

            if(get_field('type') == 'Advance'):
                $advanced_border = get_field('border_advanced');
                
                if($advanced_border['border_top']){
                    ekwa_advanced_border('top');
                }
                if($advanced_border['border_right']){
                    ekwa_advanced_border('right');
                }
                if($advanced_border['border_bottom']){
                    ekwa_advanced_border('bottom');
                }
                if($advanced_border['border_left']){
                    ekwa_advanced_border('left');
                }
        
            endif;


                
                if(get_field('margin_type') == 'Simple'):
                $margin_simple = get_field('margin_simple')['margin_all_sides'];
                $margin_unit = get_field('margin_units');
                if($margin_simple){
                    echo "margin: ".$margin_simple.$margin_unit.";";
                }
                endif;

                if(get_field('margin_type') == 'Advance'):

                ekwa_padding_marging('margin', 'top');
                ekwa_padding_marging('margin', 'right');
                ekwa_padding_marging('margin', 'bottom');
                ekwa_padding_marging('margin', 'left');

                endif;

                if(get_field('padding_type') == 'Simple'):
                $padding_simple = get_field('padding_simple')['padding_all_sides'];
                $padding_unit = get_field('padding_units');
                if($padding_simple){
                    echo "padding: ".$padding_simple.$padding_unit.";";
                }

                endif;

                if(get_field('padding_type') == 'Advance'):

                ekwa_padding_marging('padding', 'top');
                ekwa_padding_marging('padding', 'right');
                ekwa_padding_marging('padding', 'bottom');
                ekwa_padding_marging('padding', 'left');
                endif;

                if(get_field('position') != 'initial'){
                ekwa_acf('position', 'position');
                }
                
                if(get_field('position') != 'initial' || get_field('position') != 'static'){

                ekwa_positioning('top');
                ekwa_positioning('right');
                ekwa_positioning('bottom');
                ekwa_positioning('left');
                }
        echo "}";

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
                ekwa_acf('background-image', 'image', false, true);
                ekwa_acf('background-size', 'background_size');
                ekwa_acf('background-position', 'background_position');
                ekwa_acf('background-repeat', 'background_repeat');
                ekwa_acf('background-attachment', 'background_attachment');
                
            echo "}";
        }

        }
        // end of conditional bg image 
    

    }


}