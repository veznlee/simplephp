<?php

$test = 'hello,world';
abc();//这里什么都不输出，因为访问不到$test变量
function abc(){
	echo($test);
}




我们可以使用global关键字来声明变量，上面的例子就变成了这样
$test = 'hello,world';
abc(); 
function abc(){
	global $test;
	echo $test;
}




这就可以了，在全局范围内访问变量的第二个办法，是用特殊的PHP自定义 $GLOBALS 数组。前面的例子可以写成：
$test = 'hello,world';
function abc(){
	echo $GLOBALS['test'];
}
abc();