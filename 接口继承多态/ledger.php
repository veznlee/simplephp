<?php // vim:ft=php
include_once dirname(__FILE__) . '/DBAccess.php';
include_once dirname(__FILE__) . '/API.php';
include_once dirname(__FILE__) . '/SimpleHTTPSuport.php';

class ledger extends SimpleHTTPSuport implements API {
	private static $redis;

	public function __construct() {
		global $conf;
		$redis = new Redis();
		$res = $redis->pconnect($conf['redis']['host'], $conf['redis']['port']);
		if ($res == false) {
			throw new Exception('无法连接到Redis服务器');
		}
		self::$redis = $redis;
	}

	public function execute() {
		$xml = $this->getRequestBody();
		foreach($xml as $ledgerXML) {
			$var = $this->getLedgerFromXML($ledgerXML);
			$id = $this->publishLedger($var['ledger']);
			$this->setResponse('status', $id);
		}
		// 设置响应属性
		$this->setResponseMessage('success');

	}


	private function getLedgerFromXML($xml) {
		$ledger = array(
			'staffId' => '' . $xml->{'ledger-user'},
			'title' => '' . $xml->{'ledger-title'},
			'content' => '' . $xml->{'ledger-content'},
			'remark' => '' . $xml->{'ledger-remark'},
			'time' => '' . $xml->{'ledger-time'},
			'system' => '' . $xml->{'ledger-system'}
		);
		return array('ledger' => $ledger);
	}

	/**
	 * 新增一条内容
	 * @param {Object} $notice 消息描述, 拥有的键值有:source, noticeMode,
	 * 		noticeType, modeWinSize, contentUrl, actionUrl, publishTime,
	 * 		expireTime, message
	 * @param {Array} $members其中, $members为用户UID列表
	 */
	private static function publishLedger($ledger) {
		$sql = "SELECT staffId FROM `dyn_member_staff` WHERE staffid = '".$ledger['staffId']."'";
		$row = DBAccess::getRow($sql);
		if (empty($row)) {
			throw new ParamsException($sql);
		}
		$time = strtotime(date('Y-m-d',strtotime($ledger['time'])));
		$sql = "SELECT id FROM `ledger_record_list_gr` WHERE staffid = '".$ledger['staffId']."' AND addTime = '".$time."'";
		$row = DBAccess::getRow($sql);
		if(!empty($row)){
			$para = Array();
			$para['addTime'] = time();
			$para['lid'] = $row['id'];
			$para['title'] = $ledger['title'];
			$para['content'] = $ledger['content'];
			$para['remark'] = $ledger['remark'];
			$para['system'] = $ledger['system'];
			$para['isDelete'] = 0;
			return DBAccess::insertRow('ledger_push_list', $para);
		}else{
			throw new ParamsException('该用户没有创建台账');
		}

	}





}