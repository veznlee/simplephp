<?php
error_reporting(0);

function send_get($url) {
    //$postdata = http_build_query($post_data);
    $options = array(
        'http' => array(
            'method' => 'GET',//POST
            'header' => 'Content-type:application/x-www-form-urlencoded',
            //'content' => $postdata,
            'timeout' => 15 * 60 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return $result;
}



/**
 * 发送post请求
 * @param string $url 请求地址
 * @param array $post_data post键值对数据
 * @return string
 * */
function send_get2($url,$param){
    foreach ($param as $k => $v) {
        $data[] = $k.'='.$v;
    }
    $p_str = implode('&', $data);
    $url .= '?'.$p_str;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, true);
}

//$data = send_get2('http://www.testphp.com/shopList.php',array("page"=>3,"pageSize"=>5));
//var_dump($data);


$conf = include './conf.php';
//var_dump($conf );
$param = array(
    'grant_type'=>'client_credential',
    'appid'=>$conf['appConfig']['appid'],
    'secret'=>$conf['appConfig']['secret']
);
$url = 'https://api.weixin.qq.com/cgi-bin/token';
//$res = send_get2($url ,$param);
