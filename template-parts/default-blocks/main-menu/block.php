<?php include('settings.php');?>

<style>

    .main-menu-wrapper{
        display: flex;
        gap: 0.5em;
        flex-wrap: wrap;
        align-items: center;
        position: relative;
    }
    .main-menu-wrapper .menu:only-child{
        flex-grow: 1;
    }
    .main-menu-wrapper .menu{
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        justify-content: flex-start;
        align-items: center;
        gap: var(--gap);
    }
    .main-menu-wrapper ul{
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .main-menu-wrapper ul li{
        display: flex;
        align-items: center;
        position: relative;
    }
    .main-menu-wrapper ul li a:hover,
    .main-menu-wrapper ul li a{
        text-decoration: none;
    }
    .main-menu-wrapper  ul  li  ul{
        background-color: var(--sub_menu_background);
        border: 1px solid rgba(0,0,0,.15);
        position: absolute;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: normal;
        opacity: 0;
        transition: opacity .1s linear;
        visibility: hidden;
        width: 0;
        height: 0;
        overflow: hidden;
        left: -1px;
        top: 100%;
    }
    .main-menu-wrapper  ul  li  ul li {
        border-bottom: 1px solid var(--separator);
    }
    .main-menu-wrapper  ul li:hover > ul{
        visibility: visible;
        overflow: visible;
        opacity: 1;
        width: auto;
        height: auto;
        min-width: var(--sub_menu_width);
    }

    <?php if(get_field('sub_menu_class')):?>
    .main-menu-wrapper.two-columns-menu > ul > li.<?php echo get_field('sub_menu_class');?> > ul
    <?php else:?>
    .main-menu-wrapper.two-columns-menu > ul > li > ul
    <?php endif;?>
    {
        flex-direction: row;
        flex-wrap: wrap;
    }
    <?php if(get_field('sub_menu_class')):?>
    .main-menu-wrapper.two-columns-menu > ul > li.<?php echo get_field('sub_menu_class');?> > ul > li
    <?php else:?>
    .main-menu-wrapper.two-columns-menu > ul > li > ul > li
    <?php endif;?>
    {
        max-width: 50%;
        flex: 0 0 50%;
    }

    <?php if(get_field('sub_menu_class')):?>
    .main-menu-wrapper.two-columns-menu > ul > li.<?php echo get_field('sub_menu_class');?>:hover > ul
    <?php else:?>
    .main-menu-wrapper.two-columns-menu > ul > li:hover > ul
    <?php endif;?>
    {
       min-width: var(--two_cols-menu-width);
    }

    
    .main-menu-wrapper  ul  li  ul  li  a{
        display: flex;
        flex-grow: 1;
        padding: .5em 1em;
        align-items: center;
        background: var(--sub_menu_link_background);
        color: var(--sub_menu_link_text_color);
        transition: all 300ms;
    }
    .main-menu-wrapper ul li ul li a:hover,
    .main-menu-wrapper ul li ul li.current_page_item > a,
    .main-menu-wrapper ul li ul li.current_page_ancestor > a{
        background: var(--sub_menu_link_background_hover);
        color: var(--submenu_link_text_color_hover);
    }
    .main-menu-wrapper.show-icons > ul > li.menu-item-has-children > a::after{
        content: "\f107";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        margin-left: 2px;
    }
    .main-menu-wrapper.show-icons > ul > li > ul > li.menu-item-has-children > a::after{
        content: "\f105";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        margin-left: 2px;
    }
    .main-menu-wrapper ul li ul li ul{
        left: 100%;
        top: -1px;
    }

    .main-menu-wrapper > ul > li > a{
        background: var(--link_bg);
        color: var(--text_color);
        padding-left: var(--link_padding_x);
        padding-right: var(--link_padding_x);
        padding-top: var(--link_padding_y);
        padding-bottom: var(--link_padding_y);
        transition: all 200ms;
    }
    .main-menu-wrapper > ul > li > a:hover,
    .main-menu-wrapper > ul > li.current_page_item > a,
    .main-menu-wrapper > ul > li.current-menu-ancestor > a{
        background: var(--link_bg_hover);
        color: var(--text_color_hover);
    }
</style>
<nav class="main-menu-wrapper show-icons <?php echo $two_cols_menu;?>">
    <?php main_menu();  ?>
</nav>