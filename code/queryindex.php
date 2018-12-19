<?php
/**
 * 负责把推送过来的中间库数据, 推到栏目去
 */
$conf = include './config.php';

include $conf['api_dir'] . '/DBAccess.php';

DBAccess::setOption(DBAccess::OPT_DSN, $conf['database']['dsn']);
DBAccess::setOption(DBAccess::OPT_USER, $conf['database']['username']);
DBAccess::setOption(DBAccess::OPT_PASSWORD, $conf['database']['password']);
DBAccess::setOption(DBAccess::OPT_DEBUG, true);



include 'queryfn.php';


$uname = getUserName();
if ($uname == null) {
	echo ('查询失败');
	// 跳转页面
	// header('location: /');
	//结束后续代码执行
	die;
}else{
	echo ($uname);
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
	<h1>数据库连接查询测试</h1>
	<p>当前查询到的用户是：<?php echo $uname; ?></p>
</body>
</html>