<?php

include '../service/DBAconn.php';

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

    }

    public function getUserBalance($skey) {
        
    }

    public function getUserId($skey,$content){

    }
}