<?php
function getUserName() {
	// 设定用于一个脚本中所有日期时间函数的默认时区
	date_default_timezone_set('PRC');

	$sql = 'SELECT uname FROM users WHERE id=? AND ugender>=? LIMIT 1';
	$username = DBAccess::getValue($sql, 1, 0 );
	if ($username) {
		return $username;
	} else {
		return null;
	}
}