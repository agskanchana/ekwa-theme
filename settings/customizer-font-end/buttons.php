<?php

$button_styles = get_theme_mod('button_styles', 'style-1');

?>
<style>
    <?php if ( true == get_theme_mod( 'btn_custom_styles', false ) ) : ?>
    :root {
        --btn-color-one: <?php echo get_theme_mod('button_color_1', '#000000');?>;
        --btn-color-two: <?php echo get_theme_mod('button_color_2', '#ffffff');?>;
    }
    <?php else: ?>
    :root {
        --btn-color-one: var(--color_one);
        --btn-color-two: #fff;
    }
    <?php endif;?>
    <?php if($button_styles == 'style-1'): ?>
    /*
    .btn{
        display: inline-block;
        font-weight: 400;
        color: var(--btn-color-two);
        text-align: center;
        vertical-align: middle;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: var(--btn-color-one);
        border: 1px solid var(--btn-color-one);
        padding: 0.375rem 0.75rem;
        line-height: 1.5;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .btn:hover{
        background: var(--btn-color-two);
        color: var(--btn-color-one);
        border: 1px solid var(--btn-color-one);
        text-decoration: none;
    }
    .btn-inverse{
        color: var(--btn-color-one);
        background-color: var(--btn-color-two);
        border: 1px solid var(--btn-color-one);
    }
    .btn-inverse:hover{
        background: var(--btn-color-one);
        color: var(--btn-color-two);
        border: 1px solid var(--btn-color-one);
    }
    .btn:focus, .btn.focus {
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }*/
    <?php endif;?>
</style>


