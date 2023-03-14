<?php

require_once __DIR__ . '/functions.php';


$id    = isset($_SESSION['id'])    ? $_SESSION['id']    : NULL;
$name    = isset($_SESSION['name'])    ? $_SESSION['name']    : NULL;
$rating = isset($_SESSION['rating']) ? $_SESSION['rating'] : NULL;
$body    = isset($_SESSION['body'])    ? $_SESSION['body']    : NULL;

require 'comment_view.php';
