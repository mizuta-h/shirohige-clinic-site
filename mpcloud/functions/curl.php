<?php

require_once '../config/env.php';

class CurlAccess
{
    /**
     * curl リソース
     */
    protected $curl;

    /**
     * レスポンスの HTTP ステータスコード
     */
    protected $statusCode;

    /**
     * 取得結果のデータ格納用
     */
    protected $data;

    /**
     * アクセス先
     */
    protected $object = null;

    public function __construct(string $object = null)
    {
        // 取得対象 URL をセット
        if (!is_null($object)) {
            $this->object = $object;
        }
    }

    /**
     * 指定したエンドポイントにアクセスする
     */
    public function getDataViaApi(string $object = null): ?CurlAccess
    {
        // 取得対象 URL をセット
        if (!is_null($object)) {
            $this->object = $object;
        }

        // 対象が null なら対象設定エラー状態
        if (is_null($this->object)) {
            return null;
        }

        // 診療時間 JSON を API で取得する
        // curl リソースを準備
        $this->curl = curl_init();
        curl_setopt_array($this->curl, [
            CURLOPT_URL => API_URL . 'api/' . $object . '?url=' . WEBSITE_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
        ]);
        // 問い合わせ実行
        $result = curl_exec($this->curl);
        // 実行結果の HTTP ステータスコードをセット
        $this->setStatusCode(curl_getinfo($this->curl, CURLINFO_RESPONSE_CODE));
        curl_close($this->curl);
        // JSON 化したデータを格納する
        $this->setData(json_decode($result, true));

        return $this;
    }

    /**
     * ステータスコードを返す
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * データを返す
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * ステータスコードをセット
     */
    private function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * 実行結果データをセット
     *
     * @param mixed $data
     */
    private function setData($data)
    {
        $this->data = $data;
    }
}

?>
