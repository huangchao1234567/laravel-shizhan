<?php

namespace Tests\Unit;

use GuzzleHttp\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
       public function testBasicTest()
       {
           //$this->assertTrue(true);

           $api_key    = "3dd2e4ecfcd8496c949e24e8f787cfac";
           $api_secret = "84c958cf1ca14cc18ce457590c039c95";

           $timestamp = substr(array_sum(explode(' ', microtime())) * 1000, 0, 13);
           $my_sign   = base64_encode(hash_hmac("sha1", $timestamp, $api_secret, true));

           $curl = curl_init();
   // 关闭SSL验证
           curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
           curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

           curl_setopt_array($curl, array(
               CURLOPT_URL            => "https://api.koios.cn/services/v1/rest/enterprise/search?keyword==".urlencode("阿里巴巴"),
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_TIMEOUT        => 30,
               CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
               CURLOPT_CUSTOMREQUEST  => "GET",
               CURLOPT_HTTPHEADER     => array(
                   "X-AK-KEY: $api_key",
                   "X-AK-PIN: $my_sign",
                   "X-AK-TS: $timestamp"
               )
           ));

           $response = curl_exec($curl);
           dd(urlencode("阿里巴巴"), $my_sign, json_decode($response, true));
           $err = curl_error($curl);

           curl_close($curl);

           if ($err) {
               echo "cURL Error #:" . $err;
           } else {
               echo $response;
           }
       }

    public function testCeshi()
    {
        $where = [
            'applyNo'  => '261074',
            'markName' => '金都',
            'keyword'  => '',
            'markType' => '',
        ];

        $api_key    = "3dd2e4ecfcd8496c949e24e8f787cfac";
        $api_secret = "84c958cf1ca14cc18ce457590c039c95";

        $timestamp = substr(array_sum(explode(' ', microtime())) * 1000, 0, 13);
        $my_sign   = base64_encode(hash_hmac("sha1", $timestamp, $api_secret, true));

        $header = [
            'X-AK-KEY' => $api_key,
            'X-AK-PIN' => $my_sign,
            'X-AK-TS'  => $timestamp
        ];

        $url      = 'https://api.koios.cn/services/v3/rest/enterprise/getThirdPartyTradeMarkInfo';
        $client   = new \GuzzleHttp\Client(['verify' => false]);
        $response = $client->request('GET', $url, [
            'headers' => $header,
            'query'   => $where
        ]);
        $data     = $response->getBody()->getContents();

        dd(json_decode($data, true));
    }
}
