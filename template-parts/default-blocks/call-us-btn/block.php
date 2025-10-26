<?php
$text = "Call Us Today";
if(get_field('text')){
    $text = get_field('text');
}
$className = 'call-us-drop-down';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
$text_color = '#000';
if(get_field('text_color')){
    $text_color = get_field('text_color');
}
$icon_color  = '#000';
if(get_field('icon_color')){
    $icon_color = get_field('icon_color');
}
$drop_down_background  = '#000';
if(get_field('drop_down_background')){
    $drop_down_background = get_field('drop_down_background');
}
$drop_down_color = '#fff';
if(get_field('drop_down_color')){
    $drop_down_color = get_field('drop_down_color');
}
?>
<style>
    .call-us-drop-down{
        cursor: pointer;
        display: inline-block;
        position: relative;
    }
    .call-us-drop-down{
        max-width: 250px;
    }
    .call-us-drop-down span{
        display: flex;
        align-items: center;
        color: <?php echo $text_color;?>;
    }
    .call-us-drop-down span i{
        margin-right: 5px;
        color: <?php echo $icon_color;?>;
    }
    .drop-dwn{
        position: absolute;
        top: 100%;
        right: 0;
        background-color: <?php echo $drop_down_background;?>;
        width: 300px;
        text-align: left;
        padding: 2rem 1rem;
        display: none;
        z-index: 150;
    }
    .call-us-drop-down:hover .drop-dwn{
        display: block;
    }
    .drop-dwn p a{
        display: flex;
        align-items: center;

    }
    .drop-dwn p a span{
        color: <?php echo $drop_down_color;?>;
    }
    .drop-dwn p a:hover{
        text-decoration: none !important;
    }
    .drop-dwn p a i{
        margin-right: 10px;
        color: <?php echo $drop_down_color;?>;
    }
</style>
<div class="<?php echo $className;?>">

    <span><i class="fas fa-phone-alt"></i> <?php echo $text;?>
    <?php if(isset($_COOKIE['adward_number']) || isset($_GET['ads'])):?>
        <?php echo  get_theme_mod('adsense_number');?>
    <?php endif; ?>
    </span>
    <?php if(isset($_COOKIE['adward_number']) || isset($_GET['ads'])):?>

    <?php else: ?>

    <div class="drop-dwn">

        <?php if(get_theme_mod('call_tracking_number')):?>
        <p>
        <a aria-label="phone" href="tel:<?php echo mobile_number(get_theme_mod('call_tracking_number'));?>">
            <i class="fas fa-phone-alt"> </i>
            <span> New Patients: <?php echo get_theme_mod('call_tracking_number');?> </span>
        </a>
        </p>
        <?php endif;?>
        <?php if(get_theme_mod('existing_patients_phone')):?>
        <p><a aria-label="phone" href="tel:<?php echo mobile_number(get_theme_mod('existing_patients_phone'));?>">
            <i class="fas fa-phone-alt"></i>
            <span> Existing Patients: <?php echo get_theme_mod('existing_patients_phone');?> </span></a>
        </p>
    <?php endif;?>

    </div>
    <?php endif;?>
</div>

