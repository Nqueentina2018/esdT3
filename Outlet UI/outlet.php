<?php

class Outlet{
    //property declaration
    private $outletid;
    private $hashedpassword;
    private $name;

    public function __construct($outletid, $hashedpassword){
        $this->outletid = $outletid;
        $this->hashedpassword = $hashedpassword;
    }

    public function getOutletid(){
        return $this->outletid;
    }

    public function getPassword(){
        return $this->hashedpassword;
    }

    public function getName(){
        return $this->name;
    }

    public function authenticate($enteredPwd) {
        return password_verify ($enteredPwd, $this->hashedpassword);
    }
}
?>