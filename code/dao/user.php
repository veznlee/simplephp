<?php

include '../service/DBAconn.php';
include '../service/request.php';

$sqlcurd = include 'sqlcurd.php';
$uc = $sqlcurd['user'];

class User {
    private _name;

    public function setName($_name) {
        $this->_name = $_name;
    }

    public function getName() {
        return $this->_name;
    }

    public function saveUserInfo($userInfo, $session_key, $skey){

    }

    public function getBoughtBooks($skey) {
        $sql = "select books.bkid,bkname,bkfile,bkcover from books right join orders on books.bkid=orders.bkid right join users on users.uid=orders.uid where users.skey=?";
        $res = DBAccess::getRows($sql, $skey);
        return $res;
    }

    public function getUserBalance($skey) {
        
    }

    public function getUserId($skey,$content){

    }
}