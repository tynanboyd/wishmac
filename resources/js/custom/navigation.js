app.navigation = (($) => {
  function init() {
    function checkHeader() {
      const scroll = $(window).scrollTop();
      if (scroll >= 100) {
        $('.site-header').addClass('site-header--scrolled');
      } else {
        $('.site-header').removeClass('site-header--scrolled');
      }
    }

    window.addEventListener('scroll', checkHeader);
  }// init
  /* Document ready
  /* + + + + + + + + + + + + + + + + + + + + + + + + + + + */
  $(document).on('ready', init);
})(jQuery);
