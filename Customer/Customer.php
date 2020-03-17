<?php

class Customer {
    private $id;
    private $name;
    private $phone;
    private $ewallet;

    public function __construct($id, $name , $phone , $ewallet) {
        // YOUR CODE GOES HERE
        $this-> id = $id;
        $this -> name = $name;
        $this -> phone = $phone;
        $this -> ewallet = $ewallet;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        // YOUR CODE GOES HERE
        return $this->name;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getEwallet() {
        // YOUR CODE GOES HERE
        return $this->ewallet;
    }
}

?>