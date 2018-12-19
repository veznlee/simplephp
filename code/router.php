<?php
/**
 * 该文件用于路由控制，以实现通过url访问类方法的功能
 * 例：url为.../router.php/session/test，则访问的是当前目录下sessein类的test方法
 */

try{
    //获取类名与方法
    $uri    = parse_url($_SERVER['PATH_INFO']);
    $query  = $uri['path'];
    $pathInfo = array_values(array_filter(explode('/',$query)));
    $className = ucfirst(isset($pathInfo[0])?$pathInfo[0]:'');
    $methodName = isset($pathInfo[1])?$pathInfo[1]:'';
    if(!$className||!$methodName){
        throw new \Exception();
    }
    $methodNameArr = explode('_',$methodName);
    $method = '';
    foreach ($methodNameArr as $key=>$value){
        if($key!=0){
            $method.=ucfirst($value);
        }else{
            $method=$value;
        }
    }
    
    $fileDir = $className.'.php';
    include_once $fileDir;
    $classObj = new $className();

    //获取查询参数
    $params = $_GET;
    if(isset($params)){
        $data = $classObj->$method($params);
    }else{
        $params = $_POST;
        if(isset($params)){
            $data = $classObj->$method($params);
        }else{
            $data = $classObj->$method($params);
        }
    }
    //exit($data);
    echo json_encode($data);
}catch (\Exception $e){
    Header("HTTP/1.0 404 Not Found");
}