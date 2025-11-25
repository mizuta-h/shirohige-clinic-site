<?php

/**
 * RIBON 連携用
 * クリニックサイト全体で用いる定数を定義します
 */

/**
 * @var string クリニックの ID（Kintone の uuid を参照してください）
 */
define('RIBON_UUID', null);

/**
 * @var string RIBON API URL
 */
define('RIBON_API_URL', 'https://api.ribon-job.com/');

/**
 * @var 'ok'|'ng'|null API レスポンスをシミュレーションするかどうか
 *
 * - null => ダミーレスポンスは返さず、 API に問い合わせた結果を使います。
 * - 'ok' => 常にリンクデータ取得 OK 状態になります（RIBON へのリンクが表示されるようになります）。
 * - 'ng' => 常にリンクデータ取得 NG 状態になります（RIBON へのリンクが表示されません）。
 */
define('RIBON_FIXED_RESPONSE', null);
