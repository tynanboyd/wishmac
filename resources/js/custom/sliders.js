app.sliders = (($) => {
  function initSlider() {
    $('.js-gallery').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      fade: true,
      autoplay: false,
    });
    // $('.js-gallery-nav').slick({
    //   slidesToShow: 2,
    //   slidesToScroll: 1,
    //   asNavFor: '.js-gallery',
    //   dots: true,
    //   focusOnSelect: true,
    // });
  }

  function init() {
    if ($('.js-gallery').length) {
      initSlider();
    }
  } // init

  /* Document ready
  /* + + + + + + + + + + + + + + + + + + + + + + + */

  $(document).on('ready', init);
})(jQuery);
