<?php

class Ekwa_Copyright_Widget extends WP_Widget {
    // set up widte description name etc..
    public function __construct(){
        $widget_opts = array(
            'classname' => 'ekwa-copyright-widget',
            'description' => 'Copyright & Poweredby widget'
        );
        parent::__construct('ekwa_copyright', 'Copyright & Poweredby', $widget_opts);
    }
    
    // backend end of widget
    
    public function form($instance){
        
    }
    
    // front end display
    
    public function widget($args, $instance){
        $widget_id  =  $args['widget_id'];
        ?>
        <div class="<?php echo get_field('grid_class', 'widget_' . $widget_id);?> copyright-poweredby">
         <span class="footer-copyright">
            &copy; <?php echo date('Y'); ?> <?php echo get_theme_mod('practise_name');?>. All rights reserved.
         </span>
         <span class="poweredby">
             Powered by <a rel="noreferrer" target="_blank" href="https://www.ekwa.com">www.ekwa.com</a>
         </span>
        </div>
        <style>
            .copyright-poweredby{
                padding-top: 25px;
                padding-bottom: 25px;
                text-align: <?php echo get_field('align', 'widget_' . $widget_id);?>;
            }
        </style>
        <?php
    }    
}

add_action('widgets_init', function(){
 register_widget('Ekwa_Copyright_Widget');    
    
});
