<?php
    wp_enqueue_script('bscollapsejs', get_template_directory_uri().'/layouts/bootstrap/js/collapse.js', array(), '1.0.0', true);
    wp_enqueue_style('bscardcss',get_template_directory_uri().'/layouts/bootstrap/css/card.css', array(),'1.0.0','all', true);
?>

<?php $uid = uniqid('tab_', false); 
    $accordion = 1;
$numberOrder = 0;
    $collapse = 1;
?>
<div class="accordion_design_one" id="<?php echo $uid;?>">

    <?php if( have_rows('faq') ): $accordion++; ?>
    <div id="accordion<?php echo $accordion; ?>">
        <?php while ( have_rows('faq') ) : the_row(); $collapse++; $numberOrder++  ?>

        <div class="card panel">
            
            <div class="panel-heading" id="heading<?php echo $collapse."_".$uid; ?>">
                <h5 class="panel-title">
                    <a class="btn btn-link <?php if($collapse != 0 ){echo 'collapsed';} ?>" data-toggle="collapse" data-target="#collapse<?php echo $collapse."_".$uid;; ?>" aria-expanded="true" aria-controls="collapse<?php echo $collapse."_".$uid;; ?>">
                        <span class="title-text"><?php the_sub_field("question"); ?></span>
                        <div class="icon-box">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </a>
                </h5>
            </div>

            <div id="collapse<?php echo $collapse."_".$uid;; ?>" class="collapse" aria-labelledby="heading<?php echo $collapse."_".$uid;; ?>" data-parent="#accordion<?php echo $accordion; ?>">
                <div class="panel-body">
                    <div class="accordion-content"><?php the_sub_field("answer"); ?></div>
                </div>
            </div>
        </div>

        <?php endwhile; ?>
    </div>
    <?php endif; ?>
</div>

<style>
    .fade {
        transition: opacity 0.15s linear;
    }

    @media (prefers-reduced-motion: reduce) {
        .fade {
            transition: none;
        }
    }

    .fade:not(.show) {
        opacity: 0;
    }

    .collapse:not(.show) {
        display: none;
    }

    .collapsing {
        position: relative;
        height: 0;
        overflow: hidden;
        transition: height 0.35s ease;
    }

    @media (prefers-reduced-motion: reduce) {
        .collapsing {
            transition: none;
        }
    }

    .accordion_design_one .panel {
        border: none;
        box-shadow: none;
        border-radius: 0;
        margin: 0 0 15px 0px;
        text-align: left;
    }

    .accordion_design_one .panel-heading {
        padding: 0;
        border-radius: 30px
    }

    .accordion_design_one .panel-title a .title-text {
        display: block;
        width: 98%;
        font-weight: normal
    }

    .accordion_design_one .panel-title a .icon-box {
        position: absolute;
        content: '';
        right: 20px;
        top: 20px;
        top: 50%;
        transform: translateY(-50%)  rotate(0deg);
        z-index: 99;
        font-size: 26px;
         background-color: #c2b3b3;

        border-radius: 4px;
        height: 45px;
        width: 45px;
        padding: 0 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .accordion_design_one .panel-title a .icon-box i {
        color: #fff
    }

    .accordion_design_one .panel-title a.collapsed .icon-box {
        transform: rotate(90deg);
         transform: translateY(-50%)  rotate(90deg);

        background-color: #262d43;


    }

    .accordion_design_one .panel-heading h5 {
        margin-bottom: 0px;
    }

    .accordion_design_one .panel-title a {
        position: relative;
        z-index: 5;
        text-align: left;
        text-transform: capitalize;
        display: block;
        padding: 25px 30px;
        background: var(--color_three);
        background: linear-gradient(90deg, rgba(148,156,175,1) 0%, rgba(25,32,48,1) 100%);
        font-size: 22px;
        color: #fff;
        border: 1px solid rgba(112, 112, 112, 0.11);
        border-radius: 0px;
        position: relative;
        transition: all .3s ease 0s;
        max-width: 100%;
        cursor: pointer;
        height: auto;
        line-height: inherit;
    }

    .accordion_design_one .panel-title a:hover {
        text-decoration: none;
    }

    .accordion_design_one .panel-title a.collapsed {
        background: var(--color_two) !important;
        background: transparent;
        color: #fff !important;
    }
    .accordion_design_one .panel-body {
        padding: 20px 25px 10px 9px;
        background: 0 0;
        background: #fff;
        font-size: 16px;
        color: var(--body-color);
        line-height: 25px;
        border-top: none;
        top: 10px;
        position: relative;
        box-shadow: 0 0 37px -4px rgba(0, 0, 0, .17);
        border-radius: 15px;
        margin-bottom: 10px;
    }
    .accordion_design_one .panel-body .accordion-content {
        padding-bottom: 20px;
        padding-left: 15px;
    }

    .accordion_design_one .panel-body .accordion-content h2 {
        margin-bottom: 15px;
        margin-top: 30px;
    }

    .accordion_design_one .panel a span {
        color: #000
    }

    .accordion_design_one .panel a i {
        color: #000
    }

    .acc-number {
        font-size: 60px;
        position: absolute;
        color: #ebe7e3;
        left: 15px;
        font-weight: 900;
        height: 78px;
        line-height: 78px;
        top: 0;
        z-index: 6;
    }

    @media screen and (max-width: 834px) {
        .accordion_design_one .panel-title a {
            padding: 20px 15px 20px 15px;
            height: auto;
            line-height: inherit;
        }

        .acc-number {
            font-size: 45px;
        }

        .accordion_design_one .panel-body .accordion-content {
            padding-left: 15px;
        }

        .accordion_design_one .panel-title a .title-text {
            width: 90%;
        }
    }


    @media screen and (max-width: 768px) {
        .accordion_design_one .panel-title a .title-text {
            width: 80%;
        }

        .acc-number {
            font-size: 40px;
        }

        .accordion_design_one .panel-title a {
            font-size: 20px;
        }
    }

    @media screen and (max-width: 576px) {
         .acc-number {
            font-size: 30px;
        }
        .accordion_design_one .panel-title a .icon-box{
            width: 35px;
            height: 35px;
            font-size: 20px;
        }
        .accordion_design_one .panel-title a .title-text{
            padding-left: 45px;
        }
        
        .accordion_design_one .panel-title a {
            font-size: 16px;
        }
    }

</style>
