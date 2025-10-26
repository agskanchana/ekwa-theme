<?php

class Ekwa_SmIcons_Widget extends WP_Widget {
    // set up widte description name etc..
    public function __construct(){
        $widget_opts = array(
            'classname' => 'ekwa-sm-icons-widget',
            'description' => 'Social media Icons widget'
        );
        parent::__construct('ekwa_sm_icons', 'Social Media Icons /  Appointment button', $widget_opts);
    }
    
    // backend end of widget
    
    public function form($instance){
        
    }
    
    // front end display
    
    public function widget($args, $instance){
        $widget_id  =  $args['widget_id'];
        ?>
        <div class="<?php echo get_field('grid_class', 'widget_' . $widget_id);?> sm-icons-widget">
            <?php if( get_field('heading', 'widget_' . $widget_id)):?>
                <h2><?php echo get_field('heading', 'widget_' . $widget_id);?></h2>
           <?php endif;?>
           <?php if(get_field('social_media_icons', 'widget_' .$widget_id)):?>
                <?php
                            $sm_links  = get_theme_mod( 'social_media_links', null );
                            if($sm_links):
                          ?>
                           <?php include(get_template_directory()."/inc/ekwa-widgets/footer-widgets/social-media-icons.php");?>
                          
                <?php endif;?>
            <?php endif;?>
            <?php if(get_field('appointment_button', 'widget_' .$widget_id)):?>
            <div class="ftr-app-btn">
                <a class="btn app-btn-ftr" href="<?php  echo appointment_page_link();?>">Request an Appointment </a>
            </div>
            <?php endif;?>

        </div>
        <style>
            .sm-icons-widget{
                text-align: <?php echo get_field('align', 'widget_' . $widget_id);?>;
            }
        </style>
        <?php
    }    
}

add_action('widgets_init', function(){
 register_widget('Ekwa_SmIcons_Widget');    
    
});
