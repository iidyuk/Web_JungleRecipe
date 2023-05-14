<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link type="image/vnd.microsoft.icon" sizes="96x96" rel="icon" href="./asset/img/logo/tree.ico">
  <title>Behave｜Jungle Recipe</title>
  <!-- ↓リセットCSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@3.0.0/destyle.css">
  <!-- ↓slickのJQ&CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">

  <!-- 共通CSS -->
  <link rel="stylesheet" href="./asset/css/style.css">
  <!-- rateyoのCSS -->
  <link rel="stylesheet" href="./asset/css/jquery.rateyo.css">
</head>

<?php
  $debug = false;
  require_once __DIR__ . '/_function/functions.php';
  // require_once 'functions.php';

  $dbobj = connectTarzan();

  // ↓ SEARCHのTag用ロジック
  $sql_searchTag = 'SELECT * FROM tag_tbl';
  $tagSet = mysqli_query($dbobj, $sql_searchTag) or die(mysqli_error($dbobj));

  // ↓ RANKING用ロジック
  $limit = ' LIMIT ' . 10; // limit11以上の場合エラー発生 (22.3.1時点)
  $sql_ranking =
    'SELECT recipe_id, recipe_title, recipe_img, com_recipeid, AVG(com_rate)
    FROM recipe_tbl LEFT JOIN comment_tbl ON recipe_tbl.recipe_id=comment_tbl.com_recipeid
    GROUP BY com_recipeid ORDER BY AVG(com_rate) DESC' . $limit;
  $rankingSet = mysqli_query($dbobj, $sql_ranking) or die(mysqli_error($dbobj));
  $num = 0;

  // ↓ NEW用ロジック
  $new_arrivalWhet = 24; //NEWに表示するレシピ投稿日の設定
  $sql_new = 'SELECT * FROM recipe_tbl WHERE recipe_date > ( NOW( ) - INTERVAL ' . $new_arrivalWhet . ' MONTH);';
  $newSet = mysqli_query($dbobj, $sql_new) or die(mysqli_error($dbobj));

  // ↓ BACKNUMBER用ロジック
  $sql_backnumber = 'SELECT * FROM mgzn_tbl WHERE mgzn_release!=(select max(mgzn_release) from mgzn_tbl) ORDER BY mgzn_release DESC LIMIT 4;';
  $backnumSet = mysqli_query($dbobj, $sql_backnumber) or die(mysqli_error($dbobj));
?>
<?php
  require_once (__DIR__ . '/_function/magazine.php');
?>

