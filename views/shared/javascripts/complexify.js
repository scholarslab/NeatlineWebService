jQuery(function($) {

  // Impelements complexify.
  // https://github.com/danpalmer/jquery.complexify.js
  $('#password').complexify({}, function(valid, complexity) {

    if (!valid) {
      $('#progress').css(
        {'width': complexity + '%'}
      ).removeClass('progressbarValid').addClass('progressbarInvalid');
    } else {
      $('#progress').css(
        {'width': complexity + '%'}
      ).removeClass('progressbarInvalid').addClass('progressbarValid');
    }

    $('#complexity').html(Math.round(complexity) + '%');

  });
});
