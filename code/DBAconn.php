<?php
/**
 * 负责把推送过来的中间库数据, 推到栏目去
 */
 
//把config.php中返回的值传给$conf变量，同时，在该php中可使用config.php中其他的方法或变量等内容
$conf = include 'config.php';

//引入来自其他路径的文件，路径通过$conf['api_dir']获取
include $conf['api_dir'] . '/DBAccess.php';

//DBAccess类来自引入的$conf['api_dir'] . '/DBAccess.php'
//调用里面的静态方法,为自己的静态属性赋值
DBAccess::setOption(DBAccess::OPT_DSN, $conf['database']['dsn']);
DBAccess::setOption(DBAccess::OPT_USER, $conf['database']['username']);
DBAccess::setOption(DBAccess::OPT_PASSWORD, $conf['database']['password']);

DBAccess::setOption(DBAccess::OPT_DEBUG, true);

