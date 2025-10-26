<?php

class Ekwa_custom_search extends WP_Widget {
    // setup the  widget name , description, etc..
    
    public function __construct() {
        
        $widget_ops = array(
            'classname' => 'ekwa-search-widget',
            'description' => 'Custom ekwa search widget',  
        );
        parent::__construct('ewka_search', 'Ekwa Search', $widget_ops);
        
    }
    
    // back end display of widget
    
    public function form($instance){
        echo "<p>Search</p>";
    }
    
    // front end display of widget
    
    public function widget( $args, $instance){
        
        ?>
        <div class="search-widget">
            <form role="search" method="get" class="search-form" action="<?php echo get_option( 'siteurl' );?>">
                 <span class="screen-reader-text"></span>
                 <input type="search" class="search-field" placeholder="Search …" value="" name="s">
             <button type="submit" class="search-submit">
                <svg width="15px" height="15px" viewBox="0 0 13.753 13.753" xmlns="http://www.w3.org/2000/svg"><path d="M13.755 12.203L10.093 8.54a5.501 5.501 0 10-1.556 1.556l3.662 3.662zM1.561 5.507a3.942 3.942 0 117.884 0 3.942 3.942 0 01-7.884 0z"/></svg>
                <span class="screen-reader-text">Search</span>
            </button>
             </form>
       </div>
       <style>
       .blog-single .sidebar-col .sidebar-wrapper .search-widget {
            position: relative;
            display: block;
            overflow: hidden;
            margin-bottom: 60px;
       }
        .blog-single .sidebar-col .sidebar-wrapper .search-form{
            position: relative;
            display: block;
            max-width: 100%;
        }
        .blog-single .sidebar-col .sidebar-wrapper .search-form input[type="text"], input[type="search"]{
            position: relative;
            display: block;
            background: #fff;
            border: 1px solid #eeeeee;
            color: #222222;
            display: block;
            font-size: 15px;
            font-weight: 400;
            height: 55px;
            letter-spacing: 1px;
            padding-left: 30px;
            padding-right: 60px;
            max-width: 370px;
            width: 100%;
            border-radius: 0px;
            transition: border 500ms ease 0s;
            outline: none;
        }
        .blog-single .sidebar-col .sidebar-wrapper .search-form input[type="text"]:focus, .blog-single .sidebar-col .sidebar-wrapper input[type="search"]:focus{
            border: 1px solid var(--blog-single-color-2);
            background: #fff;
            color: var(--blog-single-color-3);
        }
        .blog-single .sidebar-col .sidebar-wrapper .search-form label{
            width: 100%;
            display: block;
            height: 55px;
            margin-bottom: 0px;
        }
        .blog-single .sidebar-col .sidebar-wrapper .search-form button{
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0px;
            width: 50px;
            height: 100%;
            display: block;
            background: transparent;
            font-size: 14px;
            color: #222222;
            border-left: 1px solid #eeeeee !important;
            line-height: 25px;
            text-align: center;
            border-radius: 0%;
            transition: all 500ms ease 0s;
            padding: 15px 0;
            border: none;
            outline: none;
        }
        .blog-single .sidebar-col .sidebar-wrapper .search-form button:hover{
            background: var(--blog-single-color-2);
        }
        .blog-single .sidebar-col .sidebar-wrapper .search-form button:hover > svg{
            fill: #fff;
        }
        .blog-single .sidebar-col .sidebar-wrapper .search-form button > svg{
            height: 15px;
            width: 15px;
            fill: var(--blog-single-color-3);
        }
       </style>
       
        <?php
        
    }
    
}

add_action( 'widgets_init', function(){
    register_widget('Ekwa_custom_search'); 
});