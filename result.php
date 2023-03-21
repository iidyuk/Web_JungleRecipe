<?php
  session_start();
  $debug = true;
  // require_once dirname(__FILE__) . '/functions.php';
  require_once __DIR__ . '/functions.php';
  $dbobj = connectTarzan();

  // 変数値確認。
  $search    = isset($_GET['Search'])    ? $_GET['Search']    : Null; //memo getでパラメータを受け取っているかの確認
  //
  $_SESSION['search'] = $search;
  $query = $_SESSION['search'];
  // 1ページに5件ずつ表示するための変数
  $num_page = 5;
  // $scope = "";

  // memo: ↓getで受け取った値をswitchで条件分岐している
  switch ($query) {
    case 0: // 全件出力
      $scope = " >= 0";
      $msg   = '"指定なし"';
      break;
    case 1: // 0kcal以上～200kcal未満
      $scope = " > 0 AND recipe_calorie < 200";
      $msg   = '"200kcal未満"';
      break;
    case 2: // 200kcal以上～400kcal未満
      $scope = ">= 200 AND recipe_calorie < 400";
      $msg   = '"200～400kcal未満"';
      break;
    case 3: // 400kcal以上
      $scope = " >= 400";
      $msg   = '"400kcal以上"';
      break;
  }



  // memo: ↓SQL文 データベースから値を取得している

  // localStorage.setItem('scope2', $scope);
  // $scope2 = localStorage.setItem('scope2');
  // 変数$sql1に検索結果の情報を持たせる
  //  セレクト対象：レシピテーブル
  //   ・レシピid(レシピテーブル)
  //   ・レシピタイトル(レシピテーブル)
  //   ・イメージファイル(レシピテーブル)
  //   ・公開日(レシピテーブル)
  //   ・カロリー数値(レシピテーブル)
  //   ・レート(レシピテーブル)
  //  セレクト対象：レシピタグテーブル
  //   ・タグid
  //   ・レシピid(レシピテーブルのidと＝)
  //   ・タグ(タグテーブルのidと＝)
  //  セレクト対象：タグテーブル
  //   ・タグid
  //   ・タグ
  // JOIN対象１：レシピテーブルのレシピID   ＝ レシピタグテーブルのタグID
  // JOIN対象２：レシピタグテーブルのタグID ＝ タグテーブルのタグID
  //   抽出対象：レシピテーブルのカロリーがindex.phpで指定したカロリー
  $sql1 = 'SELECT
  recipe_tbl.recipe_id        as recipe_id,
  recipe_tbl.recipe_title     as recipe_title,
  recipe_tbl.recipe_img       as recipe_img,
  recipe_tbl.recipe_date      as recipe_date,
  recipe_tbl.recipe_calorie   as recipe_calorie,
  recipetag_tbl.rtag_recipeid as rtag_recipeid,
  recipetag_tbl.rtag_tagid    as rtag_tagid,
  tag_tbl.tag_id              as tag_id,
  tag_tbl.tag_name            as tag_name
    FROM          recipe_tbl left JOIN recipetag_tbl
                              ON recipe_tbl.recipe_id = recipetag_tbl.rtag_recipeid
                            left JOIN tag_tbl
                              ON recipetag_tbl.rtag_tagid = tag_tbl.tag_id
                            where recipe_calorie' . $scope;

  $sql2 = 'SELECT
  recipe_tbl.recipe_id        as recipe_id,
  recipe_tbl.recipe_title     as recipe_title,
  recipe_tbl.recipe_img       as recipe_img,
  recipe_tbl.recipe_date      as recipe_date,
  recipe_tbl.recipe_calorie   as recipe_calorie,
  recipetag_tbl.rtag_recipeid as rtag_recipeid,
  recipetag_tbl.rtag_tagid    as rtag_tagid,
  tag_tbl.tag_id              as tag_id,
  tag_tbl.tag_name            as tag_name
    FROM          recipe_tbl left JOIN recipetag_tbl
                              ON recipe_tbl.recipe_id = recipetag_tbl.rtag_recipeid
                            left JOIN tag_tbl
                              ON recipetag_tbl.rtag_tagid = tag_tbl.tag_id
                            where recipe_calorie' . $scope . ' group by recipe_id';


  // $sql2 =  'SELECT count(*)  as num
  //   FROM          recipe_tbl left JOIN recipetag_tbl
  //                              ON recipe_tbl.recipe_id = recipetag_tbl.rtag_recipeid
  //                            left JOIN tag_tbl
  //                              ON recipetag_tbl.rtag_tagid = tag_tbl.tag_id
  //                            group by recipe_id';

  // memo: ↓「並び替え」用のコード
  $select1 = 0;
  $count2 = "";
  if (isset($_GET["select1"])) {
    $select1 = $_GET["select1"];
    $_SESSION['select1'] = $select1;
    switch ($select1) {
      case 0:
        // 指定なし(全件表示)
        // $sql3 = $_SESSION['SQL3'];
        break;
      case 1:
        // 新着順(降順)
        $sql1  = $sql1 . ' ORDER BY recipe_date DESC';
        $sql2  = $sql2 . ' ORDER BY recipe_date DESC';
        // $sql3 = $_SESSION['SQL3'] . ' ORDER BY recipe_date DESC';
        $msg   = '"投稿日が新しい順"';
        break;
      case 2:
        // 新着順(昇順)
        $sql1 = $sql1 . ' ORDER BY recipe_date';
        $sql2 = $sql2 . ' ORDER BY recipe_date';
        $msg   = '"投稿日が古い順"';
        break;
      case 3:
        // カロリー順(降順)同一カロリーがあった場合は上から出す。
        $sql1 = $sql1 . ' ORDER BY recipe_calorie DESC';
        $sql2 = $sql2 . ' ORDER BY recipe_calorie DESC';
        $msg   = '"カロリーが高い順"';
        break;
      case 4:
        // カロリー順(昇順)同一カロリーがあった場合は上から出す。
        $sql1 = $sql1 . ' ORDER BY recipe_calorie';
        $sql2 = $sql2 . ' ORDER BY recipe_calorie';
        $msg   = '"カロリーが低い順"';
        break;
        // case '5':
        //   // 評価順(降順)同一評価点があった場合は上から出す。
        //   $sql3 = $sql1 . ' ORDER BY recipe_rate DESC';
        //   break;
        // case '6':
        //   // 評価順(昇順)同一評価点があった場合は上から出す。
        //   $sql3 = $sql1 . ' ORDER BY recipe_rate';
        //   break;
    }
  }

  // memo:↓画面表示のための実行文？
  // SQLを実行
  // OKの場合⇒変数$resultSetにテーブル情報を代入
  // NGの場合⇒falseを返して、「mysqli_error」でエラーを返す。
  $resultSet1 = mysqli_query($dbobj, $sql1) or die(mysqli_error($dbobj));
  $resultSet2 = mysqli_query($dbobj, $sql2) or die(mysqli_error($dbobj));

  // 件数をカウント
  // memo:↓ ">num_rows;"はmysqli_resultクラスのメソッド
  // memo: mysqli_query()関数は値として mysqli_resultオブジェクト を返すらしい
  $rescount = $resultSet2->num_rows;

  //レコード件数(取得件数)表示
  $bl = mysqli_affected_rows($dbobj); //実行した件数を代入
