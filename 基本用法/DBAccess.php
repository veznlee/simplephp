<?php
/**
 * 静态数据库访问类
 */
class DBAccess {
	// 参数常量
	const OPT_DEBUG = 0;
	const OPT_DSN = 1;
	const OPT_USER = 2;
	const OPT_PASSWORD = 3;
	const OPT_CHARSET = 4;
	const OPT_FIELD_WARP = 5;
	const OPT_PERSISTENT = 6;

	// 参数配置
	/**
	 * 是否显示调试信息
	 */
	private static $debug = false;

	/**
	 * 连接DSN设置
	 *
	 * useage:
	 *    "mysql:host=localhost;dbname=dbname"
	 *    'mysql:dbname=testdb;host=127.0.0.1;port=3333'
	 *    'mysql:dbname=testdb;unix_socket=/path/to/socket'
	 *    'sqlite:example.db'
	 *    "mysql:host=localhost;dbname=DB;charset=UTF8"
	 *    'uri:file:///usr/local/dbconnect'
	 *
	 * 参见: http://php.net/manual/zh/pdo.construct.php
	 */
	private static $dsn;

	/**
	 * 数据库用户名
	 */
	private static $user;

	/**
	 * 数据库密码
	 */
	private static $password;

	/**
	 * 是否持久性连接
	 */
	private static $persistent = false;

	// 字段包裹符, 防止字段名与SQL关键冲突
	// MySQL用"`", sqlite用'"'
	private static $fieldWarp = '`';

	/**
	 * 数据库连接, 一个标准的PDO对象
	 */
	private static $conn;

	/**
	 * 设置配置参数
	 * @param {int} $iType 配置项, 有哪些配置项见定义常量
	 * @param {Object} $value 配置值, 数据类型根据配置项而定
	 */
	public static function setOption($iType, $value) {
		switch ($iType) {
		case self::OPT_DEBUG:
			self::$debug = $value;
			break;
		case self::OPT_DSN:
			self::$dsn = $value;
			break;
		case self::OPT_USER:
			self::$user = $value;
			break;
		case self::OPT_PASSWORD:
			self::$password = $value;
			break;
		case self::OPT_FIELD_WARP:
			self::$fieldWarp = $value;
			break;
		case self::OPT_PERSISTENT:
			self::$persistent = $value;
			break;
		}
	}

	/**
	 * 连接数据库
	 */
	private static function connect() {
		// 配置选项
		// 字符集配置请放在DSN中配置
		$options=array(
			// 持久化连接
			PDO::ATTR_PERSISTENT => false,

			// 抓取数据时, 是否把数字转成字符
			// 为什么没有作用?
			PDO::ATTR_STRINGIFY_FETCHES => false
		);

		$conn = new PDO(self::$dsn, self::$user, self::$password, $options);
		if ($conn->getAttribute(PDO::ATTR_DRIVER_NAME == 'mysql')) {
			$conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
		}

		self::$conn = $conn;
	}

	public static function disconnect() {
		self::$conn = null;
	}

	/**
	 * 获取数据库连接
	 */
	private static function getConnection() {
		// 如果没有连接过数据库
		// 先连接数据库
		if (self::$conn == null) {
			self::connect();
		}

		// 测试连接结果
		if (self::$conn == null) {
			throw new Exception('Connect MySQL fail.');
		}

		return self::$conn;
	}

	public static function prepare($sql) {
		$conn = self::getConnection();
		return $conn->prepare($sql);
	}

	/**
	 * 执行一个查询,返回一个PDOStatement对象
	 * query(String sql, Object... params)
	 * query(String sql, Object[] params)
	 *
	 * @param {String} sql 待执行查询语句,可以包含"?"点位符和":"点位符
	 * @param {Object|Array} 点位符参数
	 * @return {PDOStatement}
	 */
	public static function query() {
		$params = func_get_args();

		$argc = count($params);
		if ($argc < 1) {
			throw new Exception();
		}

		// 把第一个参数当成是查询SQL语句
		// 剩下的参数做为预置参数
		$sql = array_shift($params);

		// 可以把参数以数组方式传入
		// 便于调用, 也便于键/值数组参数
		if ($params[0] && is_array($params[0])) {
			$params = $params[0];
		}

		$stmt = self::prepare($sql);
		$res = $stmt->execute($params);
		if ($res === false && self::$debug) {
			$paramsError = var_export($params, true);
			$err = $stmt->errorInfo();
			$stmt->debugDumpParams();
			throw new Exception($err[2] .' | '.$stmt->queryString .' | '.$paramsError);
		}

		return $stmt;
	}

	/**
	 * 获取多行记录
	 * @param {String} $sql 查询语句
	 * @param {Object...param} $param 参数占位符
	 * @return {Array<String, String>}
	 */
	public static function getRows(){
		$stmt = call_user_func_array(array(self, 'query'), func_get_args());
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetchAll();
	}

	/**
	 * 获取一个表模型
	 */
	public static function table($tableName) {
		return null;
	}

