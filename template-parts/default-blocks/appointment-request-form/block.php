<?php
$AppointmentForm = get_field('appointment_form');


?>

<script>
    var siteKey = '<?php echo $AppointmentForm['site_key']; ?>';
    var appForm = true;
    var AppScriptsDir = '<?php echo basename(dirname(__FILE__)); ?>';


    function insertScriptContact(url) {

        function isScriptLoaded2(url) {
            var scripts = document.getElementsByTagName('script');
            for (var i = scripts.length; i--;) {
                if (scripts[i].src == url) return true;
            }
            return false;
        }

        if (!isScriptLoaded2(url)) {
            var head = document.getElementsByTagName('head')[0];
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = url;
            head.appendChild(script);
        }
    }

/*
    window.onscroll = function(e) {
        console.log('test');
        //code here
        insertScriptContact(TEMPDIR + '/template-parts/default-blocks/' + AppScriptsDir + '/validation.js');
        window.onscroll = null;
    }

    var howMany = 1
    document.onmousemove = (function() {

        if (howMany == 1) {
            insertScriptContact(TEMPDIR + '/template-parts/default-blocks/' + AppScriptsDir + '/validation.js');
            console.log('mousemoved');
        }
        howMany++;

    });*/

</script>



<div class="appointment-wrapper">
    <div class="appointment-form">
        <div class="form-wrapper">


            <form class="form-horizontal" id="<?php echo $AppointmentForm['form_id']; ?>" name="<?php echo $AppointmentForm['form_id']; ?>" onsubmit="return AppointmentFormValidate(this);" method="post" action="https://www.ekwa.com/ekwa-wufoo-handler/en.php">

                <div class="calendar-icon">
                    <i class="fas fa-calendar-plus"></i>
                    <h2>Appointment Form</h2>
                </div>

                <div class="warning">This is a request to help us schedule you efficiently, you will be called to confirm your appointment. Your appointment is not scheduled until you have heard back from our office.</div>
                <style>
			.warning { background:#FF0000; padding: 20px; color: #fff; text-align:center; border-radius: 10px;}
			</style>
                <div class="form-group">
                    <label for="<?php echo $AppointmentForm['date_field_id']; ?>">Appointment Date *</label>
                    <input placeholder="Appointment Date *" name="<?php echo $AppointmentForm['date_field_id']; ?>" type="text" class="form-control form-app-date" id="<?php echo $AppointmentForm['date_field_id']; ?>">
                    <i class="fas fa-calendar-week"></i>
                </div>

                <div class="form-group">
                    <label for="<?php echo $AppointmentForm['time_field_id']; ?>">Time * </label>
                    <select class="form-control" id="<?php echo $AppointmentForm['time_field_id']; ?>" name="<?php echo $AppointmentForm['time_field_id']; ?>">
                        <option value="Time" selected="selected">
                            Time
                        </option>
                        <option value="Morning">
                            Morning
                        </option>
                        <option value="Lunch">
                            Lunch
                        </option>
                        <option value="Evening">
                            Evening
                        </option>
                    </select>
                    <i class="fas fa-clock"></i>

                </div>



                <div class="">
                    <div class="">

                        <div class="form-group">
                            <label for="<?php echo $AppointmentForm['are_you_a_new_patient_field_id']; ?>">Are You A New Patient? * </label>
                            <select class="form-control form-new-patient" id="<?php echo $AppointmentForm['are_you_a_new_patient_field_id']; ?>" name="<?php echo $AppointmentForm['are_you_a_new_patient_field_id']; ?>">
                                <option value="Are you a new patient? *" selected="selected">
                                    Are You A New Patient? *
                                </option>
                                <option value="Yes">
                                    Yes
                                </option>
                                <option value="No">
                                    No
                                </option>
                            </select>
                            <i class="fa fa-medkit" aria-hidden="true"></i>

                        </div>
                    </div>
                    <div class="">

                        <div class="form-group">
                            <label for="<?php echo $AppointmentForm['name_field_id']; ?>">Your Name * </label>
                            <input name="<?php echo $AppointmentForm['name_field_id']; ?>" type="text" class="form-control form-name" id="<?php echo $AppointmentForm['name_field_id']; ?>" placeholder="Your Name * ">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </div>



                    </div>

                </div>



                <div class="">

                    <div class="">
                        <div class="form-group">
                            <label for="<?php echo $AppointmentForm['email_field_id']; ?>">Email Address * </label>
                            <input name="<?php echo $AppointmentForm['email_field_id']; ?>" type="text" class="form-control form-email" id="<?php echo $AppointmentForm['email_field_id']; ?>" placeholder="Email Address *">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group">
                            <label for="<?php echo $AppointmentForm['phone_field_id']; ?> ">Contact Number * </label>
                            <input data-mask="000-000-0000" name="<?php echo $AppointmentForm['phone_field_id']; ?>" type="text" class="form-control form-phone" id="<?php echo $AppointmentForm['phone_field_id']; ?>" placeholder="Contact Number *">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                        </div>
                    </div>


                </div>




                <div class="form-group">
                    <label for="<?php echo $AppointmentForm['comment_field_id']; ?>">Comments * </label>
                    <textarea class="form-control form-comment" name="<?php echo $AppointmentForm['comment_field_id']; ?>" id="<?php echo $AppointmentForm['comment_field_id']; ?>" placeholder="Comments *"></textarea>
                    <i class="fas fa-comments"></i>
                </div>

                <div class="form-group form-group-policy">
                    <label class="hide" for="<?php echo $AppointmentForm [ 'privacy_policy_field' ]; ?>">Privacy Policy</label>
                    <input id="<?php echo $AppointmentForm [ 'privacy_policy_field' ]; ?>" name="<?php echo $AppointmentForm [ 'privacy_policy_field' ]; ?>" type="checkbox" value="I Agree" class="form-privacy" />
                    <p class="policy-text">By submitting the above form you agree and accept our <a target="_blank" rel="noreferrer" href="<?php echo get_option( 'siteurl' );?>/privacy-policy/">Privacy Policy</a>.*</p>
                </div>


                <div id="contact-form-captcha"></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-secondary">Submit</button>
                    <?php
                    $key = "ozVu8SPWo2";
                    $cipherMethod = "AES-256-CBC";
                    $ivLength = openssl_cipher_iv_length($cipherMethod);
                    $url = encryptString($AppointmentForm['form_link'], $key, $cipherMethod);
                    ?>
                    <input type="hidden" name="url" value="<?php echo $url; ?>">
                    <input type="hidden" id="idstamp" name="idstamp" value="<?php echo $AppointmentForm['id_stamp']; ?>" />
                </div>
            </form>
        </div>
    </div>



    <div class="appointment-work-hours">

        <div class="appointment-phone">
            <h2>Call Us</h2>

            <div class="phone-info-phone">
                <span class="number">
                <?php if(isset($_COOKIE['adward_number']) || isset($_GET['ads'])): ?>
                    <?php echo do_shortcode( '[phone]' );?>
                <?php else:?>
                     <a href="tel:<?php echo mobile_number(get_theme_mod('call_tracking_number'));?>">
                       New Patients: 
                        <?php echo get_theme_mod('call_tracking_number');?>
                    </a>
                <?php endif;?>
                </span>
                <?php if(isset($_COOKIE['adward_number']) || isset($_GET['ads'])): ?>

                <?php else:?>
                    <span class="number">
                    <a href="tel:<?php echo  mobile_number(get_location('phone_ex'));?>" aria-label="phone"> Existing Patients: <?php echo get_location('phone_ex');?> </a>
                </span>
                <?php endif;?>
            </div>


        </div>


        <div class="work-hours-wrapper">
            <div class="icon-holder">
                <svg width="77.684" height="80.103" viewBox="0 0 20.554 21.194" xmlns="http://www.w3.org/2000/svg">
                    <path d="M.905 6.267a.264.264 0 00.41-.045.267.267 0 00.046-.037l3.944-3.944a.264.264 0 000-.374 3.115 3.115 0 00-4.4 0 3.115 3.115 0 000 4.4zm2.2-4.781c.578 0 1.157.192 1.63.577L1.101 5.696a2.587 2.587 0 01.177-3.456 2.574 2.574 0 011.826-.754zM20.55 4.067c0-.831-.324-1.613-.912-2.2s-1.369-.912-2.2-.912a3.09 3.09 0 00-2.2.912.264.264 0 000 .374l3.945 3.944a.259.259 0 00.045.036.268.268 0 00.223.123.264.264 0 00.187-.077c.588-.588.911-1.37.911-2.2zM19.44 5.696L15.81 2.063a2.561 2.561 0 011.629-.578c.69 0 1.338.268 1.826.756.487.488.756 1.136.756 1.826 0 .6-.204 1.17-.579 1.629zM2.33 11.442c0 4.38 3.562 7.942 7.941 7.942s7.943-3.563 7.943-7.942S14.65 3.5 10.27 3.5 2.33 7.062 2.33 11.442zm15.347-.31h-1.05a.265.265 0 100 .53h1.052a7.42 7.42 0 01-7.143 7.186v-1.05a.265.265 0 10-.53 0v1.05a7.42 7.42 0 01-7.142-7.187h1.088a.265.265 0 100-.53H2.866a7.42 7.42 0 017.14-7.096v1.05a.265.265 0 10.53 0v-1.05a7.42 7.42 0 017.14 7.097z" />
                    <path d="M1.114 11.442a9.16 9.16 0 004.472 7.864L3.84 20.712a.264.264 0 10.332.412l1.914-1.542A9.098 9.098 0 0010.27 20.6c1.51 0 2.934-.37 4.191-1.02l1.939 1.562a.263.263 0 00.372-.04.264.264 0 00-.04-.372l-1.771-1.426a9.16 9.16 0 004.466-7.861c0-4.96-3.965-9.01-8.892-9.15v-.47a.927.927 0 00-.265-1.816.927.927 0 00-.265 1.815v.47c-4.926.142-8.892 4.19-8.892 9.151zm17.785 0c0 4.757-3.87 8.628-8.628 8.628-4.757 0-8.627-3.87-8.627-8.628s3.87-8.628 8.627-8.628c4.758 0 8.628 3.87 8.628 8.628zM9.871.935a.4.4 0 11.801 0 .4.4 0 01-.8 0z" />
                    <path d="M10.551 8.063a.265.265 0 10-.529 0v3.379c0 .146.118.265.265.265h3.379a.265.265 0 100-.53H10.55z" />
                </svg>
            </div>
            <div class="hours-table">
                <?php
                                    $working_hrs = get_theme_mod( 'working_hrs', null );
                                    if($working_hrs):
                              ?>



                <?php foreach( $working_hrs as $working_hr ) : ?>
                <div class="working-hrs-raw">
                    <div class="day"><?php echo $working_hr['day'];?>: </div>
                    <div class="time"><?php echo $working_hr['opening'];?>
                        <?php if(($working_hr['opening'])):?> -
                        <?php endif; ?>
                        <?php
                                    if($working_hr['closed']){
                                        echo 'Closed';
                                    }else{
                                        echo $working_hr['closing'];
                                    }

                                    ?>
                    </div>
                </div>
                <?php endforeach; ?>


                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<style>
    <?php $AppointmentColors=get_field('form_colors') ?>.appointment-wrapper {
        --color-1: <?php if($AppointmentColors['color_1']) {
            echo $AppointmentColors['color_1'];
        }

        else {
            echo '#fff';
        }

        ?>;

        --color-2: <?php if($AppointmentColors['color_2']) {
            echo $AppointmentColors['color_2'];
        }

        else {
            echo '#00719c';
        }

        ?>;

        --color-3: <?php if($AppointmentColors['color_3']) {
            echo $AppointmentColors['color_3'];
        }

        else {
            echo '#1a92bf';
        }

        ?>;

        --color-4: <?php if($AppointmentColors['color_4']) {
            echo $AppointmentColors['color_4'];
        }

        else {
            echo '#eff8ff';
        }

        ?>;

        --btn-color: <?php if(get_field('button_bg_color')) {
            echo get_field('button_bg_color');
        }

        else {
            echo '#eff8ff';
        }

        ?>;

        --btn-hover-color: <?php if(get_field('button_bg_hover_color')) {
            echo get_field('button_bg_hover_color');
        }

        else {
            echo '#eff8ff';
        }

        ?>;
    }

    .phone-info-phone{
         display: flex;
        flex-direction: column
    }
    .phone-info-phone span{
       padding: 5px 0;
        font-size: 18px;
    }


    .work-hours-wrapper .working-hrs-raw{
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 10px;
        color: #3A3A3A;
        justify-content: space-between;
        border-bottom: 1px solid #dbdbdb;
    }
    .work-hours-wrapper .working-hrs-raw{
       padding: 5px 0;
    }

    .form-horizontal .form-control {
        background-color: #e5e5e5b0 !important;
        border-radius: 4px !important;
    }

    .form-horizontal .form-group {
        margin-top: 25px !important
    }



    .form-group input,
    .form-group select,
    .form-group textarea {
        border-bottom: 4px solid rgba(0, 0, 0, 0) !important;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-bottom: 4px solid #2a9df4 !important;
    }

    .form-group input:focus+i,
    .form-group select:focus+i,
    .form-group textarea:focus+i {
        color: #2a9df4
    }

    .appointment-wrapper {
        display: flex;
        flex-wrap: wrap;
        box-shadow: 0 0 55px rgba(0, 0, 0, .05);
        border-radius: 10px;
        background-color: var(--color-3);
    }

    .appointment-form {
        width: 55%;
    }

    .appointment-work-hours {
        width: 45%;
        background-color: var(--color-2);
        padding: 20px 15px;
        border-radius: 10px;
    }

    .ekwa-body .appointment-work-hours {
        padding: 20px 70px;
    }

    .form-wrapper h2 {
        color: var(--color-1)
    }

    .appointment-work-hours h2,
    .appointment-work-hours a,
    .appointment-work-hours span {
        color: var(--color-3)
    }

    .calendar-icon {
        display: flex;
        align-items: center
    }

    .calendar-icon i {
        font-size: 36px;
        margin-right: 25px;
    }

    .calendar-icon {
        color: var(--color-1);
    }

    .appointment-form {
        /*background-color: var(--color-3);*/
    }

    .appointment-phone {}

    .appointment-phone h2:before {
        content: "\f879";
        font-size: 36px;
        font-family: "Font Awesome 5 Free";
        font-weight: bold;
        margin-right: 10px;
    }

    .form-group-policy {
        display: flex;
     }

    .form-group-policy p {
        margin-left: 15px;
    }

    .form-group-policy input[type="checkbox"] {
        width: 20px;
        height: 20px;
    }

    .form-bg {
        background: #ddd;
    }

    .form-horizontal {
        background: var(--color-1);
        padding: 0 50px;
    }

    .form-horizontal .form-group {
        margin: 0 0 10px 0;
        position: relative;
        color: var(--color-1);
    }

    .form-horizontal .form-group i {
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 18px;
        color: #3b3b3b;
        text-align: center;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1;
    }

    .form-horizontal .form-control {
        height: 50px;
        background: transparent;
        box-shadow: none;
        padding: 4px  20px 0 55px;
        font-size: 16px;
        color: #000;
        position: relative;
        transition: all 0.3s ease 0s;
        width: 100%;
        font-family: var(--font_body);
    }

    .form-horizontal textarea.form-control {
        padding-top: 10px;
        height: 80px;
    }

    .form-horizontal select.form-control {
        padding-left: 50px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .form-horizontal .form-control[type=password] {
        padding: 0 105px 0 50px;
    }

    .form-horizontal .form-control:focus {
        box-shadow: none;
        outline: 0 none;
        border-color: #1d9c9e;
    }

    .form-horizontal .form-group label {
        display: none;
    }

    .form-horizontal .signup {
        display: inline-block;
        font-size: 16px;
        color: #8f8f8f;
        text-transform: capitalize;
        margin-top: 8px;
    }

    .form-group .btn {
        max-width: 100%;
        border: none;
        background: var(--btn-color);
        text-align: center;
        text-transform: uppercase;
        display: inline-block;
        padding: 0 35px;
        font-size: 16px;
         color: #fff;
         cursor: pointer;
     }

    .form-group .btn:hover {
         background: var(--btn-hover-color)
    }

    .new-p {
        display: block;
        margin-bottom: 15px;
    }

    .form-horizontal .signup a {
        color: #1cbfd0;
    }

    .form-horizontal .form-control::-webkit-input-placeholder,
    .form-horizontal .form-control::-moz-placeholder,
    .form-horizontal .form-control::placeholder {
        color: #000;
        opacity: 1;
    }

    .form-horizontal .form-control::-webkit-input-placeholder {
        color: #000;
        opacity: 1;
    }

    .form-wrapper {
        position: relative;
        background: <?php echo get_field('background_color');
        ?>;
        background: transparent;
    }

    .form-wrapper .form-horizontal {
        padding: 35px;
        background: repeat;
    }

    .form-horizontal .form-control {
        border: none;
    }





    .work-hours-wrapper .icon-holder {
         text-align: center;
        height: 68px;
        width: 68px;
        position: absolute;
        top: 0;
        left: 50%;
        -webkit-transform: translateX(-50%) translateY(-50%);
        -moz-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        border-radius: 50%;
        background: var(--color-3);
    }

    .work-hours-wrapper .icon-holder>svg {
        height: 35px;
        width: 35px;
        fill: var(--color-1);
        margin-top: 15px;
    }

    .work-hours-wrapper {
        position: relative;
        padding: 40px 26px 43px;
        border-radius: 5px;
        margin-top: 80px;
        background: var(--color-3);
    }



    .work-hours-wrapper .appt-btn {
        width: 100%;
        text-align: center;
        padding: 9px 15px;
        border-radius: 50px;
    }

    .appointment-phone {
        margin-top: 40px;
        text-align: center
    }

    .work-hours-wrapper {
        margin-bottom: 40px;
    }

    @media screen and (max-width: 1024px) {
        .ekwa-body .appointment-work-hours{
            padding: 20px 35px;
        }
        .appointment-form{
            width: 60%;
        }
        .appointment-work-hours{
            width: 40%;
        }
    }


    @media only screen and (max-width:992px) {
          .appointment-form,
        .appointment-work-hours{
            width: 100%;
        }
    }
    @media only screen and (max-width:768px) {

        .appointment-phone span,
        .appointment-phone a {
            font-size: 18px;
        }
    }

    @media screen and (max-width: 767px) {

        .appointment-work-hours,
        .appointment-form {
            width: 100%;
        }
    }

    @media screen and (max-width: 512px) {
        #contact-form-captcha {
            transform: scale(0.77);
            -webkit-transform: scale(0.77);
            transform-origin: 0 0;
            -webkit-transform-origin: 0 0;
        }

        .form-wrapper .form-horizontal {
            padding: 25px;
        }



        .form-group-policy input[type="checkbox"] {
            width: 35px;
            height: 35px;
        }

        .ekwa-body .appointment-work-hours {
            padding: 20px 20px;
        }
    }

    @media only screen and (max-width: 479px) {
        .form-horizontal {
            padding: 40px 20px;
        }

        .form-horizontal .form-group:last-child {
            text-align: center;
            margin-top: 0;
        }

        .form-horizontal .signup {
            display: block;
            margin-bottom: 10px;
        }

        .form-horizontal .btn {
            float: none;
        }
    }

    @media screen and (max-width: 375px) {
        .form-wrapper .form-horizontal {
            padding: 20px;
        }

        .form-wrapper h2 {
            font-size: 20px;
        }

        .calendar-icon i {
            font-size: 28px;
            margin-right: 15px;
        }


    }

    #contact-form-captcha {
        margin-bottom: 20px;
    }

</style>
<?php
  wp_enqueue_script('datepickerjs', get_template_directory_uri().'/template-parts/default-blocks/'.basename(dirname(__FILE__)).'/plugins.js', array(), '1.0.0', true);
  wp_enqueue_style('datepickercss',get_template_directory_uri().'/template-parts/default-blocks/'.basename(dirname(__FILE__)).'/plugins.css', array(),'1.0.0','all', true);
?>
