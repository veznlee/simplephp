<?php
可以用 array() 语言结构来新建一个数组。它接受任意数量用逗号分隔的 键（key） => 值（value）对。
array(  key =>  value
     , ...
     )
// 键（key）可是是一个整数 integer 或字符串 string
// 值（value）可以是任意类型的值
$a = array( 'color' => 'red',
	'taste' => 'sweet',
	'shape' => 'round',
	'name'  => 'apple',
	4        // key will be 0
  );
// . . .is completely equivalent with this:
$a = array();
$a['color'] = 'red';
$a['taste'] = 'sweet';
$a['shape'] = 'round';
$a['name']  = 'apple';
$a[]        = 4;        // key will be 0


$b = array('a', 'b', 'c');
// . . .is completely equivalent with this:
$b = array();
$b[] = 'a';
$b[] = 'b';
$b[] = 'c';
// After the above code is executed, $a will be the array
// array('color' => 'red', 'taste' => 'sweet', 'shape' => 'round', 
// 'name' => 'apple', 0 => 4), and $b will be the array 
// array(0 => 'a', 1 => 'b', 2 => 'c'), or simply array('a', 'b', 'c').


	
	
此外 key 会有如下的强制转换：

包含有合法整型值的字符串会被转换为整型。例如键名 "8" 实际会被储存为 8。
但是 "08" 则不会强制转换，因为其不是一个合法的十进制数值。

浮点数也会被转换为整型，意味着其小数部分会被舍去。例如键名 8.7 实际会被储存为 8。
布尔值也会被转换成整型。即键名 true 实际会被储存为 1 而键名 false 会被储存为 0。
Null 会被转换为空字符串，即键名 null 实际会被储存为 ""。
数组和对象不能被用为键名。坚持这么做会导致警告：Illegal offset type。

如果在数组定义中多个单元都使用了同一个键名，则只使用了最后一个，之前的都被覆盖了。
	
	$array = array(
		1    => "a",
		"1"  => "b",
		1.5  => "c",
		true => "d",
	);
	var_dump($array);
	
以上例程会输出：
array(1) {
  [1]=>
  string(1) "d"
}
上例中所有的键名都被强制转换为 1，则每一个新单元都会覆盖前一个的值，最后剩下的只有一个 "d"。


key 为可选项。如果未指定，PHP 将自动使用之前用过的最大 integer 键名加上 1 作为新的键名。
$array = array(
         "a",
         "b",
    6 => "c",
         "d",
);
var_dump($array);
以上例程会输出：
array(4) {
  [0]=>
  string(1) "a"
  [1]=>
  string(1) "b"
  [6]=>
  string(1) "c"
  [7]=>
  string(1) "d"
}
可以看到最后一个值 "d" 被自动赋予了键名 7。这是由于之前最大的整数键名是 6。




unset() 函数允许删除数组中的某个键。但要注意数组将不会重建索引。
如果需要删除后重建索引，可以用 array_values() 函数。
$a = array(1 => 'one', 2 => 'two', 3 => 'three');
unset($a[2]);
/* will produce an array that would have been defined as
   $a = array(1 => 'one', 3 => 'three');
   and NOT
   $a = array(1 => 'one', 2 =>'three');
*/

$b = array_values($a);
// Now $b is array(0 => 'one', 1 =>'three')


unset($a);//删除整个数组，$a被删除后值为null
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
>