<?php
	class Computer { 
		//常量的输出方法  类::常量
		const NAME = 'DELL';
		
		//字段成员的声明格式：修饰符 变量名 [=xxx];
		public $_name;  //public表示共有，类外可以访问
		public $_model;
		
		//private是私有化，即对字段进行封装的操作，类外无法访问，取值和赋值都不能操作
		private _name = '联想';
		//必须写一个对内的入口，对私有字段进行赋值
		public function setName($_name) {
			//这里的$_name只是一个变量而已，参数而已
			//$this->_name才是类的字段
			$this->_name = $_name;
		}
		//必须写个对外的入口，才可以取到
		public function getName() {
			return $this->_name;
		}
		
		
		//静态成员字段
		public static $_count = 0;
		public function _add() {
			//如果是静态成员字段，那么就应该用self来调用，而不是$this
			//每个实例的静态字段都是单独的，不会互相影响，但非静态的字段会
			self::$_count++;
		}
		public static function _runStatic() {
			self::$_count++;
		}
		
		
		
		
		public function __destruct() {
			echo '我是析构方法';
		}
		
		//我要创建一个构造方法
		public function __construct() {
			echo '我是比较先进的构造方法！';
		}
		
		//采用一个公共对外的方法来访问私有字段
		//因为私有字段只能在类内访问，而对外的公共方法是类内的。
		//更而公共方法又是公共的，所以类外又可访问。
		public function _run() {
			//字段在类内调用的时候必须是类->字段，而$_name只是一个普通变量而已。
			//字段在类外调用的方法是对象->字段，而类内就必须使用Computer->_name
			//但是在本类中，可以用一个关键字来代替Compouter，那就是$this
			echo $this->_name;  
		}
		
		//创建方法的格式：修饰符 function 方法名() {}
		//如果不加修饰符，默认就是public
		public function _run() {
			echo '我是运行的方法';
		}
		
	}	
	
	//常量
	echo Computer::NAME;
	
	//静态字段和方法
	Computer::_runStatic();
	echo Computer::$_count;
	
	//创建一个对象，生产出一台电脑  ->表示指向
	$computer1 = new Computer();
	//给成员字段赋值
	$computer1->_name = '联想';
	$computer1->_run();
	//取值
	echo $computer1->_name;
	$computer2 = $computer1;
	echo $computer2->_name;
	
	//判断一个实例是否由某个类创建
	echo ($computer1 instanceof Computer); 
	
	
	//采用拦截器进行赋值和取值
	class Computer2 {
		private $_name;
		private $_model;
		private $_cpu;
		
		//当类外的对象直接调用私有字段时，会跟着去检查是否有拦截器,
		//如果直接对$_name进行赋值，那么__set()方法就会拦截住，就不会报错了。
		
		//__set()和__get()方法私有了，还是可以执行，
		//是因为__set()和__get()是PHP内置的方法，具有一定的特殊性
		//因为目前程序的指针已经在类内了。而类内可以执行封装的方法
		//类内执行私有方法，不会出现任何错误。
		//它只需要间接的拦截就可以了。拦截是在内类执行的。

		//赋值
		private function __set($_key,$_value) {
			//那么$_key = '_name'，那么$_value = '联想';
			//$this->_name = '联想'
			//那么$_key = '_cpu'，那么$_value = '四核'
			//$this->_cpu = '四核'
			//那么$_key = '_model'，那么$_value = 'i7'
			//$this->_model = 'i7'
			$this->$_key = $_value;
		}
		
		//取值
		private function __get($_key) {
			return $this->$_key;
			//如果$_key = '_name' 那么$this->_name;
			//如果$_key = '_cpu' 那么$this->_cpu;
			//如果$_key = '_model' 那么$this->_model;
		}
		
	}
	
	$computer = new Computer2();
	$computer->_name = '联想';
	$computer->_cpu = '四核';
	$computer->_model = 'i7';
	echo $computer->_name;
	echo $computer->_cpu;
	echo $computer->_model;
	
	//=> 是数组成员访问符号
	//-> 是对象成员访问符号
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
>