<?php

class Ekwa_footerMenu_Widget extends WP_Widget {
    // set up widte description name etc..
    public function __construct(){
        $widget_opts = array(
            'classname' => 'ekwa-footer-menu-widget',
            'description' => 'Footer menu widget'
        );
        parent::__construct('ekwa_footer_menu', 'Footer menu', $widget_opts);
    }
    
    // backend end of widget
    
    public function form($instance){
        
    }
    
    // front end display
    
    public function widget($args, $instance){
        $widget_id  =  $args['widget_id'];
        ?>
        <div class="<?php echo get_field('grid_class', 'widget_' . $widget_id);?> footer-menu-wrapper">
                <?php if( get_field('heading', 'widget_' . $widget_id)):?>
                <h2><?php echo get_field('heading', 'widget_' . $widget_id);?></h2>
                <?php endif;?>
                <?php 
                    wp_nav_menu( array(  
                    'theme_location' => 'footer-menu',  
                    'container' => false
                     )); 
                ?>
                
                <?php if(get_field('social_media_icons', 'widget_' .$widget_id)):?>
                <?php
                            $sm_links  = get_theme_mod( 'social_media_links', null );
                            if($sm_links):
                          ?>
                           <?php include(get_template_directory()."/inc/ekwa-widgets/footer-widgets/social-media-icons.php");?>
                          
                          <?php endif;?>
                <?php endif;?>
                <?php if(get_field('appointment_button', 'widget_' .$widget_id)):?>
                <div class="footer-app-btn">
                    <a href="<?php  echo appointment_page_link();?>" class="btn">Request an Appointment</a>
                </div>
                <?php endif;?>
                
                <?php if( get_field('align', 'widget_' . $widget_id) == 'center'):?>
                <style>
                    .footer-menu-wrapper ul{
                        list-style: none;
                        padding: 0;
                        display: flex;
                        justify-content: center;
                    }
                    .footer-menu-wrapper ul li{
                        margin-right: 20px;
                        margin-right: 20px;
                    }
                    .footer-menu-wrapper ul li a:hover{
                        text-decoration: none;
                    }
                    .footer-menu-wrapper .social-media, .footer-menu-wrapper .footer-app-btn{
                        text-align: center;
                    }
                </style>
                <?php endif;?>
                <?php if( get_field('align', 'widget_' . $widget_id) == 'left'):?>
                <style>
                    .footer-menu-wrapper ul{
                        list-style: none;
                        padding: 0;
                    }
                    .footer-menu-wrapper ul li{
                        margin-bottom: 10px;
                    }
                    .footer-menu-wrapper ul li a{
                        text-decoration: none;
                    }
                    .footer-menu-wrapper .social-media, .footer-menu-wrapper .footer-app-btn{
                        text-align: left;
                    }
                </style>
                <?php endif;?>
                <?php if( get_field('align', 'widget_' . $widget_id) == 'right'):?>
                <style>
                    .footer-menu-wrapper ul{
                        list-style: none;
                        padding: 0;
                        text-align: right;
                    }
                    .footer-menu-wrapper ul li{
                        margin-bottom: 10px;
                    }
                    .footer-menu-wrapper ul li a{
                        text-decoration: none;
                    }
                    .footer-menu-wrapper .social-media, .footer-menu-wrapper .footer-app-btn{
                        text-align: right;
                    }
                </style>
                <?php endif;?>
                
                
                
        </div>
        
        <?php
    }    
}

add_action('widgets_init', function(){
 register_widget('Ekwa_footerMenu_Widget');    
    
});
