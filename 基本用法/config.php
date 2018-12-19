<?php
ini_set('date.timezone', 'asia/shanghai');

if (!function_exists('addLog')) {
	function addLog($msg) {
		$msg = date('[Y-m-d H:i:s]') . "\r\n" . var_export($msg, true) . "\r\n";
		file_put_contents('log', $msg, FILE_APPEND);
	}
}

return array(
	// 接口类库基本目录
	'api_dir' => dirname(__FILE__)."/server/",

	// 数据库配置
	'database' => array(
		'dsn' => 'mysql:host=xxx;dbname=xxx;charset=UTF8',
		'username' => 'xxx',
		'password' => 'xxx'
	)
);


