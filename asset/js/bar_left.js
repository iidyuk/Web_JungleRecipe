// SNSボタン(左サイド)

// ↓ readey() ver: JQueryからDOMツリーを利用できる状態になってから処理を実行
$(function() {
  var pagetop = $('.Leftside_sns');
  $(window).scroll(function() {
    if ($(this).scrollTop() >= 1600) {
      pagetop.hide();
    } else {
      pagetop.show();
    }
  });
});

// ↓ on('load', ) ver: ページ内の要素の読み込みが完了してから実行
// $(window).on('load', function(){
//   var pagetop = $('.Leftside_sns');
//   $(window).scroll(function() {
//     if ($(this).scrollTop() >= 1600) {
//       pagetop.hide();
//     } else {
//       pagetop.show();
//     }
//   });
// });
