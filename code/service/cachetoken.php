<?php
include '../DBAconn.php';
// 存储token
function cacheToken($access_token,$expires){
    // 查询
    $sql = 'SELECT count(*) as count from test';
    $token = DBAccess::getRow($sql);
    $row = [];
    if($token['count'] == 0){
        // 新增
        $row = DBAccess::insertRow('test',[
            "token"=>$access_token,
            "expires"=>$expires
        ]);
    }else{
        // 更新
        $row = DBAccess::updateRows('test',array(
            "token"=>$access_token,
            "expires"=>$expires
        ),'1=1');
    };
}

cacheToken('hehehe',7300);