	/**
	 * 获取一行记录
	 * @param {String} $sql 查询语句
	 * @param {Object...param} $param 参数占位符
	 * @return {Array<String, String>}
	 */
	public static function getRow(){
		$stmt = call_user_func_array(array(self, 'query'), func_get_args());
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetch();
	}

	/**
	 * 简化按ID读取记录操作
	 *
	 * @param {String} $table 表名
	 * @param {int} $idValue ID值
	 * @param {String} $fieldList 返回的列名, 默认全部返回
	 * @param {String} $idField 主键名
	 *
	 * @return 返回记录数组
	 */
	public static function getRowById($table, $idValue, $fieldList='*', $idField='id'){
		$sql="select $fieldList from $table where $idField=?";
		return self::getRow($sql, $idValue);
	}

	/**
	 * 获取一条记录
	 * 同getRow, 但不以数组方式返回, 而是以标准对象方式返回
	 * @see getRow
	 */
	public static function getObject(){
		$stmt = call_user_func_array(array(self, 'query'), func_get_args());
		return $stmt->fetchObject();
	}

	/**
	 * 获取一个值
	 * 一般用来求一个结果
	 */
	public static function getValue(){
		$stmt = call_user_func_array(array(self, 'query'), func_get_args());
		return $stmt->fetchColumn();
	}

	/**
	 * 执行一个更新操作, 返回影响的行数
	 */
	public static function update() {
		$stmt = call_user_func_array(array(self, 'query'), func_get_args());
		return $stmt->rowCount();
	}

	/**
	 * 删除操作
	 */
	public static function delete() {
		$stmt = call_user_func_array(array(self, 'query'), func_get_args());
		return $stmt->rowCount();
	}

	/**
	 * 按ID更新一行数据
	 */
	public static function updateRowById($table, $data, $idValue, $idField="id"){
		$wrapChar = self::$fieldWarp;
		return self::updateRows($table, $data, "{$wrapChar}$idField{$wrapChar}=$idValue");
	}

	/**
	 * 更新数据
	 *
	 * @param {String} $table 表名
	 * @param {Array<String, Object>} $data 更新的数据
	 * @param {String} $where 更新条件
	 * @return {int} 影响的记录数
	 * @see update
	 */
	public static function updateRows($table, $data, $where){
		$wrapChar = self::$fieldWarp;
		$sql="update $table set";
		foreach($data as $key=>$_v) $sql.=" {$wrapChar}$key{$wrapChar}=:$key,";
		$sql=rtrim($sql, ',')." where $where";

		return self::update($sql, $data);
	}

	/**
	 * 插入数据
	 * insert(String sql, Object...params)
	 * insert(String sql, Object[] params)
	 *
	 * @param {String} sql 待执行查询语句,可以包含"?"点位符和":"点位符
	 * @param {Object|Array} 点位符参数
	 * @return {int} 返回插入的自增ID
	 * @see insertRow
	 */
	public static function insert(){
		call_user_func_array(array(self, 'query'), func_get_args());
		return self::$conn->lastInsertId();
	}

	/**
	 * 插入数据到表
	 *
	 * @param {String} 表名
	 * @param {Array<String, Object>} $data 待插入的数据, 键名与表字段对应
	 * @param {String} $insertType 插入方式, 可以用 'insert'和'replace', 后者遇到重复的时候将替换成新值, 只有MySQL能用replace
	 * @see insertRows
	 */
	public static function insertRow($table, $data, $insertType='insert'){
		$wrapChar = self::$fieldWarp;
		$sql="$insertType into $table(";
		$values='';
		foreach($data as $key=>$val){
			if($values){
				$sql.=', ';
				$values.=', ';
			}
			$sql.="{$wrapChar}$key{$wrapChar}";
			$values.=":$key";
		}
		$sql.=") values($values)";

		return self::insert($sql, $data);
	}

	/**
	 * 批量插入数据
	 *
	 * @param {String} $table 插入表名
	 * @param {Array<Array<String, Object>>} 待插入的数据
	 * @param {String} $insertType 插入方式, 可以用 'insert'和'replace', 后者遇到重复的时候将替换成新值, 只有MySQL能用replace
	 * @see insertRow
	 */
	public static function insertRows($table, $data, $insertType='insert'){
		foreach($data as $var) {
			self::insertRow($table, $var, $insertType);
		}
		return self::$conn->lastInsertId();

		$wrapChar = self::$fieldWarp;
		$var = current($data);
		$columnCount = count($var);

		// 构造
		$sql = "$insertType into $table(";
		$value = 'values(';

		$i = 1;
		foreach($var as $key => $val) {
			$sql .= "{$wrapChar}$key{$wrapChar}";
			$value .= ":$key";
			if ($i < $columnCount) {
				$sql .= ', ';
				$value .= ',';
				$i++;
			}
		}

		$sql .= ") $value)";
		unset($value);
		unset($var);

		$stmt = self::getConnection()->prepare($sql);
		foreach($data as $var) {
			$ret = $stmt->execute($var);
			if ($ret == false) {
				throw new Exception($stmt->errorInfo());
			}
		}
	}
}
