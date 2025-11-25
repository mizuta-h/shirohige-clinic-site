<?php

header('content-type: application/json; charset=utf-8');

require_once '../config/env.php';

//クリニックのドメインをJSONにて出力
$website = array('clinic_url' => WEBSITE_URL);
echo json_encode($website, JSON_UNESCAPED_UNICODE);
