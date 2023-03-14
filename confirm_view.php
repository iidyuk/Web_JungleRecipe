<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@3.0.0/destyle.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/jquery.rateyo.css">
  <link rel="icon" href="http://localhost/g05/img/logo/tree.ico">
  <title>内容確認｜Jungle Recipe</title>
</head>

<body>
  <?php require 'header.html'; ?>

  <div class="CommentConfirm_content">
    <div class="CommentConfirm_inner">
      <h1 class="CommentConfirm_title">内容確認</h1>

      <dl class="CommentConfirm_confirm">
        <div class="CommentConfirm_item">
          <dt class="CommentConfirm_dt">お名前</dt>
          <dd class="CommentConfirm_dd"><?php echo h($name); ?></dd>
        </div>
        <div class="CommentConfirm_item">
          <dt class="CommentConfirm_dt">評価</dt>
          <div class="CommentConfirm_starBox">
            <dd class="CommentConfirm_star star" data-rateyo-rating="<?php echo h($rating); ?>"></dd>
            <dd class="CommentConfirm_starNum"><?php echo h($rating); ?></dd>
          </div>
        </div>
        <div class="CommentConfirm_item">
          <dt class="CommentConfirm_dt">コメント</dt>
          <dd class="CommentConfirm_dd"><?php echo nl2br(h($body)); ?></dd>
        </div>
      </dl>

      <div class="CommentConfirm_btnBox">
        <p><a class="CommentConfirm_btn" href="detail.php?id=<?php echo h($id); ?>">入力画面に戻る</a></p>
        <p><a class="CommentConfirm_btn" href="insert.php">送信する</a></p>
      </div>
    </div>
  </div>

  <?php require 'footer.php'; ?>


  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="js/jquery.rateyo.min.js"></script>
  <script src="js/rateyo.js"></script>
</body>

</html>
