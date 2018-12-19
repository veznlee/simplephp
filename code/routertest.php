<?php
$conf = include './config.php';
include $conf['api_dir'] . '/DBAconn.php';

class RouterTest {
	// https://www.bajiaoqing.com/code/router.php/routertest/test
	function test(){
		echo 'test';
	}

	// https://www.bajiaoqing.com/code/router.php/routertest/testquery
	function testQuery() {
		// 设定用于一个脚本中所有日期时间函数的默认时区
		date_default_timezone_set('PRC');

		$sql = 'SELECT uname FROM users WHERE id=? AND ugender>=? LIMIT 1';
		$username = DBAccess::getValue($sql, 1, 0 );
		echo $username;
		if ($username) {
			return $username;
		} else {
			return null;
		}
	}

	// https://www.bajiaoqing.com/code/router.php/routertest/testjson
	function testJson($param) {
		// var_dump($param);
		var_dump($param);
		//return $param;
		$page = isset($param['page']) ? $param['page'] : 1;
		$pageSize = isset($param['pageSize']) ? $param['pageSize'] : 5;

		return [
			"page"=>$page,
			"pageSize"=>$pageSize,
			"rating"=>[
                "max"=>10,
                "average"=>0,
                "stars"=>"00",
                "min"=>0
            ],
            "genres"=>[
                "剧情",
                "爱情"
            ],
            "title"=>"缘·梦"
		]
	}
}