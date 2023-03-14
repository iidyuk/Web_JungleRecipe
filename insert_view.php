<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@3.0.0/destyle.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/jquery.rateyo.css">
  <title>送信完了｜Jungle Recipe</title>
</head>

<body>
  <?php require 'header.html'; ?>

  <div class="CommentConfirm_content">
    <div class="CommentConfirm_inner">
      <h1 class="CommentConfirm_title">完了画面</h1>

      <p class="CommentConfirm_text">以下の値で処理をしました。</p>

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
        <p><a class="CommentConfirm_btn" href="detail.php?id=<?php echo h($id); ?>">レシピに戻る</a></p>
        <p><a class="CommentConfirm_btn" href=" index.php">ホームに戻る</a></p>
      </div>
    </div>
  </div>

  <?php require 'footer.html'; ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="js/comment.js"></script>
  <script src="js/jquery.rateyo.min.js"></script>
  <script src="js/rateyo.js"></script>

</body>

</html>
