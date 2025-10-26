<?php

class Ekwa_Logo_Widget extends WP_Widget {
    // set up widte description name etc..
    public function __construct(){
        $widget_opts = array(
            'classname' => 'ekwa-logo-widget',
            'description' => 'Logo widget'
        );
        parent::__construct('ekwa_logo', 'Logo', $widget_opts);
    }
    
    // backend end of widget
    
    public function form($instance){
        
    }
    
    // front end display
    
    public function widget($args, $instance){
        $widget_id  =  $args['widget_id'];
        ?>
        <div class="<?php echo get_field('grid_class', 'widget_' . $widget_id);?> ekwa-logo">
            <div class="header-logo-wrapper">
                <?php echo get_custom_logo();?>
            </div>
        </div>
        <style>
            .header-logo-wrapper img{
                max-width: 100%;
            }
        </style>
        <?php
    }    
}

add_action('widgets_init', function(){
 register_widget('Ekwa_Logo_Widget');    
    
});
