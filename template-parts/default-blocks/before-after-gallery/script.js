$('.ba-carousel').owlCarousel({
    loop:true,
    margin:baGutter,
    nav:baNavigation,
    dots: baDots,
    responsive:{
        0:{
            items:baPerPageMobile
        },
        600:{
            items:baPerPageTab
        },
        1000:{
            items:baPerPage
        }
    },
    navText : ['<i class="fas fa-caret-square-left"></i>','<i class="fas fa-caret-square-right"></i>']
})