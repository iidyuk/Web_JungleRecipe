<?php
  session_start();
  // require_once __DIR__ . '/functions.php';
  require_once dirname(__FILE__) . '/_function/functions.php';

  // v($_POST);
  // v($_SESSION);

  $id = isset($_SESSION['id']) ? $_SESSION['id'] : NULL;
  $name    = isset($_POST['name'])    ? $_POST['name']    : NULL;
  $rating = isset($_POST['rating']) ? $_POST['rating'] : NULL;
  $body    = isset($_POST['body'])    ? $_POST['body']    : NULL;

  $name = mb_convert_kana($name, 's');
  $rating = mb_convert_kana($rating, 's');
  $body = mb_convert_kana($body, 's');

  $id = trim($id);
  $name    = trim($name);
  $rating = trim($rating);
  $body    = trim($body);

  $error = [];

  if ($name == '') {
    $error[] = 'お名前は必須項目です。';
  } else if (mb_strlen($name) > 20) {
    $error[] = 'お名前は20文字以内でお願い致します。';
  }

  if ($rating == '') {
    $error[] = '評価は必須項目です。';
  } else if (mb_strlen($rating) > 5) {
    $error[] = '不正な値です。';
  }

  if (mb_strlen($body) > 500) {
    $error[] = 'コメントは500文字以内でお願い致します。';
  }

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@3.0.0/destyle.css">
  <link rel="stylesheet" href="./asset/css/style.css">
  <link rel="stylesheet" href="./asset/css/jquery.rateyo.css">
  <link rel="icon" href="http://localhost/g05/img/logo/tree.ico">
  <title>内容確認｜Jungle Recipe</title>
</head>

<body>

  <?php require './_parts/header.html'; ?>

  <?php
    if (count($error) > 0) {
      require '_comment/comment_error.php';
    } else {
      $_SESSION['id']    = $id;
      $_SESSION['name']    = $name;
      $_SESSION['rating'] = $rating;
      $_SESSION['body']    = $body;
      require '_comment/confirm_view.php';
    }
  ?>

  <?php require './_parts/footer.php'; ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="js/jquery.rateyo.min.js"></script>
  <script src="js/rateyo.js"></script>
</body>

</html>
