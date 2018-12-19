<?php
/**
 * 请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 30 );
    curl_setopt($ch, CURLOPT_TIMEOUT , 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    if($ispost) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_URL, $url);
    }
    else {
        //echo $url.'?'.$params;
        if($params) {
            $params = http_build_query($params);
            $params = urldecode($params);
            curl_setopt($ch, CURLOPT_URL, $url.'?'.$params);
        }
        else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
    }
    $response = curl_exec($ch);
    if ($response === FALSE) {
        echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $httpInfo = array_merge($httpInfo , curl_getinfo($ch));
    curl_close($ch);
    return $response;
};

// $param=array(
//     "appid"=>'wx2fdd4071bcfa5e15',
//     "secret"=>'93771119d6d8f67f438f94c681560640',
//     "grant_type"=>'client_credential'
// );
// $url = 'https://api.weixin.qq.com/cgi-bin/token';

// $res = juhecurl($url,$param); 
// $res = json_decode($res,true);

// echo $res['access_token'];
// echo $res['expires_in'];

