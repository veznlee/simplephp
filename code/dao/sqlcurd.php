<?php

// 用户相关的CRUD操作
$sql_user = array(
    "queryById"=> 'select * from users where uid=?',
    "add"=> 'insert into users set ?',
    "hasUser"=> 'select count(*) as userCount,ubalance from users where uid=? group by ubalance',
    "update"=> 'update users set ? where uid=?',
    "getBoughtBooks"=> 'select books.bkid,bkname,bkfile,bkcover from books right join orders on books.bkid=orders.bkid right join users on users.uid=orders.uid where users.skey=?',
    "getBalance"=> 'select ubalance,uid from users where skey=?',
    "reduceBalance"=> 'update users set ubalance=? where uid=?',
    "getId"=> 'select users.uid,users.uname,comment.ctime from users left join comment on comment.uid=users.uid where users.skey=? and comment.ccontent=?'
);

// 书籍相关的CRUD操作
$sql_book = array(
    "queryById"=> 'select * from books where bkid=?',
    "queryAll"=> 'select * from books',
    "queryBookBySkey"=> 'select count(*) as buyCount from orders left join users on users.uid=orders.uid where users.skey=? and orders.bkid=?',
    "getPrice"=> 'select bkprice from books where bkid=?'
);

// 评论相关的CRUD操作
$sql_comment = array(
    "queryById"=> 'select * from comments where bkid=?',
    "addComment"=> 'insert into comment (uid,uname,uavatar,bkid,bkname,ccontent) select uid,uname,uavatar,?,(select bkname from books where bkid=?),? from users where users.skey=?',
    "queryComments"=> 'select * from comment where bkid=? limit 0,10'
);

// 订单相关的CRUD操作
$sql_order = array(
    "queryById"=> 'select * from orders where bkid=?',
    "buyBook"=> 'insert into orders (uid,oprice,bkid) VALUES (?,?,?)'
);

// 接口凭据相关的CRUD操作
$sql_access = array(
    "queryToken"=> 'select token from access'
);


return array(
    "user"=>$sql_user,
    "book"=>$sql_book,
    "comment"=>$sql_comment,
    "order"=>$sql_order,
    "access"=>$sql_access
)