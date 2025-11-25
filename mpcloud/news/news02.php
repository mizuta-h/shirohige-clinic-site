<?php // セパレートバージョン ?>
<?php 
require_once '../functions/curl.php';
// お知らせ JSON を API で取得する
$news_list = (new CurlAccess())->getDataViaApi('news')->getData();
?>
<?php if(!empty($news_list)){ ?>
    <dl class="news_text_list">
        <?php foreach($news_list as $key => $row){ ?>
        <?php 
            $news_date = str_replace('-','.', $row['news_date']);
            $category_class = $row['news_category_css']['category_class'];
            $category_name = $row['news_category_css']['news_category_name'];
            $news_title = $row['news_title'];
            $news_comment = $row['news_comment'];
        ?>
        <dt id="news<?= $key; ?>" class="anchor"><?= $news_title; ?></dt>
        <dd>
            <p><span><?= $news_date; ?></span><?php if(!empty($category_name)){ ?><em class="<?= $category_class; ?>"><?= $category_name; ?></em><?php } ?></p>
            <p><?= nl2br($news_comment); ?></p>
        </dd>
        <?php } ?>
    </dl>
<?php } else { ?>
<dl class="news_text_list">
    <dt>只今、お知らせはありません。</dt>
</dl>
<?php } ?>