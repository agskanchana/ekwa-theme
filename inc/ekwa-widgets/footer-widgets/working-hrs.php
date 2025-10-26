<?php

class Ekwa_Workinghrs_Widget extends WP_Widget {
    // set up widte description name etc..
    public function __construct(){
        $widget_opts = array(
            'classname' => 'ekwa-workinghrs-widget',
            'description' => 'Working Hours widget'
        );
        parent::__construct('ekwa_workinghrs', 'Working Hours', $widget_opts);
    }
    
    // backend end of widget
    
    public function form($instance){
        
    }
    
    // front end display
    
    public function widget($args, $instance){
        $widget_id  =  $args['widget_id'];
        ?>
        <div class="<?php echo get_field('grid_class', 'widget_' . $widget_id);?>">
            <?php if( get_field('heading', 'widget_' . $widget_id )):?>
            <h2><?php echo get_field('heading', 'widget_' . $widget_id );?></h2>
            <?php endif;?>
            <div class="hours-table">
            <?php
                  $working_hrs = get_theme_mod( 'working_hrs', null );
                  if($working_hrs):
            ?>
                <table class="white">
                  <tbody>
                    <?php foreach( $working_hrs as $working_hr ) : ?>
                      <tr>
                        
                        <td class="day"><?php echo $working_hr['day'];?></td>
                        <?php if(!$working_hr['closed']):?>
                        <td class="time"><?php echo $working_hr['opening'];?> - <?php echo $working_hr['closing'];?></td>
                        <?php else: ?>
                        <td class="closed">Closed</td>
                        <?php endif;?>
                     </tr>
                      <?php if($working_hr['extra_text']):?>
                      <tr>
                        <td  colspan="2"><?php echo $working_hr['extra_text'];?></td>
                      </tr>
                      <?php endif;?>
                    <?php endforeach; ?>
                </tbody>
               </table>
            <?php endif;?>
            </div>
            
            <?php if( get_field('appointment_button', 'widget_' . $widget_id )):?>
            <div class="wkh-app-btn-wrapper">
                <a class="btn footer-app-btn" href="<?php echo appointment_page_link();?>">Request an Appointment </a>
            </div>
            <?php endif;?>
            
        </div>
        <style>


    .hours-table{
        position: relative;
        color: var(--footer-text-color);
    }
    .hours-table table{
        width: 100%;
        margin-bottom: 30px;
    }
    .hours-table table td{
        float: left;
        width: 50%;
        white-space: nowrap;
    }
    .hours-table table tr{
        border-bottom: solid 1px var(--footer-text-color);
        line-height: 35px;
    }
    .hours-table table .day{
        float: left;
        text-align: left;
        letter-spacing: .05em;
    }
    .hours-table table .closed{
        text-align: right;
    }
    .hours-table table .time{
        float: right;
        text-align: right;
        font-size: 16px;
        text-transform: none;
    }
    .wkh-app-btn-wrapper{
        text-align: center;
    }

        </style>
        
        <?php
    }    
}

add_action('widgets_init', function(){
 register_widget('Ekwa_Workinghrs_Widget');    
    
});
