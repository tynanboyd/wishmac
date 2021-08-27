app.mobileNavigation = (($) => {
  function init() {
    const mobileNavTrigger = document.querySelector('.js-mobile-nav-trigger');
    const mobileNavContainer = document.querySelector('.js-mobile-nav-container');
    const mobileNavOverlay = document.querySelector('.js-mobile-nav-overlay');
    const body = document.querySelector('body');

    function toggleMobileNav() {
      mobileNavTrigger.classList.toggle('is-active');
      mobileNavContainer.classList.toggle('is-open');
      body.classList.toggle('mobile-nav-open');
      mobileNavOverlay.classList.toggle('d-none');
      mobileNavOverlay.classList.toggle('d-block');
    }

    mobileNavTrigger.addEventListener('click', toggleMobileNav);
    mobileNavOverlay.addEventListener('click', toggleMobileNav);
  }// init
  /* Document ready
  /* + + + + + + + + + + + + + + + + + + + + + + + + + + + */
  $(document).on('ready', init);
})(jQuery);
