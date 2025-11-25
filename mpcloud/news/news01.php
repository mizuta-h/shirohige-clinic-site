<?php //タイトル・リンクバージョン ?>
<?php 
require_once '../functions/curl.php';
// お知らせ JSON を API で取得する
$news_list = (new CurlAccess())->getDataViaApi('news')->getData();
?>
<?php if(!empty($news_list)){ ?>
    <ol>
        <?php foreach ($news_list as $key => $row){ ?>
        <?php
//表示件数を1件にしたいときは、if($key > 0){break;}、2件にしたいときは、if($key > 1){break;}、3件にしたいときは、if($key > 2){break;}をこの行に追記してください。数値を変えると表示件数が変わります。
            if($key > 4){break;}
            $news_date = str_replace('-', '.', $row['news_date']);
            $category_class = $row['news_category_css']['category_class'];
            $category_name = $row['news_category_css']['news_category_name'];
            $news_title = $row['news_title'];
        ?>
        <li><a href="./news.html#news<?= $key; ?>"><span><?= $news_date; ?></span><?php if ($category_name) { ?><em class="<?= $category_class; ?>"><?= $category_name; ?></em><?php } ?><strong><?= $news_title; ?></strong></a></li>
        <?php } ?>
    </ol>
<?php } else { ?>
    <ol>
        <li>現在、お知らせはありません。</li>
    </ol>
<?php } ?>