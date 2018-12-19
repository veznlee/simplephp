<?php

变量的范围即它定义的上下文背景（也就是它的生效范围）。
大部分的 PHP 变量只有一个单独的范围。
这个单独的范围跨度同样包含了 include 和 require 引入的文件。


//预定义变量
超全局变量 — 超全局变量是在全部作用域中始终可用的内置变量
$GLOBALS — 引用全局作用域中可用的全部变量
$_SERVER — 服务器和执行环境信息
$_GET — HTTP GET 变量
$_POST — HTTP POST 变量
$_FILES — HTTP 文件上传变量
$_REQUEST — HTTP Request 变量
$_SESSION — Session 变量
$_ENV — 环境变量
$_COOKIE — HTTP Cookies
$php_errormsg — 前一个错误信息
$HTTP_RAW_POST_DATA — 原生POST数据
$http_response_header — HTTP 响应头
$argc — 传递给脚本的参数数目
$argv — 传递给脚本的参数数组	

//魔术常量
__LINE__	文件中的当前行号。
__FILE__	文件的完整路径和文件名。如果用在被包含文件中，则返回被包含的文件名。自 PHP 4.0.2 起，__FILE__ 总是包含一个绝对路径（如果是符号连接，则是解析后的绝对路径），而在此之前的版本有时会包含一个相对路径。
__DIR__	文件所在的目录。如果用在被包括文件中，则返回被包括的文件所在的目录。它等价于 dirname(__FILE__)。除非是根目录，否则目录中名不包括末尾的斜杠。（PHP 5.3.0中新增） =
__FUNCTION__	函数名称（PHP 4.3.0 新加）。自 PHP 5 起本常量返回该函数被定义时的名字（区分大小写）。在 PHP 4 中该值总是小写字母的。
__CLASS__	类的名称（PHP 4.3.0 新加）。自 PHP 5 起本常量返回该类被定义时的名字（区分大小写）。在 PHP 4 中该值总是小写字母的。类名包括其被声明的作用区域（例如 Foo\Bar）。注意自 PHP 5.4 起 __CLASS__ 对 trait 也起作用。当用在 trait 方法中时，__CLASS__ 是调用 trait 方法的类的名字。
__TRAIT__	Trait 的名字（PHP 5.4.0 新加）。自 PHP 5.4 起此常量返回 trait 被定义时的名字（区分大小写）。Trait 名包括其被声明的作用区域（例如 Foo\Bar）。
__METHOD__	类的方法名（PHP 5.0.0 新加）。返回该方法被定义时的名字（区分大小写）。
__NAMESPACE__	当前命名空间的名称（区分大小写）。此常量是在编译时定义的（PHP 5.3.0 新增）。


	
//常量	
常量是一个简单值的标识符（名字）。如同其名称所暗示的，
在脚本执行期间该值不能改变（除了所谓的魔术常量，它们其实不是常量）。
常量默认为大小写敏感。传统上常量标识符总是大写的。
// 合法的常量名
define("FOO",     "something");
define("FOO2",    "something else");
define("FOO_BAR", "something more");
// 以下代码在 PHP 5.3.0 后可以正常工作
const CONSTANT = 'Hello World';


//变量范围
$a = 1;
include 'b.inc';
这里变量 $a 将会在包含文件 b.inc 中生效。
但是，在用户自定义函数中，一个局部函数范围将被引入。
任何用于函数内部的变量按缺省情况将被限制在局部函数范围内。例如：
	$a = 1; /* global scope */
	function Test()
	{
		echo $a; /* reference to local scope variable */
	}
	Test();
这个脚本不会有任何输出，因为 echo 语句引用了一个局部版本的变量 $a，
而且在这个范围内，它并没有被赋值。你可能注意到 PHP 的全局变量和 C 语言
有一点点不同，在 C 语言中，全局变量在函数中自动生效，除非被局部变量覆盖。
这可能引起一些问题，有些人可能不小心就改变了一个全局变量。



//PHP 中全局变量在函数中使用时必须声明为 global。
$a = 1;
$b = 2;
function Sum()
{
    global $a, $b;

    $b = $a + $b;
}
Sum();
echo $b;


//静态变量
静态变量可以按照上面的例子声明。
如果在声明中用表达式的结果对其赋值会导致解析错误。
static $int = 0;          // correct
static $int = 1+2;        // wrong  (as it is an expression)
static $int = sqrt(121);  // wrong  (as it is an expression too)
function test()
{
    static $count = 0;
	//如果不是静态变量，每次运行时$count都为0，此处造成死循环

    $count++;
    echo $count;
    if ($count < 10) {
        test();
    }
    $count--;
}


//可变变量
$a = 'hello';
$$a = 'world';
这时，两个变量都被定义了：$a 的内容是“hello”并且 $hello 的内容是“world”。


确定变量类型 ?

因为 PHP 会判断变量类型并在需要时进行转换（通常情况下）
，因此在某一时刻给定的变量是何种类型并不明显。
PHP 包括几个函数可以判断变量的类型，例如：
gettype()，is_array()，is_float()，is_int()，is_object() 和 is_string()。

	
>