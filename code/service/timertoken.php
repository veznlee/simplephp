<?php
    include '../DBAconn.php';
    include 'request.php';
    $config = include 'conf.php';

    $param = array(
        'grant_type'=>'client_credential',
        'appid'=>$config['appConfig']['appid'],
        'secret'=>$config['appConfig']['secret']
    );
    $url = 'https://api.weixin.qq.com/cgi-bin/token';


    // 配合使用ignore_user_abort()和set_time_limit()，使脚本脱离浏览器运行。
    // 服务启动时，先访问一次页面，页面会一直处于加载状态，直接关闭即可
    // 如果要关闭，重启服务即可
    ignore_user_abort();//关闭浏览器后，继续执行php代码
    set_time_limit(0);//程序执行时间无限制


    // 存储token，在实际开发时要对各个数据库操作的返回结果做一下判断
    function cacheToken($access_token,$expires){
        // 查询
        $sql = 'SELECT count(*) as count from test';
        $token = DBAccess::getRow($sql);
        $row = false;
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

        return $row;
    }


    $sleep_time = 7200*1000;//多长时间执行一次
    $switch = include 'timerswitch.php';// 通过开关文件返回的结果，判断是否继续
    while($switch){
        $switch = include 'timerswitch.php';

        // $accessToken = 'm'.date('Y-m-d h:i:s', time());
        // $expiresIn = 10;

        $res = juhecurl($url,$param);
        $res = json_decode($res,true);
        $accessToken = $res['access_token'];
        $expiresIn = $res['expires_in'];

        //
        $time = isset($expiresIn)?$expiresIn:20;

        cacheToken($accessToken,$expiresIn);
        // 在最后的5分钟，两个token都可以用
        $sleep_time = ($time-4*60)*1000;

        /**
         * int file_put_contents ( string $filename , mixed $data [, int $flags = 0 [, resource $context ]] )
         * 该函数将返回写入到文件内数据的字节数
         * 
            filename要被写入数据的文件名。
            data要写入的数据。

            flag:
            FILE_USE_INCLUDE_PATH	在 include 目录里搜索 filename。 更多信息可参见 include_path。
            FILE_APPEND	如果文件 filename 已经存在，追加数据而不是覆盖。
            LOCK_EX	在写入时获得一个独占锁。
         */
        // $msg=date("Y-m-d H:i:s").$switch;
        // file_put_contents("log.log",$msg,FILE_APPEND);//记录日志
        sleep($sleep_time);//等待时间，进行下一次操作。
    }
    exit();
    
?>