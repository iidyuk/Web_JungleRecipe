<?php
session_start();
require_once __DIR__ . '/functions.php';
$dbobj = connectTarzan();

$id    = isset($_SESSION['id'])    ? $_SESSION['id']    : NULL;
$name    = isset($_SESSION['name'])    ? $_SESSION['name']    : NULL;
$rating = isset($_SESSION['rating']) ? $_SESSION['rating'] : NULL;
$body    = isset($_SESSION['body'])    ? $_SESSION['body']    : NULL;

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

$date = '';
$sql = '';
if (count($error) > 0) {
  require 'error_view.php';
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
  require 'insert_view.php';
}