<body class="Index_body">
  <?php if ($debug) : ?>
    <div class="Debug" style="position:fixed; top:0; padding:10px 30px; background-color:#29d586cc; border:solid 10px #6e85525c; border-radius:10px; color:#2c724f;">
      <p>デバッグ用</p>
      <p>$sql_searchTag : <?php print $sql_searchTag; ?></p>
      <p><?php v($tagSet ); ?></p>
      <p>スクロール位置：<span id="scroll-amount">0px</span></p>
    </div>
  <?php endif; ?>

  <div id="loading">
  </div>

  <!-- ↓↓header -->
  <?php
  require_once __DIR__ . '/_parts/header.html';
  ?>
  <!-- ↑↑header -->

  <!-- ↓↓SEARCH -->
  <div class="Search">
    <div class="Search_inner">

      <div class="Search_title">
        <div class="Search_titleBox">
          <h2>SEARCH</h2>
          <p>レシピ検索</p>
        </div>
      </div>

      <!-- ↓SEARCHの検索フォーム -->
      <div class="Search_form">
        <div class="Search_formBox">
          <form class="Search_formArea" action="./result.php" method="get">
            <select class="Search_formSelect" name="Search" id="">
              <!-- <option value="">カロリーから探す</option> -->
              <option hidden value="">カロリーから探す</option>
              <option value="0">指定なし</option>
              <option value="1">200kcal未満</option>
              <option value="2">200～400kcal未満</option>
              <option value="3">400kcal以上</option>
            </select>
            <div class="Search_formBtn">
              <input type="image" name="submit" src="./asset/img/search/black.png" alt=" 送信" class="black Search_formBtnSubmit" onclick="goClick()" width="60">
            </div>
          </form>
        </div>
      </div>
      <!-- ↑SEARCHの検索フォーム -->

      <!-- ↓SEARCHのTag -->
      <?php $searchTag = false; ?>
      <?php if ($searchTag) : ?>
        <div class="Search_tagBox">
          <?php while ($data = mysqli_fetch_assoc($tagSet)) : ?>
            <div class="Search_tag">
              <?php echo h($data['tag_name']); ?>
            </div>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>
      <!-- ↑SEARCHのTag -->

    </div> <!-- "Search_inner"の終了タグ -->
  </div> <!-- "Search"の終了タグ -->
  <!-- ↑↑SEARCH -->

  <!-- ↓↓SNSボタン(左サイド) -->
  <?php
  require_once __DIR__ . '/_parts/bar_left.html';
  ?>
  <!-- ↑↑SNSボタン(左サイド) -->

  <!-- ↓↓RANKING -->
  <div class="Ranking">
    <div class="Ranking_inner">
      <div class="Ranking_titleBox">
        <h1>RANKING</h1>
        <p>評価ランキング</p>
      </div>
      <div class="Ranking_container">
        <!-- ↓slick用 クラス名変更不可 -->
        <div class="Ranking_slider">

          <!-- ランキング順位用 -->
          <?php
          $rankingVal = 1;
          ?>
          <?php while ($data = mysqli_fetch_assoc($rankingSet)) : ?>
            <div class="Ranking_sliderSlick">
              <!-- ↓Rankingレシピ写真 -->

              <div class="Ranking_sliderInner">
                <a href="detail.php?id=<?php echo h($data['recipe_id']); ?>">
                  <div class="Ranking_sliderImage">
                    <img class="Ranking_sliderImage_Img" src="./asset/img/<?php echo h($data['recipe_img']); ?>.jpg" alt="">

                  </div>
                  <div class="Ranking_sliderCaption">
                    <!-- ↓Ranking順位 (10の位まで対応)-->
                    <div class="Ranking_sliderRank">
                      <?php
                      ++$num;
                      if ($num < 10) :
                      ?>
                        <div class="Ranking_sliderRank_CharOnes"><?php echo $num  ?></div>
                      <?php elseif ($num >= 10) : ?>
                        <div class="Ranking_sliderRank_Char10th"><?php echo $num; ?></div>
                      <?php endif; ?>
                    </div>
                    <!-- ↓Rankingレシピタイトル -->
                    <div class="Ranking_sliderTitle">
                      <?php echo h($data['recipe_title']); ?>
                    </div>
                    <!-- ↓Rankingレシピレート -->
                    <div class="Ranking_sliderRate">
                      <!-- ↓Rankingレシピレートの星 -->
                      <div class="Ranking_sliderRateStar" style="color:black;">
                        <div class="star" data-rateyo-rating="<?php echo h($data['AVG(com_rate)']); ?>"></div>
                      </div>
                      <!-- ↓Rankingレシピレートの数値 -->
                      <div class="Ranking_sliderRate_Val">
                        <?php echo sprintf('%.1f', h($data['AVG(com_rate)'])); ?>
                      </div>
                    </div>
                  </div> <!-- Ranking_sliderCaption終了 -->
                </a>
              </div> <!-- Ranking_sliderInner終了 -->
              <?php
              $sql_recipeTag = 'SELECT * FROM recipetag_tbl LEFT JOIN tag_tbl ON recipetag_tbl.rtag_tagid=tag_tbl.tag_id';
              $recipeTagSet = mysqli_query($dbobj, $sql_recipeTag) or die(mysqli_error($dbobj));
              ?>
              <!-- ↓レシピタグ -->
              <div class="Ranking_sliderRecipeTag">
                <?php while ($data_recipeTag = mysqli_fetch_assoc($recipeTagSet)) : ?>
                  <?php if ($data['recipe_id'] == $data_recipeTag['rtag_recipeid']) : ?>
                    <p>
                      <?php echo h($data_recipeTag['tag_name']); ?>
                    </p>
                  <?php endif; ?>
                <?php endwhile; ?>
              </div>
            </div>
          <?php endwhile; ?>
        </div> <!-- Ranking_slider終了 -->
      </div> <!-- Ranking_container終了 -->
    </div> <!-- Ranking_inner終了 -->
  </div> <!-- Ranking終了 -->
  <!-- ↑↑RANKING -->

  <!-- ↓↓NEW -->
  <div class="New">
    <div class="New_inner">
      <div class="New_titleBox">
        <h2>NEW</h2>
        <p>新着のレシピ</p>
      </div>

      <!-- <div class="New_contentsBox"> -->
      <div class="New_container">
        <!-- New ↓slick用 クラス名変更不可 -->
        <div class="New_slider">
          <?php while ($data = mysqli_fetch_assoc($newSet)) : ?>
            <div class="New_sliderSlick">
              <div class="New_sliderInner">
                <a href="detail.php?id=<?php echo h($data['recipe_id']); ?>">
                  <div class="New_sliderImage">
                    <img src="./asset/img/<?php echo h($data['recipe_img']); ?>.jpg" alt="">
                  </div>
                  <div class="New_sliderTitle">
                    <?php echo h($data['recipe_title']); ?>
                  </div>
                </a>
              </div>
              <!-- ↓レシピタグ -->
              <?php
              $sql_recipeTag = 'SELECT * FROM recipetag_tbl LEFT JOIN tag_tbl ON recipetag_tbl.rtag_tagid=tag_tbl.tag_id';
              $recipeTagSet = mysqli_query($dbobj, $sql_recipeTag) or die(mysqli_error($dbobj));
              ?>
              <div class="New_sliderRecipeTag">
                <?php while ($data_recipeTag = mysqli_fetch_assoc($recipeTagSet)) : ?>
                  <?php if ($data['recipe_id'] == $data_recipeTag['rtag_recipeid']) : ?>
                    <p>
                      <?php echo h($data_recipeTag['tag_name']); ?>
                    </p>
                  <?php endif; ?>
                <?php endwhile; ?>
              </div>
            </div> <!-- New_sliderSlick終了 -->
          <?php endwhile; ?>
        </div>
      </div>
      <!-- </div> -->
    </div>
  </div>
  <!-- ↑↑NEW -->

  <!-- ↓↓BACK NUMBER -->
  <div class="Backnumber">
    <div class="Backnumber_inner">
      <div class="Backnumber_titleBox">
        <h2>BACK NUMBER</h2>
        <p>旧刊</p>
      </div>

      <div class="Backnumber_contentsBox">
        <div class="Backnumber_viewAll">
          <p><a class="Backnumber_viewAllLink" >VIEW ALL</a></p>
        </div>
        <div class="Backnumber_contentsBoxInner">
          <?php $repeatVal = 0; ?>
          <?php while ($data = mysqli_fetch_assoc($backnumSet)) : ?>
            <a class="Backnumber_link" href="">
              <div class="Backnumber_itemBox">
                <div class="Backnumber_itemBoxInner">
                  <!-- ↓マガジン号数 -->
                  <div class="Backnumber_issue">No.<?php echo h($data['mgzn_issueid']); ?></div>
                  <!-- ↓マガジン発売日 -->
                  <div class="Backnumber_release">
                    <?php
                    // echo strtr(h($data['mgzn_release']), "-", "/");
                    echo $bNReleaseDay[$repeatVal];
                    $repeatVal = $repeatVal + 1;
                    ?>
                  </div>
                  <a href="
                    <?php
                    // echo h($data['mgzn_url']);
                    ?>">
                  </a>
                  <!-- ↓マガジンイメージ -->
                  <div class="Backnumber_image">
                    <img src="./asset/img/<?php echo h($data['mgzn_img']); ?>.jpg" alt="">
                  </div>
                  <!-- ↓マガジン用タグ -->
                  <div class="Backnumber_tag">
                    <?php
                    $mgzn_tagid = h($data['mgzn_tagid']);
                    $sql_tagid = 'SELECT * FROM tag_tbl WHERE tag_id IN(' . $mgzn_tagid . ');';
                    $tagidSet = mysqli_query($dbobj, $sql_tagid) or die(mysqli_error($dbobj));
                    ?>
                    <?php while ($data_tagid = mysqli_fetch_assoc($tagidSet)) : ?>
                      <p><?php echo h($data_tagid['tag_name']); ?></p>
                    <?php endwhile; ?>
                  </div>
                  <!-- ↓マガジンプライス -->
                  <div class="Backnumber_price"><?php echo h($data['mgzn_price']); ?>円（税込）</div>
                </div>
              </div>
            </a>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
  <!-- ↑↑BACK NUMBER -->

  <!-- ↓↓Topへ戻るボタン -->
  <?php
    require_once __DIR__ . '/_parts/btn_top.html';
  ?>
  <!-- ↑↑Topへ戻るボタン -->

  <!-- ↓↓footer -->
  <?php
    require_once __DIR__ . '/_parts/footer.php';
  ?>
  <!-- ↑↑footer -->


  <!-- ↓jQuery -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  
  <!-- rateyoのJavaScript -->
  <script src="asset/js/jquery.rateyo.min.js"></script>
  
  <!-- ↓slickのJavaScript -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  
  <!-- ↓scriptのJavaScript  -->
  <script src="asset/js/btn_top.js"></script>
  <script src="asset/js/bar_left.js"></script>
  <script src="asset/js/index.js"></script>

  <!-- <script>
    // 
    // ↓↓ Loading animation ↓↓

    // ↓Firstvisit の設定
    window.addEventListener('load', function() {
      const loading = document.querySelector('#loading');
      const firstVisit = localStorage.getItem('firstVisit');
      if (!firstVisit) {
        // 初回のアクセス時のみローディングアニメーションを表示
        localStorage.setItem('firstVisit', 'true');
        loading.classList.add('loaded');
      } else {
        // 二回目以降はローディングアニメーションを非表示にする
        loading.style.display = 'none';
      }
    });

    // ↓アニメーションが終わったら#splashエリアをフェードアウト
    $("#loading").delay(250).fadeOut(250);

    // ↑↑ Loading animation ↑↑
    // 


    // ↓ rateYo
    $('.star').rateYo({
      precision: 1,
      readOnly: true,
      starWidth: "20px",
      normalFill: "#A0A0A0",
      ratedFill: "#F39C12"
    });
    // ↑ rateYo

    // ↓ slick 'Ranking_slider'
    $(function() {
      $('.Ranking_slider').slick({
        autoplay: true, // 自動再生ON OFF
        infinite: true,
        dots: false, // ドットインジケーターON OFF
        centerMode: false, // 両サイドに前後のスライド表示
        centerPadding: '0px', // 左右のスライドのpadding
        slidesToShow: 4, // 一度に表示するスライド数
        autoplaySpeed: 4500, //隣あう画像のスライドするまでの間隔時間
        cssEase: 'linear', //開始から終了まで一定に変化する
        arrows: true, //スライド移動の矢印
        prevArrow: '<img src="./asset/img/btn/left.png" class="slide-arrow prev-arrow">',
        nextArrow: '<img src="./asset/img/btn/right.png" class="slide-arrow next-arrow">',
        responsive: [
          {
            breakpoint: 1280,
            settings: {
              slidesToShow: 3,
              infinite: true,
            }
          },
          {
            breakpoint: 640,
            settings: {
              slidesToShow: 2
            }
          }
        ]
      })

      $('.Ranking_slider').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        if(currentSlide === 0){
          $('[data-slick-index="-1"]', this).addClass('slide-trans');
        }
        if(nextSlide === 0){
          $('[data-slick-index="10"]', this).addClass('slide-trans');
        }
      });

      $('.Ranking_slider').on('afterChange', function(event, slick, currentSlide) {
        $('[data-slick-index="-1"]', this).removeClass('slide-trans');
        $('[data-slick-index="0"]', this).removeClass('slide-trans');
        $('[data-slick-index="8"]', this).removeClass('slide-trans');
        $('[data-slick-index="9"]', this).removeClass('slide-trans');
        $('[data-slick-index="10"]', this).removeClass('slide-trans');
      });
    });
    // ↑ slick 'Ranking_slider'

    // ↓ slick 'New_slider'
    $(function() {
      let New_sliderOptions = {
        autoplay: false,
        dots: false,
        centerMode: false,
        centerPadding: '5px',
        slidesToShow: 5,
        arrows: true,
        adaptiveHeight: false,
        prevArrow: '<img src="./asset/img/btn/left.png" class="slide-arrow prev-arrow">',
        nextArrow: '<img src="./asset/img/btn/right.png" class="slide-arrow next-arrow">'
      };

      // load時の可変設定
      $(window).on('load', function() {
        if ($(window).width() <= 1280) {
          $('.New_slider').slick('unslick');
        } else {
          $('.New_slider').slick(New_sliderOptions);
        }
      });

      // resize時の可変設定
      $(window).resize(function() {
        if (window.matchMedia('(max-width: 1280px)').matches) {
          $('.New_slider').slick('unslick');
        } else {
          $('.New_slider').slick(New_sliderOptions);
        }
      });

      $('.New_slider').slick(New_sliderOptions);
    });
    // ↑ slick 'New_slider'

    // debug用
    $(window).scroll(function() {
      $('#scroll-amount').text($(this).scrollTop() + 'px');
    });

  </script> -->





</body>

</html>
