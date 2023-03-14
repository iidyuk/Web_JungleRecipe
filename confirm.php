<?php
session_start();
require_once __DIR__ . '/functions.php';

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

if (count($error) > 0) {
  require 'comment_error.php';
} else {
  $_SESSION['id']    = $id;
  $_SESSION['name']    = $name;
  $_SESSION['rating'] = $rating;
  $_SESSION['body']    = $body;
  require 'confirm_view.php';
}
