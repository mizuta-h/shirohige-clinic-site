<?php
/**
 * RIBON 連携コアソース
 * 読み込まれると RIBON API にリンク先 URL を問い合わせます。
 *
 * ※ このファイルを編集する必要はありません。
 */
require_once 'config/env.php';

// シミュレーションの場合
if (in_array(RIBON_FIXED_RESPONSE, ['ok', 'ng'], true)) {
    if (RIBON_FIXED_RESPONSE === 'ok') {
        echo json_encode([
            'id' => 'hero-innovation',
            'url' => 'https://hero-innovation.com/',
            'title' => '株式会社ヒーローイノベーション',
        ]);
        return;
    } else {
        http_response_code(404);
        die();
    }
}

$curl = curl_init();
curl_setopt(
    $curl,
    CURLOPT_URL,
    RIBON_API_URL . 'v1/facilities/public/link?uuid=' . RIBON_UUID
);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
$httpcode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
curl_close($curl);

if (! empty($response) && $httpcode === 200) {
    // 200 OK && データが取得できたらデータを json で返す
    echo json_encode(json_decode($response, true));
    return;
}

// データが取れなければ 404 で返す
http_response_code(404);
die();
