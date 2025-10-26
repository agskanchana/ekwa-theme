<?php

class Ekwa_Address_Widget extends WP_Widget {
    // set up widte description name etc..
    public function __construct(){
        $widget_opts = array(
            'classname' => 'ekwa-address-widget',
            'description' => 'Contact info widget'
        );
        parent::__construct('ekwa_address', 'Contact info', $widget_opts);
    }
    
    // backend end of widget
    
    public function form($instance){
        
    }
    
    // front end display
    
    public function widget($args, $instance){
        $widget_id  =  $args['widget_id'];
        ?>
        <div class="<?php echo get_field('grid_class', 'widget_' . $widget_id);?>">
            <div class="ekwa-contact-widget">
                
                
                <?php if(get_field('title', 'widget_' . $widget_id)):?>
                <h2><?php echo get_field('title', 'widget_' . $widget_id);?></h2>
                <?php endif;?>
                <?php if(get_field('footer_logo', 'widget_' .$widget_id)):?>
                    <div class="footer-logo-wrapper">
                        <a href="<?php echo get_option( 'siteurl' );?>">
                          <?php if ( function_exists( 'the_custom_logo' ) ) {
                            $custom_logo_id = get_theme_mod( 'custom_logo' ); 
                            $image = wp_get_attachment_image_src( $custom_logo_id , 'full' ); }?>
                            <img class="lazyload" data-src="<?php echo $image[0];?>" alt="<?php echo get_theme_mod('practise_name');?>">
                        </a>
                    </div>
                <?php endif;?>
                <div class="footer-phone-wrapper">
                    <span class="phone d-block white"><i class="fas fa-phone-alt"></i>
                    New Patients: <a href="tel:<?php echo  mobile_number(get_theme_mod('call_tracking_number'));?>"><?php echo get_theme_mod('call_tracking_number');?></a></span>
                    <span class="phone d-block white"><i class="fas fa-phone-alt"></i>
                    Existing Patients: <a href="tel:+<?php echo  mobile_number(get_theme_mod('existing_patients_phone'));?>"><?php echo get_theme_mod('existing_patients_phone');?></a></span>   
                </div>
                <div class="footer-address">
                  <a target="_blank" rel="noreferrer"  href="<?php echo get_location('direction',1);?>"><i class="fas fa-map-marker-alt"></i></a> <?php echo get_address();?>
                </div>
                
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
                
            </div>
        </div>
        <style>
     .footer-phone-wrapper span{
        display: block;
        margin-bottom: 13px;
    }
    .footer-phone-wrapper{
        margin-bottom: 13px;
    }
    .ekwa-theme-footer, .footer-phone-wrapper a, .footer-address a{
        color: var(--footer-text-color);
    }
    .ekwa-contact-widget{
        text-align: <?php echo get_field('align', 'widget_' . $widget_id);?>
    }

        </style>
        
        <?php
    }    
}

add_action('widgets_init', function(){
 register_widget('Ekwa_Address_Widget');    
    
});
