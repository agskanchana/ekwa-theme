   
 
 function AppointmentFormValidate(theForm) {
    
   //console.log(theForm);
   
    var reason = "";
    
    var Datefield = document.querySelector(".form-app-date").value;
    var Newpatient = document.querySelector(".form-new-patient").value;
    var NameField = document.querySelector(".form-name").value;
    var Emailfield = document.querySelector(".form-email").value;
    var Telfield = document.querySelector(".form-phone").value;
    var CommentField = document.querySelector(".form-comment").value;
    var PrivacyField = document.querySelector(".form-privacy");
    
    
    reason += validateDate(Datefield);
	reason += validateNewPatient(Newpatient);
    reason += validateName(NameField);
    reason += validateEmail(Emailfield);
    reason += validateTel(Telfield);
    reason += validateMessage(CommentField);
    reason += validateConfirm(PrivacyField);
	reason += validateCaptcha(contactFormCaptcha);
  //  reason += validateQuestion(theForm.question);

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
   //console.log(fld);
                  var error = "";
                  
                  if (!fld.checked) {
                    fld.style.background = "";
                    error = "- Please accept our privacy policy\n"
                  }
                  return error;
                } 

function validateDate(fld) {
    var error = "";

    if (fld == "") {
        //fld.style.background = "";
        error = "- Please select appointment date\n"
    } else if (fld == "Appointment Date *") {
        //fld.style.background = "";
        error = "- Please select appointment date\n"
    } else {
        //fld.style.background = "";
    }
    return error;
}

function validateTime(fld) {
    var error = "";

    if (fld == "") {
        //fld.style.background = "";
        error = "- Enter a date\n"
    } else if (fld == "Time") {
        //fld.style.background = "";
        error = "- Select a Time\n"
    } else {
        //fld.style.background = "";
    }
    return error;
}

function validateName(fld) {
    var error = "";

    if (fld == "") {
        //fld.style.background = "";
        error = "- Please enter your name\n"
    } else if (fld == "Your Name *") {
        //fld.style.background = "";
        error = "- Please enter your name\n"
    } else {
        //fld.style.background = "";
    }
    return error;
}



function validateNewPatient(fld) {
    var error = "";

    if (fld == "") {
        //fld.style.background = "";
        error = "- Select if you are a new patient or not\n"
    } else if (fld == "Are you a new patient? *") {
        //fld.style.background = "";
        error = "- Select if you are a new patient or not\n"
    } else {
        //fld.style.background = "";
    }
    return error;
}






function trim(s)
{
    return s.replace(/^\s+|\s+$/, '');
}

function validateEmail(fld) {
    var error="";
    
    var tfld = trim(fld);                        // value of field with whitespace trimmed off
    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;

    if (fld == "") {
        //fld.style.background = "";
        error = "- Please enter your email address\n";
    } else if (!emailFilter.test(tfld)) {              //test email address for illegal characters
        //fld.style.background = "";
        error = "- Enter a valid email address\n";
    } else if (fld == "Email Address *") {              //test email address for illegal characters
        //fld.style.background = "";
        error = "- Enter a valid email address\n";
    } else {
        //fld.style.background = "";
    }
    return error;
}

function isNumeric(v) {
    return v.length > 0 && !isNaN(v) && v.search(/[A-Z]|[#]/ig) == -1;
};

function validateTel(fld) {
    var error = "";
  
    var stripped = fld.replace(/[\(\)\.\-\ ]/g, '');
	
    if (fld.value == "") {
        error = "- Please enter your contact number \n";
        //fld.style.color ="";
    }
    else if(stripped.length != 10){
		error = "- Enter a valid contact number  \n";
    }
    else if(fld == "Your Contact Number *"){
		error = "- Enter a valid contact number  \n";
    }
    else {
        if (isNumeric(stripped) == false) {
            error = "- Enter only numeric values for your telephone number \n";
        }
        else{
            //fld.style.color ="";
        }
    }
    return error;
}

function validateMessage(fld) {
    var error = "";

    if (fld == "") {
        //fld.style.background = "";
        error = "- Please enter your comments\n"
    } else if (fld == "Comments *"){
        //fld.style.background = "";
        error = "- Please enter your comments\n"
    } else {
        //fld.style.background = "";
    }
    return error;
}

function validateQuestion(fld){
    var error = "";

    if (fld == "") {
        //fld.style.background = "";
        error = "- Answer the simple question\n";
    } else {
        //fld.style.background = "";
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
var Sitekey = siteKey;
var renderRecaptcha = function () {
    if (document.getElementById('contact-form-captcha')) {
        contactFormCaptcha = grecaptcha.render('contact-form-captcha', {
            "sitekey": Sitekey,
            "theme": "light"
        });
    }
    if (document.getElementById('apt-form-captcha')) {
        aptFormCaptcha = grecaptcha.render('apt-form-captcha', {
            "sitekey": Sitekey,
            "theme": "light"
        });
    }
};
