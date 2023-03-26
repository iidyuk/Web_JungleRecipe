<?php
// HTMLでのエスケープ処理をする関数
function h($var)
{
  if (is_array($var)) {
    return array_map('h', $var);
  } else {
    return htmlspecialchars($var ?? '', ENT_QUOTES);
  }
}

// デバッグ用関数
function v($val)
{
  echo '<pre>';
  var_dump($val);
  echo '</pre>';
}

// MySQL(MariaDB)に接続する関数
function connectTarzan()
{
  $dbobj = mysqli_connect(
    'localhost', // string host name
    'group05', // string user name
    'admin' // password
  ) or die('DBに接続できませんでした');
  mysqli_select_db($dbobj, '20211005'); // bool データベース領域を選択
  mysqli_set_charset($dbobj, 'utf8'); // bool 文字コードの指定
  return $dbobj;
}
