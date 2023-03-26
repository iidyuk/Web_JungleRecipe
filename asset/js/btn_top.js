// Topへ戻るボタン
$(function() {
  var pagetop = $('#Btn');
  pagetop.hide();
  $(window).scroll(function() {
    if ($(this).scrollTop() > 1000) {
      pagetop.fadeIn(300);
    } else {
      pagetop.fadeOut();
    }
  });
  pagetop.click(function() {
    $('body, html').animate({
      scrollTop: 0
    }, 50);
    return false;
  });
});