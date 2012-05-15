$(document).ready(function(){   

if(!Modernizr.input.placeholder){
  $('[placeholder]').focus(function() {
   var input = $(this);
   if (input.val() == input.attr('placeholder')) {
     input.val('');
     input.removeClass('placeholder');
   }
  }).blur(function() {
  var input = $(this);
  if (input.val() == '' || input.val() == input.attr('placeholder')) {
    input.addClass('placeholder');
    input.val(input.attr('placeholder'));
  }
 }).blur();
 $('[placeholder]').parents('form').submit(function() {
  $(this).find('[placeholder]').each(function() {
    var input = $(this);
    if (input.val() == input.attr('placeholder')) {
      input.val('');
    }
  })
 });
}


$('.lc').bind('click',function(e) {

    if ($(this).attr('checked')) {
     $('.submit').removeClass('disabled');
    } else {
    $('.submit').addClass('disabled');
    }  
});

$('.lyrics-reveal').click(function (e) {
 $(this).hide();
$(this).siblings().show();
});

$('.song-reveal').click(function (e) {
    $('.song:not(:visible):first').show();
    if ($('.song:not(:visible)').length == 0) {
        $(this).hide();
    };
});

$('input.submit.disabled').live('click', function(e) {
    e.preventDefault();
});

});




