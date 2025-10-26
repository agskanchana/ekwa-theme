
  function clearText(e){e.defaultValue==e.value&&(e.value="")}function replaceText(e){""==e.value&&(e.value=e.defaultValue)}
 function validateBIWcontact(theForm) {
    
   //console.log(theForm);
   
   
   
    var reason = "";
    

    var NameField = document.querySelector(".form-name").value;
    var Emailfield = document.querySelector(".form-email").value;
    var Telfield = document.querySelector(".form-phone").value;
    var CommentField = document.querySelector(".form-comment").value;
    var PrivacyField = document.querySelector(".form-privacy");
    
    
    

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
                  var error = "";
                  if (fld.checked == "") {
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






  
  // jQuery Mask Plugin v1.14.16
// github.com/igorescobar/jQuery-Mask-Plugin
var $jscomp=$jscomp||{};$jscomp.scope={};$jscomp.findInternal=function(a,n,f){a instanceof String&&(a=String(a));for(var p=a.length,k=0;k<p;k++){var b=a[k];if(n.call(f,b,k,a))return{i:k,v:b}}return{i:-1,v:void 0}};$jscomp.ASSUME_ES5=!1;$jscomp.ASSUME_NO_NATIVE_MAP=!1;$jscomp.ASSUME_NO_NATIVE_SET=!1;$jscomp.SIMPLE_FROUND_POLYFILL=!1;
$jscomp.defineProperty=$jscomp.ASSUME_ES5||"function"==typeof Object.defineProperties?Object.defineProperty:function(a,n,f){a!=Array.prototype&&a!=Object.prototype&&(a[n]=f.value)};$jscomp.getGlobal=function(a){return"undefined"!=typeof window&&window===a?a:"undefined"!=typeof global&&null!=global?global:a};$jscomp.global=$jscomp.getGlobal(this);
$jscomp.polyfill=function(a,n,f,p){if(n){f=$jscomp.global;a=a.split(".");for(p=0;p<a.length-1;p++){var k=a[p];k in f||(f[k]={});f=f[k]}a=a[a.length-1];p=f[a];n=n(p);n!=p&&null!=n&&$jscomp.defineProperty(f,a,{configurable:!0,writable:!0,value:n})}};$jscomp.polyfill("Array.prototype.find",function(a){return a?a:function(a,f){return $jscomp.findInternal(this,a,f).v}},"es6","es3");
(function(a,n,f){"function"===typeof define&&define.amd?define(["jquery"],a):"object"===typeof exports&&"undefined"===typeof Meteor?module.exports=a(require("jquery")):a(n||f)})(function(a){var n=function(b,d,e){var c={invalid:[],getCaret:function(){try{var a=0,r=b.get(0),h=document.selection,d=r.selectionStart;if(h&&-1===navigator.appVersion.indexOf("MSIE 10")){var e=h.createRange();e.moveStart("character",-c.val().length);a=e.text.length}else if(d||"0"===d)a=d;return a}catch(C){}},setCaret:function(a){try{if(b.is(":focus")){var c=
b.get(0);if(c.setSelectionRange)c.setSelectionRange(a,a);else{var g=c.createTextRange();g.collapse(!0);g.moveEnd("character",a);g.moveStart("character",a);g.select()}}}catch(B){}},events:function(){b.on("keydown.mask",function(a){b.data("mask-keycode",a.keyCode||a.which);b.data("mask-previus-value",b.val());b.data("mask-previus-caret-pos",c.getCaret());c.maskDigitPosMapOld=c.maskDigitPosMap}).on(a.jMaskGlobals.useInput?"input.mask":"keyup.mask",c.behaviour).on("paste.mask drop.mask",function(){setTimeout(function(){b.keydown().keyup()},
100)}).on("change.mask",function(){b.data("changed",!0)}).on("blur.mask",function(){f===c.val()||b.data("changed")||b.trigger("change");b.data("changed",!1)}).on("blur.mask",function(){f=c.val()}).on("focus.mask",function(b){!0===e.selectOnFocus&&a(b.target).select()}).on("focusout.mask",function(){e.clearIfNotMatch&&!k.test(c.val())&&c.val("")})},getRegexMask:function(){for(var a=[],b,c,e,t,f=0;f<d.length;f++)(b=l.translation[d.charAt(f)])?(c=b.pattern.toString().replace(/.{1}$|^.{1}/g,""),e=b.optional,
(b=b.recursive)?(a.push(d.charAt(f)),t={digit:d.charAt(f),pattern:c}):a.push(e||b?c+"?":c)):a.push(d.charAt(f).replace(/[-\/\\^$*+?.()|[\]{}]/g,"\\$&"));a=a.join("");t&&(a=a.replace(new RegExp("("+t.digit+"(.*"+t.digit+")?)"),"($1)?").replace(new RegExp(t.digit,"g"),t.pattern));return new RegExp(a)},destroyEvents:function(){b.off("input keydown keyup paste drop blur focusout ".split(" ").join(".mask "))},val:function(a){var c=b.is("input")?"val":"text";if(0<arguments.length){if(b[c]()!==a)b[c](a);
c=b}else c=b[c]();return c},calculateCaretPosition:function(a){var d=c.getMasked(),h=c.getCaret();if(a!==d){var e=b.data("mask-previus-caret-pos")||0;d=d.length;var g=a.length,f=a=0,l=0,k=0,m;for(m=h;m<d&&c.maskDigitPosMap[m];m++)f++;for(m=h-1;0<=m&&c.maskDigitPosMap[m];m--)a++;for(m=h-1;0<=m;m--)c.maskDigitPosMap[m]&&l++;for(m=e-1;0<=m;m--)c.maskDigitPosMapOld[m]&&k++;h>g?h=10*d:e>=h&&e!==g?c.maskDigitPosMapOld[h]||(e=h,h=h-(k-l)-a,c.maskDigitPosMap[h]&&(h=e)):h>e&&(h=h+(l-k)+f)}return h},behaviour:function(d){d=
d||window.event;c.invalid=[];var e=b.data("mask-keycode");if(-1===a.inArray(e,l.byPassKeys)){e=c.getMasked();var h=c.getCaret(),g=b.data("mask-previus-value")||"";setTimeout(function(){c.setCaret(c.calculateCaretPosition(g))},a.jMaskGlobals.keyStrokeCompensation);c.val(e);c.setCaret(h);return c.callbacks(d)}},getMasked:function(a,b){var h=[],f=void 0===b?c.val():b+"",g=0,k=d.length,n=0,p=f.length,m=1,r="push",u=-1,w=0;b=[];if(e.reverse){r="unshift";m=-1;var x=0;g=k-1;n=p-1;var A=function(){return-1<
g&&-1<n}}else x=k-1,A=function(){return g<k&&n<p};for(var z;A();){var y=d.charAt(g),v=f.charAt(n),q=l.translation[y];if(q)v.match(q.pattern)?(h[r](v),q.recursive&&(-1===u?u=g:g===x&&g!==u&&(g=u-m),x===u&&(g-=m)),g+=m):v===z?(w--,z=void 0):q.optional?(g+=m,n-=m):q.fallback?(h[r](q.fallback),g+=m,n-=m):c.invalid.push({p:n,v:v,e:q.pattern}),n+=m;else{if(!a)h[r](y);v===y?(b.push(n),n+=m):(z=y,b.push(n+w),w++);g+=m}}a=d.charAt(x);k!==p+1||l.translation[a]||h.push(a);h=h.join("");c.mapMaskdigitPositions(h,
b,p);return h},mapMaskdigitPositions:function(a,b,d){a=e.reverse?a.length-d:0;c.maskDigitPosMap={};for(d=0;d<b.length;d++)c.maskDigitPosMap[b[d]+a]=1},callbacks:function(a){var g=c.val(),h=g!==f,k=[g,a,b,e],l=function(a,b,c){"function"===typeof e[a]&&b&&e[a].apply(this,c)};l("onChange",!0===h,k);l("onKeyPress",!0===h,k);l("onComplete",g.length===d.length,k);l("onInvalid",0<c.invalid.length,[g,a,b,c.invalid,e])}};b=a(b);var l=this,f=c.val(),k;d="function"===typeof d?d(c.val(),void 0,b,e):d;l.mask=
d;l.options=e;l.remove=function(){var a=c.getCaret();l.options.placeholder&&b.removeAttr("placeholder");b.data("mask-maxlength")&&b.removeAttr("maxlength");c.destroyEvents();c.val(l.getCleanVal());c.setCaret(a);return b};l.getCleanVal=function(){return c.getMasked(!0)};l.getMaskedVal=function(a){return c.getMasked(!1,a)};l.init=function(g){g=g||!1;e=e||{};l.clearIfNotMatch=a.jMaskGlobals.clearIfNotMatch;l.byPassKeys=a.jMaskGlobals.byPassKeys;l.translation=a.extend({},a.jMaskGlobals.translation,e.translation);
l=a.extend(!0,{},l,e);k=c.getRegexMask();if(g)c.events(),c.val(c.getMasked());else{e.placeholder&&b.attr("placeholder",e.placeholder);b.data("mask")&&b.attr("autocomplete","off");g=0;for(var f=!0;g<d.length;g++){var h=l.translation[d.charAt(g)];if(h&&h.recursive){f=!1;break}}f&&b.attr("maxlength",d.length).data("mask-maxlength",!0);c.destroyEvents();c.events();g=c.getCaret();c.val(c.getMasked());c.setCaret(g)}};l.init(!b.is("input"))};a.maskWatchers={};var f=function(){var b=a(this),d={},e=b.attr("data-mask");
b.attr("data-mask-reverse")&&(d.reverse=!0);b.attr("data-mask-clearifnotmatch")&&(d.clearIfNotMatch=!0);"true"===b.attr("data-mask-selectonfocus")&&(d.selectOnFocus=!0);if(p(b,e,d))return b.data("mask",new n(this,e,d))},p=function(b,d,e){e=e||{};var c=a(b).data("mask"),f=JSON.stringify;b=a(b).val()||a(b).text();try{return"function"===typeof d&&(d=d(b)),"object"!==typeof c||f(c.options)!==f(e)||c.mask!==d}catch(w){}},k=function(a){var b=document.createElement("div");a="on"+a;var e=a in b;e||(b.setAttribute(a,
"return;"),e="function"===typeof b[a]);return e};a.fn.mask=function(b,d){d=d||{};var e=this.selector,c=a.jMaskGlobals,f=c.watchInterval;c=d.watchInputs||c.watchInputs;var k=function(){if(p(this,b,d))return a(this).data("mask",new n(this,b,d))};a(this).each(k);e&&""!==e&&c&&(clearInterval(a.maskWatchers[e]),a.maskWatchers[e]=setInterval(function(){a(document).find(e).each(k)},f));return this};a.fn.masked=function(a){return this.data("mask").getMaskedVal(a)};a.fn.unmask=function(){clearInterval(a.maskWatchers[this.selector]);
delete a.maskWatchers[this.selector];return this.each(function(){var b=a(this).data("mask");b&&b.remove().removeData("mask")})};a.fn.cleanVal=function(){return this.data("mask").getCleanVal()};a.applyDataMask=function(b){b=b||a.jMaskGlobals.maskElements;(b instanceof a?b:a(b)).filter(a.jMaskGlobals.dataMaskAttr).each(f)};k={maskElements:"input,td,span,div",dataMaskAttr:"*[data-mask]",dataMask:!0,watchInterval:300,watchInputs:!0,keyStrokeCompensation:10,useInput:!/Chrome\/[2-4][0-9]|SamsungBrowser/.test(window.navigator.userAgent)&&
k("input"),watchDataMask:!1,byPassKeys:[9,16,17,18,36,37,38,39,40,91],translation:{0:{pattern:/\d/},9:{pattern:/\d/,optional:!0},"#":{pattern:/\d/,recursive:!0},A:{pattern:/[a-zA-Z0-9]/},S:{pattern:/[a-zA-Z]/}}};a.jMaskGlobals=a.jMaskGlobals||{};k=a.jMaskGlobals=a.extend(!0,{},k,a.jMaskGlobals);k.dataMask&&a.applyDataMask();setInterval(function(){a.jMaskGlobals.watchDataMask&&a.applyDataMask()},k.watchInterval)},window.jQuery,window.Zepto);
