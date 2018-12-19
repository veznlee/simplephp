<?php


任何有效的 PHP 代码都有可能出现在函数内部，甚至包括其它函数和类定义。

//PHP 中的所有函数和类都具有全局作用域，可以定义在一个函数之内而在之外调用，反之亦然。
//PHP 不支持函数重载，也不可能取消定义或者重定义已声明的函数。
function foo(){
  function bar(){
    echo "I don't exist until foo() is called.\n";
  }
}
/* 现在还不能调用bar()函数，因为它还不存在 */
foo();

/* 现在可以调用bar()函数了，因为foo()函数
   的执行使得bar()函数变为已定义的函数 */
bar();



默认情况下，函数参数通过值传递（因而即使在函数内部改变参数的值，它并不会改变函数外部的值）。
如果希望允许函数修改它的参数值，必须通过引用传递参数。
如果想要函数的一个参数总是通过引用传递，可以在函数定义中该参数的前面加上符号&
function add_some_extra(&$string){
    $string .= 'and something extra.';
}
$str = 'This is a string, ';
add_some_extra($str);


//函数中可以使用默认参数，默认值必须是常量表达式，不能是诸如变量，类成员，或者函数调用等。
function makecoffee($type = "cappuccino"){
    return "Making a cup of $type.\n";
}
echo makecoffee();
echo makecoffee(null);
echo makecoffee("espresso");

Making a cup of cappuccino.
Making a cup of .
Making a cup of espresso.


//PHP 还允许使用数组 array 和特殊类型 NULL 作为默认参数，例如：
function makecoffee($types = array("cappuccino"), $coffeeMaker = NULL){
    $device = is_null($coffeeMaker) ? "hands" : $coffeeMaker;
    return "Making a cup of ".join(", ", $types)." with $device.\n";
}
echo makecoffee();
echo makecoffee(array("cappuccino", "lavazza"), "teapot");

//注意当使用默认参数时，任何默认参数必须放在任何非默认参数的右侧；
//否则，函数将不会按照预期的情况工作。考虑下面的代码片断：
function makeyogurt($type = "acidophilus", $flavour){
    return "Making a bowl of $type $flavour.\n";
}
echo makeyogurt("raspberry");   // won't work as expected



//可变数量的参数列表
function sum(...$numbers) {
    $acc = 0;
    foreach ($numbers as $n) {
        $acc += $n;
    }
    return $acc;
}

echo sum(1, 2, 3, 4);


//参数列表相关
//Returns the number of arguments passed into the current user-defined function.
function foo(){
    $numargs = func_num_args();
    echo "Number of arguments: $numargs\n";
}
func_get_arg — 返回参数列表的某一项
func_get_args — 返回一个包含函数参数列表的数组
function_exists — 如果给定的函数已经被定义就返回 TRUE


//call_user_func_array — 调用回调函数，并把一个数组参数作为回调函数的参数
function foobar($arg, $arg2) {
    echo __FUNCTION__, " got $arg and $arg2\n";
}
class foo {
    function bar($arg, $arg2) {
        echo __METHOD__, " got $arg and $arg2\n";
    }
}
// Call the foobar() function with 2 arguments，类似applay
call_user_func_array("foobar", array("one", "two"));
// Call the $foo->bar() method with 2 arguments
$foo = new foo;
call_user_func_array(array($foo, "bar"), array("three", "four"));
以上例程的输出类似于：
foobar got one and two
foo::bar got three and four


//call_user_func — 把第一个参数作为回调函数调用,类似call
function increment(&$var){
    $var++;
}
$a = 0;
call_user_func('increment', $a);





call_user_func_array — 调用回调函数，并把一个数组参数作为回调函数的参数
call_user_func — 把第一个参数作为回调函数调用
create_function — Create an anonymous (lambda-style) function
forward_static_call_array — Call a static method and pass the arguments as array
forward_static_call — Call a static method
func_get_arg — 返回参数列表的某一项
func_get_args — 返回一个包含函数参数列表的数组
func_num_args — Returns the number of arguments passed to the function
function_exists — 如果给定的函数已经被定义就返回 TRUE
get_defined_functions — 返回所有已定义函数的数组
register_shutdown_function — 注册一个会在php中止时执行的函数
register_tick_function — Register a function for execution on each tick
unregister_tick_function — De-register a function for execution on each tick

