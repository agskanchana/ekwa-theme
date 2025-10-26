<?php

class Ekwa_Gmap_Widget extends WP_Widget {
    // set up widte description name etc..
    public function __construct(){
        $widget_opts = array(
            'classname' => 'ekwa-gmap-widget',
            'description' => 'Google Map widget'
        );
        parent::__construct('ekwa_gmap', 'Google map', $widget_opts);
    }
    
    // backend end of widget
    
    public function form($instance){
        
    }
    
    // front end display
    
    public function widget($args, $instance){
        $widget_id  =  $args['widget_id'];
        ?>
        <div class="<?php echo get_field('grid_class', 'widget_' . $widget_id);?> ekwa-gmap">
                <?php if( get_field('heading', 'widget_' . $widget_id)):?>
                <h2><?php echo get_field('heading', 'widget_' . $widget_id);?></h2>
                <?php endif;?>
                <iframe class="lazyload" data-src="<?php echo get_field('google_map', 'widget_' . $widget_id);?>" width="100%" height="<?php echo get_field('height', 'widget_' . $widget_id);?>" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                
        </div>
        
        <?php
    }    
}

add_action('widgets_init', function(){
 register_widget('Ekwa_Gmap_Widget');    
    
});
