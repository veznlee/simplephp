<?php
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
