<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--
    resetCSS
    ブラウザ固有のデザインをリセットする
    ブラウザによる見た目の違いをなくす
   -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@3.0.0/destyle.css">
  <!-- サイトデザイン用CSS -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" href="http://localhost/g05/img/logo/tree.ico">
  <title>エラー｜フォーム</title>
</head>

<body>

  <?php require 'header.html'; ?>

  <div class="CommentConfirm_content">
    <div class="CommentConfirm_inner CommentError">
      <h1 class="CommentError_title">エラー</h1>
      <p>セッションが切れました。</p>
      <p><a href="detail.php?id=<?php echo h($id); ?>" class=" CommentError_text">もう一度やり直してください。</a></p>
    </div>
  </div>

  <?php require 'footer.php'; ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="js/jquery.raty.js"></script>
</body>

</html>
