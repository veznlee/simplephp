<?php

include 语句包含并运行指定文件。

以下文档也适用于 require。

被包含文件先按参数给出的路径寻找，如果没有给出目录（只有文件名）时则
按照 include_path 指定的目录寻找。如果在 include_path 下没找到该文件则
 include 最后才在调用脚本文件所在的目录和当前工作目录下寻找。
 如果最后仍未找到文件则 include 结构会发出一条警告；
 这一点和 require 不同，后者会发出一个致命错误。
 
 
 
 当一个文件被包含时，其中所包含的代码继承了 include 所在行的变量范围。
 从该处开始，调用文件在该行处可用的任何变量在被调用的文件中也都可用。
 不过所有在包含文件中定义的函数和类都具有全局作用域。
 
 
 
vars.php
<?php

$color = 'green';
$fruit = 'apple';

?>

test.php
<?php

echo "A $color $fruit"; // A

include 'vars.php';

echo "A $color $fruit"; // A green apple



如果 include 出现于调用文件中的一个函数里，
则被调用的文件中所包含的所有代码将表现得如同它们是在该函数内部定义的一样。
所以它将遵循该函数的变量范围。此规则的一个例外是魔术常量，
它们是在发生包含之前就已被解析器处理的。
function foo()
{
    global $color;

    include 'vars.php';

    echo "A $color $fruit";
}

/* vars.php is in the scope of foo() so     *
 * $fruit is NOT available outside of this  *
 * scope.  $color is because we declared it *
 * as global.                               */

foo();                    // A green apple
echo "A $color $fruit";   // A green

因为 include 是一个特殊的语言结构，其参数不需要括号。在比较其返回值时要注意。
// won't work, evaluated as include(('vars.php') == 'OK'), i.e. include('')
if (include('vars.php') == 'OK') {
    echo 'OK';
}

// works
if ((include 'vars.php') == 'OK') {
    echo 'OK';
}

require 和 include 几乎完全一样，除了处理失败的方式不同之外。require 在出错时产生 E_COMPILE_ERROR 级别的错误。
换句话说将导致脚本中止而 include 只产生警告（E_WARNING），脚本会继续运行。


require_once 语句和 require 语句完全相同，唯一区别是 PHP 会检查该文件是否已经被包含过，如果是则不会再次包含。
include_once 和 include 语句类似，唯一区别是如果该文件中已经被包含过，则不会再次包含。如同此语句名字暗示的那样，只会包含一次。


?>