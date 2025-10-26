function addTitleToExLink() {
   $('a[target="_blank"]').each(function(){
    $(this).attr({title: "Link opens in a new window"})
    })
}



function insertScript(url) {

    function isScriptLoaded(url) {
        var scripts = document.getElementsByTagName('script');
        for (var i = scripts.length; i--;) {
            if (scripts[i].src == url) return true;
        }
        return false;
    }

    if (!isScriptLoaded(url)) {
        var head = document.getElementsByTagName('head')[0];
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = url;
            head.appendChild(script);
    }

}


function insertStyles(file, id) {
    var DynamicCss = document.getElementById(id);
        if(!DynamicCss){
          var cssFile = file;
          var link = document.createElement( "link" );
          link.href = cssFile;
          link.id= id;
          link.type = "text/css";
          link.rel = "stylesheet";
          document.getElementsByTagName( "head" )[0].appendChild( link );
        }
}




$(this).one('mousemove', function() {
    console.log('test-move')
        if (mobileDevice) {
           insertStyles(TEMPDIR + '/plugins/fontawesome/css/all.min.css', 'fontAwesome');
        }
        //insertScript('https://www.bots.ekwa.com/chatbox/10529/loader.js');
         insertScript('https://assets.pinterest.com/js/pinit.js');
          addTitleToExLink();


    }).one('scroll', function(){

    console.log('test-scroll');
        if (mobileDevice) {
           insertStyles(TEMPDIR + '/plugins/fontawesome/css/all.min.css', 'fontAwesome');

                setTimeout(function() {
                  $('.footer-icons, .scrollup').show();
                }, 1000);
        }
       // insertScript('https://www.bots.ekwa.com/chatbox/10529/loader.js');
        insertScript('https://assets.pinterest.com/js/pinit.js');
         addTitleToExLink();

    }).one('touchstart', function () {
      if (mobileDevice) {
        insertStyles(TEMPDIR + '/plugins/fontawesome/css/all.min.css', 'fontAwesome');

             setTimeout(function() {
               $('.footer-icons, .scrollup').show();
             }, 1000);
      }
      insertScript('https://assets.pinterest.com/js/pinit.js');
      addTitleToExLink();


    });



$(document).ready(function(){
     $(".ekwa-read-more-btn").click(function(e){
        e.preventDefault();
        $(".ekwa-hidden-content").slideToggle();
     })
});

/* search popup */


const overlay = document.getElementById('overlay');
const searchPopup = document.getElementById('search-popup');
const closeBtn = document.getElementById('close-btn');
const searchIcons = document.querySelectorAll('.search-icon');


function openSearchPopup() {
  overlay.classList.add('active');
  searchPopup.classList.add('active');
  closeBtn.classList.add('active');
}


function closeSearchPopup() {
  overlay.classList.remove('active');
  searchPopup.classList.remove('active');
  closeBtn.classList.remove('active');
}


searchIcons.forEach(icon => {
  icon.addEventListener('click', openSearchPopup);
});


closeBtn.addEventListener('click', closeSearchPopup);
overlay.addEventListener('click', closeSearchPopup);


