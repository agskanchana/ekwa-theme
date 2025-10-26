<?php
 $block_id = $block['id'];
 if( !empty($block['anchor']) ) {
    $block_id = $block['anchor'];
}
$className = 'contact-form';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}




?>
<script>
    var contactBlock = true;
    var siteKey = '<?php echo get_field('site_key'); ?>';
    var contactScriptsDir = '<?php echo basename(dirname(__FILE__)); ?>';


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
        insertScriptContact(TEMPDIR + '/template-parts/default-blocks/' + contactScriptsDir + '/contact-form.js');
        window.onscroll = null;
    }

    var howMany = 1
    document.onmousemove = (function() {

        if (howMany == 1) {
            insertScriptContact(TEMPDIR + '/template-parts/default-blocks/' + contactScriptsDir + '/contact-form.js');
            console.log('mousemoved');
        }
        howMany++;

    });*/

</script>
<div id="<?php echo $block_id;?>" class="<?php echo $className;?>">
            <form class="biw-contact-form" id="<?php echo get_field('form_id');?>" name="<?php echo get_field('form-id');?>" onsubmit="return validateBIWcontact(this);" method="post" action="https://www.ekwa.com/ekwa-wufoo-handler/en.php">


                    <div class="input-wrapper">
                        <div class="input name">
                            <label class="hide" for="<?php echo get_field('name_field_id');?>">Name *</label>
                            <input class="input-field form-name" id="<?php echo get_field('name_field_id');?>" name="<?php echo get_field('name_field_id');?>" onblur="replaceText(this)" onfocus="clearText(this)" type="text" placeholder="John Doe">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="input-wrapper">
                        <div class="input mail">
                            <label class="hide" for="<?php echo get_field('email_field_id');?>">Email *</label>
                            <input class="input-field form-email" id="<?php echo get_field('email_field_id');?>" name="<?php echo get_field('email_field_id');?>" onblur="replaceText(this)" onfocus="clearText(this)" type="text" placeholder="youremail@gmail.com">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                    </div>

                    <div class="input-wrapper">
                        <div class="input phone">
                            <label class="hide" for="<?php echo get_field('phone_field_id');?>">Phone *</label>
                            <input class="input-field form-phone" placeholder="971-123-1234" data-mask="000-000-0000" id="<?php echo get_field('phone_field_id');?>" name="<?php echo get_field('phone_field_id');?>" onblur="replaceText(this)" onfocus="clearText(this)" type="text">
                            <i class="fas fa-phone"></i>
                        </div>
                    </div>

                    <div class="input-wrapper">
                        <div class="input textarea">
                            <label class="hide" for="<?php echo get_field('comment_field_id');?>">Comments *</label>
                            <textarea class="input-field form-comment" id="<?php echo get_field('comment_field_id');?>" name="<?php echo get_field('comment_field_id');?>" onblur="replaceText(this)" onfocus="clearText(this)" placeholder="Write your message..."></textarea>
                            <i class="fas fa-comments"> </i>
                        </div>
                    </div>

                    <div class="input-wrapper">
                        <div class="checkBox">
                            <label class="hide privacy-policy-label" for="<?php echo get_field('privacy_policy_field_id');?>">Privacy Policy</label>
                            <input class="form-privacy" id="<?php echo get_field('privacy_policy_field_id');?>" name="<?php echo get_field('privacy_policy_field_id');?>" type="checkbox" value="I Agree" />
                            <em><small>By submitting the above form you agree and accept our <a target="_blank" href="<?php echo get_option( 'siteurl' );?>/privacy-policy/">Privacy Policy</a>.*</small></em>
                        </div>
                    </div>

                    <div id="contact-form-captcha" class="g-recaptcha"></div>
                    <button class="contact-submit-btn"><span class="button-helper"></span>Submit</button>
                    <?php
                    $key = "ozVu8SPWo2";
                    $cipherMethod = "AES-256-CBC";
                    $ivLength = openssl_cipher_iv_length($cipherMethod);
                    $url = encryptString(get_field('form_action_link'), $key, $cipherMethod);
                    ?>
                    <input type="hidden" name="url" value="<?php echo $url;?>">
                    <input type="hidden" id="idstamp" name="idstamp" value="<?php echo get_field('form_idstamp');?>" />
            </form>
        </div>
<style>

    <?php
    if(get_field('custom_css')):
        echo get_field('custom_css');
    endif;
?>
</style>