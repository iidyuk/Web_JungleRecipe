<?php

// ↓マガジンの発売日の値を作成
  // 現在の日時を取得
  $now = time();
  // $now = strtotime('2023-03-23');
  $nowDay = date('N', $now); //曜日を取得

  // 直近の過去の木曜日までの日数を取得
  if ($nowDay <= 3) {
    $daysAgoNum = $nowDay + 3;
  } elseif($nowDay >= 4) {
    $daysAgoNum = $nowDay - 4;
  }

  // 過去の最も近い木曜日の日時を計算
  $last_thursday = strtotime("-$daysAgoNum days", $now);

  // 過去の最も近い木曜日から2週前の日時を計算
  $twoWeekAgo_thur = strtotime("-2 weeks", $last_thursday);
  // 過去の最も近い木曜日から4週前の日時を計算
  $threeWeekAgo_thur = strtotime("-4 weeks", $last_thursday);
  // 過去の最も近い木曜日から6週前の日時を計算
  $fourWeekAgo_thur = strtotime("-6 weeks", $last_thursday);
  // 過去の最も近い木曜日から8週前の日時を計算
  $fiveWeekAgo_thur = strtotime("-8 weeks", $last_thursday);

  // 日付のフォーマットを設定
  // $date_format = 'Y年m月d日';
  $date_format = 'Y/n/j';

  
  // 直近の木曜日の日付の値
  $makeReleaseDay = date($date_format, $last_thursday);

  // 配列に格納
  $bNReleaseDay = array(
    date($date_format, $twoWeekAgo_thur),
    date($date_format, $threeWeekAgo_thur),
    date($date_format, $fourWeekAgo_thur),
    date($date_format, $fiveWeekAgo_thur)
  );


  // 結果を出力
  // echo '最も近い過去の木曜日は、' . date($date_format, $last_thursday) . 'です。';
  // echo '直近から2週前の木曜日は、' . date($date_format, $twoWeekAgo_thur) . 'です。';
