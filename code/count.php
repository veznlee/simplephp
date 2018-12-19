<?php
$conf = include './config.php';
include $conf['api_dir'] . '/DBAccess.php';

include 'count/count/include.php';
include 'count/tag/TaskParser.php';

DBAccess::setOption(DBAccess::OPT_DSN, $conf['database']['dsn']);
DBAccess::setOption(DBAccess::OPT_USER, $conf['database']['username']);
DBAccess::setOption(DBAccess::OPT_PASSWORD, $conf['database']['password']);

// 配置文件所在路径
TaskParser::$CONF_DIR = $conf['tasks']['config_dir'];
// 编译文件所在路径
TaskParser::$COMPILE_DIR = $conf['tasks']['compile_dir'];

$tasks = TaskParser::parseFile($_GET['sid'] . '.xml', true);
//$tasks = unserialize(file_get_contents('F:\vhosts\count.new\doc\simple.xml.ser'));
$ret = TaskRunner::run($tasks, $_REQUEST);

header('content-Type: application/json');
echo json_encode($ret);

//var_dump($ret);

