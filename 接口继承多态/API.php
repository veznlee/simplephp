<?php

interface API {
	/**
	 * 检查权限
	 */
	public function checkToken($token);

	/**
	 * 解析请求
	 */
	public function parseRequest($body);

	/**
	 * 附加参数
	 */
	public function setExtraParams($params);

	/**
	 * 执行任务
	 */
	public function execute();

	/**
	 * 输出响应结果
	 */
	public function writeResponse();
}
