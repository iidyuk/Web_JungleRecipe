<?php
  session_start();
  session_regenerate_id(TRUE);

  $debug = false;
  require_once dirname(__FILE__) . '/_function/functions.php';

  $id    = isset($_GET['id'])    ? $_GET['id']    : NULL;
  $sessid    = isset($_SESSION['id'])    ? $_SESSION['id']    : NULL;

  if ($sessid !== $id) {
    unset($_SESSION['id']);
    unset($_SESSION['name']);
    unset($_SESSION['rating']);
    unset($_SESSION['body']);
  }

  $dbobj = connectTarzan();
  // memo:↓$_SESSION['search'] は
  $query    = isset($_SESSION['search'])    ? $_SESSION['search']    : NULL;
  $sql = 'SELECT * FROM recipe_tbl';
  $trSet = mysqli_query($dbobj, $sql) or die(mysqli_error($dbobj));
  $bl = mysqli_affected_rows($dbobj);
  $trData = mysqli_fetch_assoc($trSet);
  $bl = false;

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $_SESSION['id'] = $id;
    $sql2 = sprintf(
      'SELECT * FROM recipe_tbl WHERE recipe_id=%d',
      mysqli_real_escape_string($dbobj, $id)
    );
    $stSet = mysqli_query($dbobj, $sql2) or die(mysqli_error($dbobj));
    $bl = mysqli_affected_rows($dbobj);
    $stData = mysqli_fetch_assoc($stSet);

    $sql6 = 'SELECT recipe_id, com_recipeid, AVG(com_rate) AS avg
    FROM recipe_tbl LEFT JOIN comment_tbl
    ON recipe_tbl.recipe_id=comment_tbl.com_recipeid
    WHERE recipe_id=' . $id .
      ' GROUP BY recipe_id';
    $rankingSet = mysqli_query($dbobj, $sql6) or die(mysqli_error($dbobj));
    $ranking = mysqli_fetch_assoc($rankingSet);
  } else {
  }

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql3 = sprintf(
      'SELECT * FROM recipetag_tbl LEFT JOIN tag_tbl ON recipetag_tbl.rtag_tagid = tag_tbl.tag_id WHERE rtag_recipeid=%d',
      mysqli_real_escape_string($dbobj, $id)
    );
    $stSet3 = mysqli_query($dbobj, $sql3) or die(mysqli_error($dbobj));
    $bl = mysqli_affected_rows($dbobj);
  } else {
  }

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql4 = sprintf(
      'SELECT * FROM ingredient_tbl LEFT JOIN recipe_tbl ON ingredient_tbl.ing_id = recipe_tbl.recipe_id WHERE ing_recipeid=%d',
      mysqli_real_escape_string($dbobj, $id)
    );
    $stSet4 = mysqli_query($dbobj, $sql4) or die(mysqli_error($dbobj));
    $bl = mysqli_affected_rows($dbobj);
  } else {
  }

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql5 = sprintf(
      'SELECT * FROM step_tbl LEFT JOIN recipe_tbl ON step_tbl.step_recipeid = recipe_tbl.recipe_id WHERE step_recipeid=%d',
      mysqli_real_escape_string($dbobj, $id)
    );
    $stSet5 = mysqli_query($dbobj, $sql5) or die(mysqli_error($dbobj));
    $bl = mysqli_affected_rows($dbobj);
  } else {
  }

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--
    resetCSS
    ブラウザ固有のデザインをリセットする
    ブラウザによる見た目の違いをなくす
   -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@3.0.0/destyle.css">
  <!-- サイトデザイン用CSS -->
  <link rel="stylesheet" href="./asset/css/style.css">
  <link rel="stylesheet" href="./asset/css/jquery.rateyo.css">

  <link rel="icon" href="./asset/img/logo/tree.ico">
  <?php if ($id) : ?>
    <title><?php echo h($stData['recipe_title']) . '｜Jungle Recipe'; ?></title>
  <?php else : ?>
    <title><?php echo '	&#x26a0;レシピが存在しません' . '｜Jungle Recipe'; ?></title>
  <?php endif; ?>
</head>

