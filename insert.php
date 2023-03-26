<?php
  session_start();
  // require_once __DIR__ . '/functions.php';
  require_once dirname(__FILE__) . '/_function/functions.php';
  $dbobj = connectTarzan();

  $id    = isset($_SESSION['id'])    ? $_SESSION['id']    : NULL;
  $name    = isset($_SESSION['name'])    ? $_SESSION['name']    : NULL;
  $rating = isset($_SESSION['rating']) ? $_SESSION['rating'] : NULL;
  $body    = isset($_SESSION['body'])    ? $_SESSION['body']    : NULL;

  echo $id;
  echo 'a';

  unset($_SESSION['id']);
  unset($_SESSION['name']);
  unset($_SESSION['rating']);
  unset($_SESSION['body']);

  $error = [];
  if ($name === NULL) {
    $error[] = '名前の値なし';
  }

  if ($rating === NULL) {
    $error[] = '評価の値なし';
  }
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- resetCSS ブラウザ固有のデザインをリセットする ブラウザによる見た目の違いをなくす -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@3.0.0/destyle.css">
  <!-- サイトデザイン用CSS -->
  <link rel="stylesheet" href="./asset/css/style.css">
  <link rel="icon" href="http://localhost/g05/img/logo/tree.ico">
  <title>フォーム</title>
</head>

<body>

  <?php require './_parts/header.html'; ?>

  <?php
  $date = '';
  $sql = '';
  if (count($error) > 0) {
    require './_comment/error_view.php';
  } else {
    $id = mysqli_real_escape_string($dbobj, mb_convert_kana($id, 'n'));
    $name = mysqli_real_escape_string($dbobj, $name);
    $rating = mysqli_real_escape_string($dbobj, mb_convert_kana($rating, 'n'));
    $body = mysqli_real_escape_string($dbobj, $body);
    $date = mysqli_real_escape_string($dbobj, $date);
    $sql = sprintf(
      'INSERT INTO comment_tbl SET
    com_recipeid=%d, com_name="%s", com_rate=%d, com_comment="%s", com_date=now()',
      $id,
      $name,
      $rating,
      $body,
      $date
    );
    mysqli_query($dbobj, $sql) or die(mysqli_error($dbobj));
    require './_comment/insert_view.php';
  }
  ?>

  <?php require './_parts/footer.php'; ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="js/comment.js"></script>
  <script src="js/jquery.rateyo.min.js"></script>
  <script src="js/jquery.raty.js"></script>
  <script src="js/rateyo.js"></script>
</body>
</html>

