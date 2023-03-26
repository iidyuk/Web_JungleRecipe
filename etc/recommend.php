<?php
require_once __DIR__ . '/functions.php';
$dbobj = connectTarzan();

// ↓ Tag用ロジック
$sql_tag = 'SELECT * FROM recipe_tbl
LEFT JOIN recipetag_tbl ON recipe_id = rtag_recipeid
LEFT JOIN mgzn_tbl ON rtag_recipeid = mgzn_tagid
LEFT JOIN tag_tbl ON mgzn_tagid=tag_id
WHERE recipe_id =' . $_SESSION['id'];
$tagSet = mysqli_query($dbobj, $sql_tag) or die(mysqli_error($dbobj));
$tag = mysqli_fetch_assoc($tagSet);

// ↓ BACKNUMBER用ロジック
$sql_backnumber = 'SELECT * FROM recipe_tbl
LEFT JOIN recipetag_tbl ON recipe_id = rtag_recipeid
LEFT JOIN mgzn_tbl ON rtag_recipeid = mgzn_tagid
LEFT JOIN tag_tbl ON mgzn_tagid=tag_id
WHERE rtag_recipeid=' . $_SESSION['id'] .
  ' GROUP BY mgzn_id ORDER BY mgzn_release DESC LIMIT 3;';
$backnumSet = mysqli_query($dbobj, $sql_backnumber) or die(mysqli_error($dbobj));

?>

    <div class="Recommend_Content">
      <div class="Recommend_header">
        <h2 class="Recommend_title">RECOMMEND</h2>
        <p class="Recommend_subtitle">おすすめ</p>
        <p class="Recommend_tag"><span class="Recommend_tagspan">
            <?php echo h($tag['tag_name']); ?></span>に</p>
        <p class="Recommend_text">興味がある方におすすめ</p>
      </div>
      <div class="Recommend_inner">
        <?php while ($data = mysqli_fetch_assoc($backnumSet)) : ?>
          <a class="Recommend_link" href="<?php echo h($data['mgzn_url']); ?>">
            <div class="Recommend_item">
              <!-- ↓マガジン号数 -->
              <div class="Recomend_itemTitle">
                <div class="Recommend_issue">No.<?php echo h($data['mgzn_issueid']); ?></div>
                <!-- ↓マガジン発売日 -->
                <div class="Recommend_release"><?php echo strtr(h($data['mgzn_release']), "-", "/"); ?></div>
                <!-- <a href="<?php echo h($data['mgzn_url']); ?>"></a> -->
              </div>
              <!-- ↓マガジンイメージ -->
              <div class="Recommend_img">
                <img src="img/<?php echo h($data['mgzn_img']); ?>.jpg" alt="">
              </div>
              <!-- ↓マガジン用タグ -->
              <div class="Recommend_mgzTitle"><?php echo h($data['mgzn_title']); ?>
                <!-- <?php
                      $mgzn_tagid = h($data['mgzn_tagid']);
                      $sql_tagid = 'SELECT * FROM tag_tbl WHERE tag_id IN(' . $mgzn_tagid . ');';
                      $tagidSet = mysqli_query($dbobj, $sql_tagid) or die(mysqli_error($dbobj));
                      ?> -->
                <!-- <?php while ($data_tagid = mysqli_fetch_assoc($tagidSet)) : ?>
                  <p><?php echo h($data_tagid['tag_name']); ?></p>
                <?php endwhile; ?> -->
              </div>
              <!-- ↓マガジンプライス -->
              <div class="Recommend_price"><?php echo h($data['mgzn_price']); ?>円（税込）</div>
            </div>
          </a>
        <?php endwhile; ?>
      </div>
      <div class="Recommend_backnumber">
        <p><a class="Recommend_backnumberLink" href="https://magazineworld.jp/tarzan/back/">BACK NUMBER ></a></p>
      </div>
    </div>