<body>
  <?php if ($debug) : ?>
    <div class="debug">
      <p>デバッグ用</p>
      <p>$sql: <?php print $sql; ?></p>
      <p>$sql2: <?php print $sql2; ?></p>
      <p>$sql3: <?php print $sql3; ?></p>
      <p>$sql4: <?php print $sql4; ?></p>
      <p>$sql5: <?php print $sql5; ?></p>
      <p>mysqli_affected_rows($dbobj):<?php print mysqli_affected_rows($dbobj); ?></p>
    </div>
  <?php endif; ?>

  <div class="Wrapper">
    <?php
      require_once(__DIR__ . '/_parts/header.html');
    ?>

    <nav class="breadcrumbs">
      <ol>
        <li><a href="index.php">トップページ</a></li>
        <li><a href="result.php?Search=<?php echo $query; ?>">検索結果</a></li>
        <li>
          <?php if ($id) : ?>
            <?php echo h($stData['recipe_title']); ?>
          <?php endif; ?>

          <!-- <?php //echo h($stData['recipe_title']);
                ?> -->
        </li>
      </ol>
    </nav>

    <main class="detail_main">

      <!-- SNSボタン(左サイド) -->
      <?php
      require_once __DIR__ . '/_parts/bar_left.html';
      ?>

      <!-- <div class="detail_content"> -->
      <div class="main_bodyLeft">
        <div class="Box_header">
          <div class="Box_inner">
            <?php //if ($id == null || $id !== $stData['recipe_id']) :
            ?>
            <?php if ($bl) : ?>

            <?php //echo '	&#x26a0;レシピが存在しません';
            ?>
            <?php //else :
            ?>
            <div class="detail_top">
              <div class="detail_top_box">
                <?php while ($stData3 = mysqli_fetch_assoc($stSet3)) : ?>
                <div class="detail_tag"><?php echo h($stData3['tag_name']); ?></div>
                <?php endwhile; ?>

                <div class="detail_date">投稿日：<?php echo h($stData['recipe_date']); ?></div>
                <div class="detail_title"><?php echo h($stData['recipe_title']); ?></div>
              </div>
              <div class="detail_middle_box">
                <img class="detail_img" src="./asset/img/<?php echo h($stData['recipe_img']); ?>.jpg" alt="<?php echo h($stData['recipe_title']); ?>">
              </div>
              <div class="detail_bottom_box">

                <div class="detail_star">
                  <div class="CommentList_starBox">
                    <div class="star" data-rateyo-rating="<?php echo h($ranking['avg']); ?>"></div>
                    <div class="star_num"><?php echo number_format($ranking['avg'], 1); ?></div>
                  </div>
                </div>

                <div class="detail_description"><?php echo h($stData['recipe_description']); ?></div>
              </div>
            </div>
          </div>
        </div>

        <div class="Box_body">
          <div class="Box_inner narrowArea">
            <div class="calorie">
              <div class="calorie_text">このレシピのカロリーは・・・</div>
              <div class="calorie_amount"><?php echo h($stData['recipe_calorie']); ?>&nbsp;kcal</div>
            </div>

            <div class=" ingredients">
              <div class="ingredients_title">
                INGREDIENTS&emsp;
                <div class="ingredients_title_sub">
                  材料（<?php echo h($stData['recipe_people']); ?>人）
                </div>
              </div>
              <div class="ingredients_text">
                <?php while ($stData4 = mysqli_fetch_assoc($stSet4)) : ?>
                <div class="ingredients_box">
                  <div class="ingredients_list">・<?php echo h($stData4['ing_ingredient']); ?></div>
                  <div class="ingredients_list_vol"><?php echo h($stData4['ing_vol']); ?></div>
                </div>
                <?php endwhile; ?>
              </div>
            </div>

            <div class="howToCook">
              <div class="howToCook_title">
                HOW TO COOK&emsp;
                <div class="howToCook_title_sub">
                  作り方
                </div>
              </div>
              <div class="howToCook_text">
                <?php while ($stData5 = mysqli_fetch_assoc($stSet5)) : ?>
                <div class="howToCook_box">
                  <div class="howToCook_no"><?php echo h($stData5['step_no']) . '.' ?></div>
                  <div class="howToCook_way"><?php echo h($stData5['step_detail']); ?></div>
                </div>
                <?php endwhile; ?>
              </div>
            </div>
          <?php endif; ?>


          <?php if ($id) : ?>
          <div class="detail_commentBox">
            <?php require './_comment/comment_list.php'; ?>
            <?php require './_comment/comment.php'; ?>
          </div>
          <?php else : ?>
          <p class="detail_error">レシピが存在しません</p>
          <?php endif; ?>
        </div>
      </div>

      <?php /* 
        <div class="main_bodyRight">
          <img src="img/detail_sidebar.png" alt="">
          <?php //require 'sidebar.php';
          ?>
          <?php //require 'recommend.php';
          ?>
        </div>
       */ ?>

      <!-- Topへ戻るボタン -->
      <?php 
        require_once __DIR__ . '/_parts/btn_top.html';
      ?>
    </main>

    <?php
      require_once __DIR__ . '/_parts/footer.php';
    ?>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="./asset/js/common.js"></script>
  <script src="./asset/js/googlefonts.js"></script>
  <script src="./asset/js/index.js"></script>
  <script src="./asset/js/comment.js"></script>
  <script src="./asset/js/bar_left.js"></script>
  <script src="./asset/js/btn_top.js"></script>
  <script src="./asset/js/jquery.rateyo.min.js"></script>
  <script src="./asset/js/rateyo.js"></script>
  <script>
    $('.CommentList_totalStar').rateYo({
      readOnly: true,
    });
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
