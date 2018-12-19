<?php

include_once dirname(__FILE__) . '/Array2XML.php';

abstract class SimpleHTTPSuport implements API {
	/**
	 * 口令有效时长
	 */
	public static $tokenExpire = 60000;

	/**
	 * 附加参数
	 */
	private $extraParams;

	/**
	 * 用户ID, 请求令牌的用户ID, 检查令牌有效后可用
	 */
	private $uid;

	/**
	 * 响应数据
	 */
	private $responseBody = array(
	);

	/**
	 * 请求体参数
	 */
	private $requestBody;

	protected $hasError = false;

	/**
	 * 设置响应字段
	 */
	protected function setResponse($name, $value) {
		$this -> responseBody ["$name"] = $value;
	}

	/**
	 * 获取响应体
	 */
	protected function getResponseBody() {
		return $this -> responseBody;
	}

	/**
	 * 设置响应信息
	 */
	protected function setResponseMessage($message) {
		$this->setResponse('message', $message);
	}

	/**
	 * 设置附加参数
	 */
	public function setExtraParams($params) {
		$this->extraParams = $params;
	}

	/**
	 * 获取附加参数
	 */
	protected function getExtraParam($key) {
		return $this->extraParams[$key];
	}

	/**
	 * 获取请求参数
	 */
	protected function getRequestBody() {
		return $this->requestBody;
	}

	/**
	 * 解析参数, 因为大部分接口是xml方式提交
	 * 所以这个主要用来解析xml, 其它方式的数据可以重写这个方法
	 */
	public function parseRequest($body) {
		if (!$body) {
			return;
		}

		//var_dump($body);die;
		try {
			$xml = simplexml_load_string($body);
			$json = json_encode($xml);
			$xml = null;
			$this->requestBody = json_decode($json);
		} catch (Exception $err) {
			throw new ParamsException('提交xml数据格式不正确.');
		}
	}

	/**
	 * 这主要是以xml方式返回数据给请求
	 * 如果有的接口不以xml方式返回, 可以重写这方法
	 */
	public function writeResponse() {
		$body = $this->getResponseBody();
		$root = $this->getXMLRoot();
		$xml = Array2XML::createXML($root, $body);
		header('content-Type: application/xml; charset=utf-8');
		echo $xml->saveXML();
	}

	/**
	 * xml根结点
	 */
	protected function getXMLRoot() {
		return 'result';
	}

	/**
	 * 检查权限, 不用权限检查的子类(如请求权限接口)可以重写这个方法
	 * @Override
	 * @see API.checkToken
	 */
	public function checkToken($token) {
		// 查找token对象的session记录
		$sql = "select * from mh_push_session where token=?";
		$session = DBAccess::getRow($sql, $token);
		if (!$session) {
			throw new TokenException();
		}

		$this->uid = $session['uid'];


		// 超时检查
		$time = $_SERVER['REQUEST_TIME'];
		if ($session['accessTime'] - 0 < $time - self::$tokenExpire) {
			throw new TokenException('令牌已经过期, 请重新申请');
		}

		// 延长令牌有效期
		$sql = 'update mh_push_session set accessTime=? where id=?';
		DBAccess::update($sql, $time, $session['id']);
	}

	/**
	 * 请求令牌的用户ID, 检查令牌后可用
	 */
	protected function getMemberUid() {
		return $this->uid;
	}

	/**
	 * 检查客户端IP
	 */
	protected function checkClientIP() {
		// TODO
	}

	/**
	 * 检查客户端时间
	 */
	protected function checkClientTime() {
		$key = "client-time";
		$clientTime = $this->getRequestBody()->$key;
		if (!$clientTime) {
			throw new ParamsException('提交参数不正确');
		}

		$clientTime = strtotime($clientTime);
		$time = $_SERVER['REQUEST_TIME'];
		$diff = 120;
		if ($clientTime < $time - $diff || $clientTime > $time + $diff) {
			throw new ParamsException('与服务器时间相差不能超过2分钟');
		}
	}

}
