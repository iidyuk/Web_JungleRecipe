<?php
$debug = true;
require_once dirname(__FILE__) . '../../_function/functions.php';

$dbobj = connectTarzan();
$id    = isset($_SESSION['id'])    ? $_SESSION['id']    : NULL;

if ($id) {
  $sql1 = 'SELECT * FROM comment_tbl WHERE com_recipeid=' . $_SESSION['id'] . ' ORDER BY com_date DESC';
  $sql2 = 'SELECT recipe_id, com_recipeid, AVG(com_rate) AS avg
  FROM recipe_tbl LEFT JOIN comment_tbl
  ON recipe_tbl.recipe_id=comment_tbl.com_recipeid
  WHERE recipe_id=' . $_SESSION['id'] .
    ' GROUP BY recipe_id';
  $resultSet = mysqli_query($dbobj, $sql1) or die(mysqli_error($dbobj));
  $rankingSet = mysqli_query($dbobj, $sql2) or die(mysqli_error($dbobj));
  $count = $resultSet->num_rows;
  $ranking = mysqli_fetch_assoc($rankingSet);
  $bl = mysqli_affected_rows($dbobj);
} else {
  $count = 0;
}
?>

<div id="CommentList" class="CommentList_content">
  <h2 class="CommentList_title">Review 評価</h2>
  <div class="CommentList_inner">
    <div class="CommentList_box">
      <div class="CommentList_totalStar" data-rateyo-rating="<?php echo h($ranking['avg']); ?>"></div>
      <div class="CommentList_totalRate"><?php echo number_format($ranking['avg'], 1); ?></div>
      <div class="CommentList_comment_num">(<a class="CommentList_comment_num_link" href="#CommentList"><?php echo $count . "件"; ?></a>)</div>
    </div>
    <?php if ($bl) : ?>
      <ul class="CommentList_list">
        <?php while ($data = mysqli_fetch_assoc($resultSet)) : ?>
          <li class="CommentList_item">
            <div class="CommentList_name"><?php echo h($data['com_name']); ?></div>
            <div class="CommentList_starBox">
              <div class="star" data-rateyo-rating="<?php echo h($data['com_rate']); ?>"></div>
              <div class="star_num"><?php echo number_format(h($data['com_rate']), 1); ?></div>
              <time class="CommentList_date" datetime="<?php echo h($data['com_date']); ?>"><?php echo date('Y.m.d', strtotime(h($data['com_date']))); ?></time>
            </div>
            <div class="CommentList_comment"><?php echo h($data['com_comment']); ?></div>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php endif; ?>

    <?php if ($count > 3) : ?>
      <div class="CommentList_btn">
        <a href="#CommentList" class="CommentList_link">VIEW MORE
          <img class="CommentList_linkArrow" src="./asset/img/btn/arrow1.png">
        </a>
      </div>
    <?php endif; ?>

  </div>
