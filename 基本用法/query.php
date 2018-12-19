<?php
/**
 * 负责把推送过来的中间库数据, 推到栏目去
 */

$conf = include './config.php';
include $conf['api_dir'] . '/DBAccess.php';
include 'server/session.php';

DBAccess::setOption(DBAccess::OPT_DSN, $conf['database']['dsn']);
DBAccess::setOption(DBAccess::OPT_USER, $conf['database']['username']);
DBAccess::setOption(DBAccess::OPT_PASSWORD, $conf['database']['password']);

DBAccess::setOption(DBAccess::OPT_DEBUG, true);

if (getUserName() == null) {
	//跳转页面
	header('location: /');
	//结束后续代码执行
	die;
}

?>
<!DOCTYPE HTML>
<html lang="cn-zh">
<head>
<meta charset="UTF-8">
<title></title>
<script data-main="src/query" src="/skin/js/require/require.js"></script>
<style type="text/css">
body{font-size:12px;}
</style>
<link href="/skin/css/kendo/kendo.common.min.css" rel="stylesheet"/>
<link href="/skin/css/kendo/kendo.default.min.css" rel="stylesheet"/>
</head>
<body>
	
</body>
</html>