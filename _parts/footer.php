<?php

  require_once (__DIR__ . '/../_function/functions.php');

  $dbobj = connectTarzan();

  $sql = 'SELECT * FROM mgzn_tbl ORDER BY mgzn_release DESC';
  $mgznSet = mysqli_query($dbobj, $sql) or die(mysqli_error($dbobj));
  $data = mysqli_fetch_assoc($mgznSet);

?>

<?php
  require_once (__DIR__ . '/../_function/magazine.php');
?>

<footer class="Footer">

  <div class="Footer_body1">

    <div class="Footer_box">

      <div class="Footer_mgzn">

        <div class="mgznBox1">
          <div class="mgr-20">
            <p>
              <font size="5"><b>最新号</b></font>
            </p>
            <p>毎月第2・4木曜日発売<br>1986年創刊</p>
          </div>

          <div class="mgr-20">
            <a href="">
              <img src="./asset/img/sns_icon/amazon.png" width="150" alt="amazon">
            </a>
          </div>

          <div class="mgr-20">
            <a href="">
              <img src="./asset/img/sns_icon/magazinehouse.png" width="170" alt="magazinehouse">
            </a>
          </div>
        </div>

        <div class="Mgzn_box2">
          <div class="Mgzn_box2Inner">
            <a href="" class="Mgzn_box2image">
              <p>
                <small>no</small><?php echo h($data['mgzn_issueid']) ?>
                <?php
                  $week = [
                    '日', //0
                    '月', //1
                    '火', //2
                    '水', //3
                    '木', //4
                    '金', //5
                    '土', //6
                  ];

                  // $mgzn_Rel = h($data['mgzn_release']);
                  $mgzn_Rel =  $makeReleaseDay; // magazine.phpで日付の値を作成
                  $dayOfWeek  = date('w', strtotime($mgzn_Rel));
                  $month = date('m', strtotime($mgzn_Rel));
                  $day = date('d', strtotime($mgzn_Rel));
                  echo $month . '.' . $day . '(' . $week[$dayOfWeek] . ')';
                ?>
                発売
              </p>
              <img src="./asset/img/<?php echo h($data['mgzn_img']); ?>.jpg" alt="最新号">
            </a>
          </div>
        </div>
      </div>

      <div class="Footer_sns">
        <a class="sns_link" href="">
          <img src="./asset/img/sns_icon/twitter.png" alt="Twitter" width="40">
        </a>

        <a class="sns_link" href="">
          <img src="./asset/img/sns_icon/instagram.png" alt="instagram" width="40">
        </a>

        <a class="sns_link" href="">
          <img src="./asset/img/sns_icon/facebook.png" alt="facebook" width="40">
        </a>

        <a class="sns_link" href="">
          <img src="./asset/img/sns_icon/line.png" alt="line" width="40">
        </a>

        <a class="sns_link" href="">
          <img src="./asset/img/sns_icon/youtube.png" alt="youtube" width="40">
        </a>
      </div>

      <div class="Footer_logo">
        <a class="Logo_link" href="index.php">
          <img src="./asset/img/logo/logo.png" alt="Tarzan Jungle Recipe" width="500">
        </a>
      </div>

      <nav class="NavPC">
        <ul class="NavPC_listF">
          <li class="NavPC_item">
            <a href="result.php?Search=0" class="NavPC_link">Recipe</a>
          </li>
          <li class="NavPC_item">
            <a href="" class="NavPC_link">Magazines</a>
          </li>
          <li class="NavPC_item">
            <a href="" class="NavPC_link">About Tarzan</a>
          </li>
        </ul>
      </nav>


    </div>
  </div>

  <div class="Footer_body2">
    <div class="Footer_box2">
      <div class="Footer_item">
        <ul>
          <li><a href="" >運営会社</a></li>
          <li><a href="" >プライバシーポリシー</a></li>
        </ul>
      </div>
      <div class="Footer_copyright">
        &copy;2021-2023 
      </div>
    </div>
  </div>

</footer>
