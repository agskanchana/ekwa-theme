<?php 

    $link_bg = 'none';
    $text_color  = 'inherit';
    $link_bg_hover = 'none';
    $link_bg_hover = 'none';
    $hover_text_color = 'inherit';
    $link_padding_x = 0;
    $link_padding_y = 0;
    $gap = 0;
    $sub_menu_width = 200;
    $sub_menu_background = '#fff';
    $sub_menu_link_background = 'none';
    $sub_menu_link_text_color = 'inherit';
    $sub_menu_link_background_hover = 'none';
    $submenu_link_text_color_hover = 'inherit';
    $two_cols_menu = '';
    $separator  = 'rgba(0, 0, 0, 0.2)';
   

    if(get_field('background')){
        $link_bg = get_field('background');
    }
    if(get_field('text_color')){
        $text_color = get_field('text_color');
    }
    if(get_field('hover_background')){
        $link_bg_hover  = get_field('hover_background');
    }
    if(get_field('hover_text_color')){
        $hover_text_color  = get_field('hover_text_color');
    }
    if(get_field('padding')){
        $link_padding_x  = get_field('padding');
    }
    if(get_field('padding_y')){
        $link_padding_y  = get_field('padding_y');
    }
    if(get_field('gap')){
        $gap  = get_field('gap')."px";
    }
    if(get_field('width')){
        $sub_menu_width  = get_field('width');
    }
    if(get_field('sub_menu_background')){
        $sub_menu_background  = get_field('sub_menu_background');
    }
    if(get_field('sub_menu_link_background')){
        $sub_menu_link_background  = get_field('sub_menu_link_background');
    }
    if(get_field('sub_menu_link_text_color')){
        $sub_menu_link_text_color  = get_field('sub_menu_link_text_color');
    }
    if(get_field('sub_menu_link_background_hover')){
        $sub_menu_link_background_hover  = get_field('sub_menu_link_background_hover');
    }
    if(get_field('submenu_link_text_color_hover')){
        $submenu_link_text_color_hover  = get_field('submenu_link_text_color_hover');
    }
    if(get_field('two_columns')){
        $two_cols_menu  = 'two-columns-menu';
    }
    if(get_field('separator')){
        $separator = get_field('separator');
    }
    $two_cols_menu_width = $sub_menu_width * 2;
?>
<style>
    .main-menu-wrapper{
        --link_bg: <?php echo $link_bg;?>;
        --text_color: <?php echo $text_color;?>;
        --link_bg_hover: <?php echo $link_bg_hover;?>;
        --text_color_hover: <?php echo $hover_text_color;?>;
        --link_padding_x: <?php echo $link_padding_x;?>px;
        --link_padding_y: <?php echo $link_padding_y;?>px;
        --gap: <?php echo $gap;?>;
        --sub_menu_width: <?php echo $sub_menu_width;?>px;
        --sub_menu_background: <?php echo $sub_menu_background;?>;
        --sub_menu_link_background: <?php echo $sub_menu_link_background;?>;
        --sub_menu_link_text_color: <?php echo $sub_menu_link_text_color;?>;
        --sub_menu_link_background_hover: <?php echo $sub_menu_link_background_hover;?>;
        --two_cols-menu-width: <?php echo $two_cols_menu_width;?>px;
        --separator: <?php echo $separator;?>;
        --submenu_link_text_color_hover: <?php echo $submenu_link_text_color_hover;?>;
    }
</style>