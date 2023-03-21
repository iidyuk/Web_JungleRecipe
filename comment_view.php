<div id="CommentInput" class="CommentInput_content">
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
    <?php $rating = 0; ?>

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
