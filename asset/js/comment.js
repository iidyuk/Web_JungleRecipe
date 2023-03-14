var moreNum = 3;
$('.CommentList_list .CommentList_item:nth-child(n + ' + (moreNum + 1) + ')').addClass('is-hidden');
$('.CommentList_link, .CommentList_comment_num_link').on('click', function () {
  $('.CommentList_list .CommentList_item.is-hidden').slice(0, moreNum).removeClass('is-hidden');
  if ($('.CommentList_list .CommentList_item.is-hidden').length == 0) {
    $('.CommentList_link').fadeOut();
  }
});
