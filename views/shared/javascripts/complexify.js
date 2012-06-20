jQuery(function($) {
  // impelements complexify; see https://github.com/danpalmer/jquery.complexify.js

  $('#password').complexify({}, function(valid, complexity) {
    console.log('fired');

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
