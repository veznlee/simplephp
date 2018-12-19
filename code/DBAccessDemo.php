<?php
// 加载配置
$conf = include './config.php';
// 加载基本函数及基本类库
include $conf['api_dir'] . '/DBAccess.php';

function test($apiName){
	echo <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<result>
	<status>123455678</status>
	<message>$apiName</message>
</result>
XML;

}

//数据库连接的使用
function getUserName() {
	date_default_timezone_set('RPC');
	$sessKey = $_COOKIE['sesCoo'];
	$sql = 'SELECT data FROM dyn_member_session WHERE sesskey=? AND expiry>=? LIMIT 1';
	$username = DBAccess::getValue($sql, $_COOKIE['sesCoo'], $_SERVER['REQUEST_TIME']);
	if ($username) {
		return $username;
	} else {
		return null;
	}
}


//数据库连接的使用
function getResourceId($siteId){
	$sql = "select resourceId from `mh_internet_contrast` where cid = ?";
	$res = DBAccess::getValue($sql,$siteId);
	return $res;

}
function getResourceIdNew($siteid,$nodeid){
	$sql = "select r.id,m.extitle from `mh_internet_contrast` c,`mh_column_member` m,`mh_push_resource` r where c.siteid = ? and c.nodeid = ? and m.domain = c.domain and r.columnGuid = m.guid";
	$res = DBAccess::getRows($sql, $siteid,$nodeid);
	return $res;
}



function displyError($err) {
	header('content-Type: application/xml; charset=utf-8');

	if ($err instanceof Exception) {
		$msg = $err->getMessage();
	} else {
		$msg = $err;
	}

	addLog($err);

	echo <<<XML
	<?xml version="1.0" encoding="UTF-8"?>
	<result>
		<status>err</status>
		<message>$msg</message>
	</result>
XML;
}

DBAccess::disconnect();
