<?php

/**
 * 发送post请求
 * @param string $url 请求地址
 * @param array $post_data post键值对数据
 * @return string
 */
function send_post($url, $post_data) {
    $postdata = http_build_query($post_data);
    $options = array(
        'http' => array(
            'method' => 'POST',//POST
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => $postdata,
            'timeout' => 15 * 60 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    //return json_decode($result);
    return $result;
}
$data = send_post('http://www.testphp.com/shopList.php',["page"=>3,"pageSize"=>5]);
// 这里返回的是json对象，直接echo即可，不要再json_encode
var_dump(json_encode($data));