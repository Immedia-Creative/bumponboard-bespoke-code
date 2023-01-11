(function ($) {
  "use strict";
  $(document).ready(function () {
    $('#my-user').attr('placeholder', placeHolderForTopBar.usernamePlaceholder);
    $('#my-pass').attr('placeholder', placeHolderForTopBar.passwordPlaceholder);
    $('#pass1').attr('placeholder', placeHolderForTopBar.newPasswordPlaceholder);
    $('#pass2').attr('placeholder', placeHolderForTopBar.repeatPasswordPlaceholder);
  });
})(jQuery);