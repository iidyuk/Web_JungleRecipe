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
  <link rel="stylesheet" href="css/jquery.rateyo.css">
  <link rel="icon" href="http://localhost/g05/img/logo/tree.ico">
  <title>入力画面｜フォーム</title>
</head>

<body>

  <?php require 'header.html'; ?>

  <div class="CommentInput_content">
    <div class="CommentInput_inner">
      <?php if (isset($error)) : ?>
        <div class="CommentInput_error">
          <ul>
            <?php foreach ($error as $val) : ?>
              <li><?php echo $val; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form class="CommentInput_from" action="confirm.php" method="post">
        <dl class="CommentInput_list">
          <div class="CommentInput_item">
            <dt class="CommentInput_title required">名前</dt>
            <dd class="CommentInput_dd">
              <input class="CommentInput_input" type=" text" name="name" value="<?php echo h($name); ?>" size="50">
            </dd>
          </div>
          <div class="CommentInput_item">
            <dt class="CommentInput_title required">評価</dt>
            <div class="CommentInput_starBox">
              <?php if ($rating > 0) : ?>
                <dd class="CommentInput_star" data-rateyo-rating=<?php echo h($rating); ?>></dd>
              <?php else : ?>
                <dd class="CommentInput_star" data-rateyo-rating="0"></dd>
              <?php endif; ?>
              <span class='CommentConfirm_starNum result'></span>
              <input type="hidden" name="rating">
            </div>
          </div>
          <div class="CommentInput_item">
            <dt class="CommentInput_title">コメント</dt>
            <dd class="CommentInput_dd">
              <textarea class="CommentInput_textarea" name="body" cols="50" rows="10" placeholder="レシピの感想をお書きください。"><?php echo h($body); ?></textarea>
            </dd>
          </div>
        </dl>
        <p>
          <input class="CommentInput_btn" type="submit" value="確認画面へ">
        </p>
      </form>
    </div>
  </div>

  <?php require 'footer.php'; ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="js/jquery.rateyo.min.js"></script>
  <script>
    $('.CommentInput_star').rateYo({
      precision: 0,
    });
    $(".CommentInput_star").rateYo().on("rateyo.change", function(e, data) {
      var rating = data.rating;
      $(this).parent().find('.score').text('score :' + $(this).attr('data-rateyo-score'));
      $(this).parent().find('.result').text(rating);
      $(this).parent().find('input[name=rating]').val(rating); //add rating value to input field
    });
  </script>
</body>

</html>
