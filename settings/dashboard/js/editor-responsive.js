

(function($){

    $(document).ready(function(){
      
        

        $(document).on('click', '.ekwa-desktop-view', function(){
            $('.edit-post-visual-editor__content-area').removeClass('ekwa-tablet-view');
            $('.edit-post-visual-editor__content-area').removeClass('ekwa-mobile-view');
            $('.edit-post-visual-editor__content-area').addClass('ekwa-desktop-view');
            
        });

        $(document).on('click', '.ekwa-tablet-view', function(){
            $('.edit-post-visual-editor__content-area').removeClass('ekwa-desktop-view');
            $('.edit-post-visual-editor__content-area').removeClass('ekwa-mobile-view');
            $('.edit-post-visual-editor__content-area').addClass('ekwa-tablet-view');
            
        });

        $(document).on('click', '.ekwa-mobile-view', function(){
            $('.edit-post-visual-editor__content-area').removeClass('ekwa-desktop-view');
            $('.edit-post-visual-editor__content-area').removeClass('ekwa-tablet-view');
            $('.edit-post-visual-editor__content-area').addClass('ekwa-mobile-view');
        });


      /*

      wp.domReady(function(){
        var Selected_cols =   $("[data-type='acf/bs-column']" ).attr('id');

         alert('dd')
      })*/





    })

})(jQuery);