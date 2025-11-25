<?php

// curl アクセス用クラスを読み込む
require_once '../functions/curl.php';

date_default_timezone_set('Asia/Tokyo');

//====================
// 祝日データ取得
//====================

// holiyday.jsonのはじめの年を取得
function get_first_key($array)
{
    reset($array);
    return key($array);
}

$first_holiday_year = 0;

// 祝日一覧
$json = file_get_contents("holiyday.json");
$json = mb_convert_encoding($json, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$holidays = json_decode($json, true);

if (is_array($holidays)) {
    $first_holiday_date = get_first_key($holidays);
    $ref = strtotime($first_holiday_date);
    $first_holiday_year = date("Y", $ref);
}

// 祝日JSONが古い場合は最新を取得（年替わり）
if (date('Y') <> $first_holiday_year + 1) {
    $holiday_json = file_get_contents("https://holidays-jp.github.io/api/v1/date.json"); // 祝日一覧API
    $holiday_json = mb_convert_encoding($holiday_json, 'UTF-8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
    $holidays = json_decode($holiday_json, true);
    file_put_contents('holiyday.json', $holiday_json);
}

//====================
// 当日診療時間・コメント取得
//====================

// 診療時間 JSON を API で取得する
$curlAccess = (new CurlAccess())->getDataViaApi('schedules');
$httpStatusCode = $curlAccess->getStatusCode();
$schedules = $curlAccess->getData();

if (empty($schedules) || $httpStatusCode !== 200) {
    // 取得エラー時は診療時間表示を消す
    $display_hours = false;
// TODO: ログ出力？
} else {

    //JSONデータ分割
    $schedule_disp_switch = $schedules['schedule_disp_switch']; // 表示設定
    $schedule_week = $schedules['schedule_week']; // 曜日別診療日時
    $schedule_extra = $schedules['schedule_extra']; // 臨時診療日
    $schedule_comment = $schedules['schedule_comment']; // コメント
    $schedule_message = $schedules['schedule_message']; // 表示メッセージ

    //診療状況表示の表示種別
    $display_hours = $schedule_disp_switch['hours']; //当日診療状況表示 false:非表示　true:表示
    $display_comment = $schedule_disp_switch['comment']; //コメント false:非表示　true:表示

    // 本日の曜日
    $date_time = new DateTime();
    $week = array("日", "月", "火", "水", "木", "金", "土");
    $w = (int)$date_time->format('w');

    switch ($week[$w]) {
        case "日": $today_type = "schedule_sun"; break;
        case "月": $today_type = "schedule_mon"; break;
        case "火": $today_type = "schedule_tue"; break;
        case "水": $today_type = "schedule_wed"; break;
        case "木": $today_type = "schedule_thu"; break;
        case "金": $today_type = "schedule_fri"; break;
        case "土": $today_type = "schedule_sat"; break;
    }

    $today_date = date("Y/m/d"); // 今日の日付
    $today = date("Y-m-d"); // 祝日検索用
    //$current_time = date("H:i"); // 現時刻
    //$current_flg = 0; //診療時間内外フラグ 0:時間外 1:時間内
    $extra_type = null; //臨時フラグ

    // 今日が祝日かどうか
    if (array_key_exists($today, $holidays)) {
        $today_type = "schedule_pub";
    }

    //本日の曜日の診療情報
    $schedule_format = $schedules['schedule_week'][$today_type]; //本日の診療曜日
    $schedule_status = $schedule_format['status']; //診休みステータス　open:診療日 close:休診日
    $schedule_times = $schedule_format['times']; //診療内容・時間
    $status_message = '';

    //====================
    // 診療時間内外判定
    //====================
    function schedule_time_range($schedule_times, $schedule_message)
    {
        $current_time = date("H:i"); // 現時刻

        // 診療時間内かどうか判断
        foreach ((array)$schedule_times as $row) {
            $title = $row['title'];
            $from = $row['from'];
            $to = $row['to'];

            //現時刻の範囲ないかどうか
            if (strtotime($from) < strtotime($current_time) && strtotime($current_time) < strtotime($to)) {
                //診療時間内メッセージ
                $status_message = $schedule_message['schedule_message_open'];
                break;
            } else {
                //診療時間外メッセージ
                $status_message = $schedule_message['schedule_message_close'];
            }
        }
        return $status_message;
    }


    //====================
    // 今日が臨時診休日に該当判定処理
    //====================

    foreach ((array)$schedule_extra as $row) {
        if ($today == $row['schedule_extra_date']) {
            //臨時診休のどちらか 　0:臨時休診　1:臨時診療
            $extra_type = $row['schedule_extra_status'];
            //休診日の場合
            if ($extra_type=='0') {
                //臨時休診メッセージ
                $status_message = $schedule_message['schedule_message_extra_close'];
                $schedule_times = array();
            } elseif ($extra_type=='1') {
                $schedule_status='open';
                //今日の診療時間内容
                $schedule_times = $row['schedule_extra_times'];
                $status_message = schedule_time_range($schedule_times, $schedule_message);
            }
        }
    }

    //====================
    // 本日の診療日情報
    //====================

    //臨時休診ではない場合
    if (is_null($extra_type)) {
        if ($schedule_status=='open') {
            $status_message = schedule_time_range($schedule_times, $schedule_message);
        } elseif ($schedule_status=='close') {
            //休診日メッセージ
            $status_message = $schedule_message['schedule_message_closeday'];
            $schedule_times = array();
        }
    }
}
