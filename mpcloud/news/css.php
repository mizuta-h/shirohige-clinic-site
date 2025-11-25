<?php

require_once '../functions/curl.php';
// お知らせ JSON を API で取得する
$news_list = (new CurlAccess())->getDataViaApi('news')->getData();
$news_list_cnt = count($news_list);
$unique_array = array();
header('Content-type: text/css');
?>

<?php foreach($news_list as $key => $row): ?>
<?php if(!in_array($row['news_category_css']['category_class'], $unique_array)): ?>
em.<?= $row['news_category_css']['category_class']; ?> {
background-color: <?= $row['news_category_css']['news_category_color']; ?>;
color: <?= $row['news_category_css']['news_category_txt_color']; ?>;
}
<?php array_push($unique_array,$row['news_category_css']['category_class']); ?>
<?php endif; ?>
<?php endforeach; ?>