?>
<!-- PHP終了 -->

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
  <link rel="stylesheet" href="./asset/css/style.css">
  <link rel="stylesheet" href="./asset/css/jquery.rateyo.css">
  <link rel="icon" href="./asset/img/logo/tree.ico">
  <title>検索結果</title>
</head>

<body class="Result_body">
  <?php if ($debug) : ?>
    <div class="debug">
      <p>デバッグ用</p>
      <p>$sql1: <?php print $sql1; ?></p>
      <p>$sql2: <?php print $sql2; ?></p>
    </div>
  <?php endif; ?>

  <header>
    <?php
      require_once ( __DIR__ . '/_parts/header.html');
    ?>
  </header>

  <main class="main">
    <div class="column_main sp_pd">
      <header class="line_title page">
        <!-- memo:↓ 検索結果のタイトル -->
        <h1 class="msg">
          <?php echo $msg ?>の検索結果一覧
        </h1>
        <!-- <p class="page"><span class="ff_en">   </span>ページ</p> -->
        <!-- memo:↓レコード件数(取得件数)表示 -->
          <?php echo $bl ?>   
      </header>
    </div>
    <!-- 検索結果表示 -->
    <div class="articles_totals">

      <p class="Result_p total ff_en" name="con">
        <span>
          <?php
          // memo:↓件数表示
          echo $rescount;
          ?>
        </span> recipe
        <div class="searchArea">
          <!-- <form action="result.php?Search=<?php echo $query; ?>" method="GET"> -->
          <form action="result.php" method="GET">
            <!-- memo:↓$queryは getで受け取った値12行目 -->
            <input type="hidden" name="Search" value="<?php echo $query; ?>" />
            <select class="Result_select1" name="select1">
              <option disabled selected value="">並び替え</option>
              <option value="0">指定なし</option>
              <option value="1">投稿日が新しい順</option>
              <option value="2">投稿日が古い順</option>
              <option value="3">カロリーが高い順</option>
              <option value="4">カロリーが低い順</option>
              <!-- <option value="5">評価点(降順)</option>
              <option value="6">評価点(昇順)</option> -->
            </select>
            <input type="image" src="./asset/img/search/black.png" width="30" height="30" alt="検索" value="検索する">
          </form>
        </div>
      </p>
    </div>

    <div class="articles_list ">
      <div class="main_bodyLeft">
        <?php
        $count = 00;
        $html = "";
        ?>
        <ul class='paginathing'>
          <?php
          while ($data = mysqli_fetch_assoc($resultSet1)) {
            if (!($count == $data['recipe_id'])) { // memo 'recipe_id' 00かどうかの判定
              $count = $data['recipe_id'];
              $html .= '<li class="mgzn"><a class="Result_a" href="detail.php?id=' . $data['recipe_id'] . '">';
              $html .= '<div class="mgzn1">';
              if ($count <= 9) {
                $html .= '<p class="ph"><span class="Result_span"><img class="Result_img" src="./asset/img/recipe0' . $count . '.jpg" alt=""></span></p>';
              } else if ($count >= 10) {
                $html .= '<p class="ph"><span class="Result_span"><img class="Result_img" src="./asset/img/recipe' . $count . '.jpg" alt=""></span></p>';
              }
              $html .= '</div>';
              $html .= '<div class="mgzn2">';
              // memo: ↓SQL文コメントの星の数で並び替える用？
              $sql4 = 'SELECT recipe_id, com_recipeid, AVG(com_rate) AS avg
                FROM recipe_tbl LEFT JOIN comment_tbl
                ON recipe_tbl.recipe_id=comment_tbl.com_recipeid
                WHERE recipe_id=' . $data['recipe_id'] .
                    ' GROUP BY recipe_id';
              $rankingSet = mysqli_query($dbobj, $sql4) or die(mysqli_error($dbobj));
              $ranking = mysqli_fetch_assoc($rankingSet);
              $ranknum = h($ranking['avg'] );

              if ($ranknum > 0) {
                $html .=  ' <div class="Result_star star" data-rateyo-rating="' . h($ranking['avg']) .
                  '">' .
                  '</div>';
              } else {
                $ranknum = 0;
                $html .=  ' <div class="Result_star star" data-rateyo-rating="' . $ranknum .
                  '">' .
                  '</div>';
              }
              $html .= '<div class="title">' . $data['recipe_title'] . '</div>';
              $html .= '<div class="kcal">' . '<div class="mgzn">' . $data['recipe_calorie'] . 'kcal' . '</div>' . '</div>';
              $html .= '<time class=" ff_en time">' . $data['recipe_date'] . '</time>';
            }
            $html .= '<div class="theme_bg">' . $data['tag_name'] . '</div>';
          }
          // $_SESSION['con'] = $con;
          // $con = $_SESSION['con'];
          // 最後のデータが出力されたら、</li>をつける
          $html .= '</a>';
          $html .= '</li>';
          ?>
          <?php echo $html; ?>
          <?php if ($debug) : ?>
            <div class="debug">
              <p>デバッグ用</p>
              <p>debug: <?php print $query; ?></p>
            </div>
          <?php endif; ?>
        </ul>
      </div>

      <!-- <div class=" pagenavi">
      <div class='wp-pagenavi' role='navigation'>
      <?php
        // 取得件数/1ページ単位の件数(1ページ5件とする)
        $page = ceil($rescount / $num_page);
        //  1ページ
        for ($i = 1; $i <= $page; $i++) {
          echo "<span aria-current='page' class='current'>";
          echo "<a href='result.php?page=" . $i . "'>" . $i . "</a>";
          echo "</span>";
        }
      ?> -->
    </div>
    <!-- <a class="page larger" title="Page 3" href="https://tarzanweb.jp/page/3/?s=%E3%83%98%E3%83%AB%E3%82%B7%E3%83%BC">3</a><span class='extend'>...</span><a class="nextpostslink" rel="next" aria-label="次のページ" href="https://tarzanweb.jp/page/2/?s=%E3%83%98%E3%83%AB%E3%82%B7%E3%83%BC">Next</a><a class="last" aria-label="Last Page" href="https://tarzanweb.jp/page/8/?s=%E3%83%98%E3%83%AB%E3%82%B7%E3%83%BC">8</a> -->
    <!-- </div>
    </div> -->
  </main>


  </div>

  <footer>
    <?php
      require_once(__DIR__ . '/_parts/footer.php');
    ?>
  </footer>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/common.js"></script>
  <script src="js/googlefonts.js"></script>
  <script src="js/index.js"></script>
  <script src="js/comment.js"></script>
  <script src="js/index.js"></script>
  <script src="js/jquery.rateyo.min.js"></script>
  <script src="js/rateyo.js"></script>
  <script src="js/paginathing.min.js"></script>

  <script>
    $(function() {
      $('.paginathing').paginathing({ //親要素のclassを記述
        perPage: 5, //1ページあたりの表示件数
        // prevText: '前へ', //1つ前のページへ移動するボタンのテキスト
        // nextText: '次へ', //1つ次のページへ移動するボタンのテキスト
        activeClass: 'navi-active', //現在のページ番号に任意のclassを付与できます
      })
    });
  </script>

</body>
</html>
