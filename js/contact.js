/*============== Contact  Form Validation START =================*/
function validateBIWcontact(theForm) {
    var reason = "";
    reason += validateNameBiw(theForm.Field6);
    reason += validateEmailBiw(theForm.Field7);
    reason += validateTelBiw(theForm.Field113);
    reason += validateMessageBiw(theForm.Field10);
    reason += validateConfirm(theForm.Field12);
    reason += validateCaptcha(contactFormCaptcha);

    if (reason != "") {
        alert(reason);
        return false;
    }
    if(checkValue(theForm)) {
        insitePost(theForm);
    }
    setTimeout(function(){theForm.submit();},500); // increase this value if it's not tracking properly
    return true;
}

function validateConfirm(fld) {
                  var error = "";
                  if (fld.checked == "") {
                    fld.style.background = "";
                    error = "- Please accept our privacy policy\n"
                  }
                  return error;
                } 

function validateNameBiw(fld) {
    var error = "";

    if (fld.value == "") {
        fld.style.background = "";
        error = "- Please enter your name\n"
    } else if (fld.value == "Your Name *") {
        fld.style.background = "";
        error = "- Please enter your name\n"
    } else {
        fld.style.background = "";
    }
    return error;
}

function trim(s)
{
    return s.replace(/^\s+|\s+$/, '');
}




 function validateEmailBiw(fld) {
                var error = "";
                var tfld = trim(fld.value); // value of field with whitespace trimmed off
                var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/;

                if (fld.value == "Email Address *" || fld.value == "") {
                    error = "- Please enter your email address\n";
                } else if (!emailFilter.test(tfld)) { //test email for illegal characters
                    error = "- Please enter a valid email address\n";
		    
                }
//<?php $spaming_email =  get_field('spaming_email', 'option');
//  if(!empty($spaming_email)):
//?>
//		else if (fld.value.includes("<?php echo $spaming_email;?>")) {
//                    error = "- You have been blocked by the system due to spamming.\n"
//                }
//<?php endif;?>
		
		else {
                    fld.style.background = '';
                }
                return error;
            }










function isNumeric(v) {
    return v.length > 0 && !isNaN(v) && v.search(/[A-Z]|[#]/ig) == -1;
};
function isPhoneNumber(v) {
    return (/^(\([0-9]{3}\) |[0-9]{3}-)[0-9]{3}-[0-9]{4}$/.test(v) || /^\d{10}$/.test(v));
};

function validateTelBiw(fld) {
    var error = "";
    var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, '');
	
    if (fld.value == "") {
        error = "- Please enter your contact number   \n";
        fld.style.color ="";
    }
    // else if(fld.value.length != 10){
    //     error = "- Enter valid telephone number \n";
    // }
    else if(fld.value == "Your Contact Number *"){
        error = "- Please enter your contact number   \n";
    }
    else {
        if (isPhoneNumber(fld.value.trim()) == false) {
        error = "- Enter a valid contact number in correct format \n  Example: (xxx) xxx-xxxx | xxx-xxx-xxxx | xxxxxxxxxx        \n";
            // error = "- Enter only numeric values for your telephone number \n";
        }
        else{
            fld.style.color ="";
        }
    }
    return error;
}

function validateMessageBiw(fld) {
    var error = "";

    if (fld.value == "") {
        fld.style.background = "";
        error = "- Please enter your comments \n"
    } else if (fld.value == "Comments *"){
        fld.style.background = "";
        error = "- Please enter your comments \n"
    } else {
        fld.style.background = "";
    }
    return error;
}


function validateCaptcha(fld) {
    var error = "";
    if (grecaptcha.getResponse(fld) == "") {
        error = "- Please confirm you are not a robot\n"
    }
    return error;
}
showBackEndSuccess('rel');

function showBackEndSuccess(uriSer) {
    if (getUrlParameter(uriSer) && /thank-you/.test(getUrlParameter(uriSer))) {
        setTimeout(function () {
            alert(
                'Successfully submitted. We ensure that we will get back to you as soon as possible during working hours.');
        }, 2000);
    }
}
showBackEndError('form-error', 'error-elm');

function showBackEndError(uriSer, uriElm) {
    if (getUrlParameter(uriSer)) {
        var elemStr = getUrlParameter(uriElm);
        var tempElem = null;
        if (elemStr != "") {
            tempElem = document.querySelector('#' + getUrlParameter(uriElm));
        }
        if (tempElem) {
            tempElem.style.borderColor = 'red';
            tempElem.style.borderWidth = '1px';
            tempElem.style.borderStyle = 'solid';
            tempElem.focus();
        }
        setTimeout(function () {
            alert(getUrlParameter(uriSer));
        }, 2000);
        if (getUrlParameter('form-data')) {
            var formDataObj = JSON.parse(atob(getUrlParameter('form-data')))
            var formDataKeyArr = Object.keys(formDataObj);
            for (var i = 0; i < formDataKeyArr.length; i++) {
                if (document.getElementById(formDataKeyArr[i])) {
                    document.getElementById(formDataKeyArr[i]).value = formDataObj[formDataKeyArr[i]];
                }

            }
        }
    }
}

function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};

var gCapLink = document.createElement('script');
gCapLink.async = false;
gCapLink.src = 'https://www.google.com/recaptcha/api.js?onload=renderRecaptcha&render=explicit';
document.getElementsByTagName('body')[0].insertAdjacentElement('beforeend', gCapLink);

var contactFormCaptcha;
var aptFormCaptcha;
var renderRecaptcha = function () {
    if (document.getElementById('contact-form-captcha')) {
        contactFormCaptcha = grecaptcha.render('contact-form-captcha', {
            "sitekey": "6LcR16sUAAAAAL0Ku9uQgXABkDDMmuol4MF8oZGS",
            "theme": "light"
        });
    }
    if (document.getElementById('apt-form-captcha')) {
        aptFormCaptcha = grecaptcha.render('apt-form-captcha', {
            "sitekey": "6LcR16sUAAAAAL0Ku9uQgXABkDDMmuol4MF8oZGS",
            "theme": "light"
        });
    }
};


 /*============== Appointment Request Form Validation END =================*/	