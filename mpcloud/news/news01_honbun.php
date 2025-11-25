<?php //タイトル・リンクバージョン ?>
<?php 
require_once '../functions/curl.php';
// お知らせ JSON を API で取得する
$news_list = (new CurlAccess())->getDataViaApi('news')->getData();
?>
<?php if(!empty($news_list)){ ?>
    <ul class="news_list">
        <?php foreach ($news_list as $key => $row){ ?>
        <?php
//表示件数を1件にしたいときは、if($key > 0){break;}、2件にしたいときは、if($key > 1){break;}、3件にしたいときは、if($key > 2){break;}をこの行に追記してください。数値を変えると表示件数が変わります。
            $news_date = str_replace('-', '.', $row['news_date']);
            $category_class = $row['news_category_css']['category_class'];
            $category_name = $row['news_category_css']['news_category_name'];
            $news_title = $row['news_title'];
            $news_comment = $row['news_comment'];
        ?>
        <li><span><?= $news_date; ?></span><?php if ($category_name) { ?><em class="<?= $category_class; ?>"><?= $category_name; ?></em><?php } ?><?= $news_title; ?><p><?= nl2br($news_comment); ?></p></li>
        <?php } ?>
    </ul>
<?php } else { ?>
    <ul class="news_list">
        <li>現在、お知らせはありません。</li>
    </ul>
<?php } ?>
<!--
<script>
$(function() { 
    $(".scroll_area").mCustomScrollbar({ 
        axis:"yx",
        theme:"rounded-dark",
        scrollButtons:{ enable:true } 
    }); 
});
</script>
-->
