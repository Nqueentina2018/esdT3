<?php

require_once 'Customer.php';
require_once 'ConnectionManager.php';

class CustDAO {
    
    // This public function is callable from OUTSIDE 'CatDAO' class
    // By calling this function, the caller can retrieve ALL rows from 'cat' Database table
    // It returns an indexed Array of Cat objects
    public function getCust() {
        
        // STEP 1
        // Connect to database 'animals'
        // See 'ConnectionManager.php'
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();
        

        // STEP 2
        // Prepare SQL statement
        $sql = "SELECT id , name , phone , ewallet FROM customer";
        $stmt = $conn->prepare($sql);
        

        // STEP 3
        // Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // Retrieve each row as an Associative Array
        

        // STEP 4
        // Retrieve query results - ONE ROW AT A TIME
        $customers = [];
        // Initialize an empty (indexed) Array
        // so I can return it to whoever called this function
        // Use WHILE loop to loop through
        while ($row = $stmt->fetch() ) {
            // $row is associative array 
            // key ==table column name (name,age)
            $customer = new Customer( 
                $row['id'], 
                $row['name'], 
                $row['name'], 
                $row['ewallet'] 
            );
            $customers[] = $customer;
        }

        
        // STEP 5
        // Close DB Connection & SQL Statement
        $stmt = null;
        $conn = null;        
        

        // STEP 6
        // YAY! We're ready to return the array!
        return $customers;
    }

    // returns an Indexed Array of cats with a given 'status'
    public function getCustByID($id) {
        // STEP 1
        // Connect to database 'animals'
        // See 'ConnectionManager.php'
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();
        

        // STEP 2
        // Prepare SQL statement
        $sql = "SELECT id , name , phone , ewallet FROM customer where id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        

        // STEP 3
        // Run SQL
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // Retrieve each row as an Associative Array
        

        // STEP 4
        // Retrieve query results - ONE ROW AT A TIME
        $cats = [];
        // Initialize an empty (indexed) Array
        // so I can return it to whoever called this function
        // Use WHILE loop to loop through
        while ($row = $stmt->fetch() ) {
            $customer = new Customer( 
                $row['id'], 
                $row['name'], 
                $row['name'], 
                $row['ewallet'] 
            );
            $customers[] = $customer;
        }

        
        // STEP 5
        // Close DB Connection & SQL Statement
        $stmt = null;
        $conn = null;        
        

        // STEP 6
        // YAY! We're ready to return the array!
        return $customers;
    }

    // public function getCatsFilter($status,$gender) {
    //     // STEP 1
    //     // Connect to database 'animals'
    //     // See 'ConnectionManager.php'
    //     $connMgr = new ConnectionManager();
    //     $conn = $connMgr->connect();
        

    //     // STEP 2
    //     // Prepare SQL statement
    //     $sql = "SELECT name, age, gender, status FROM cat WHERE status = :status AND gender = :gender ";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    //     $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);

    //     // STEP 3
    //     // Run SQL
    //     $stmt->execute();
    //     $stmt->setFetchMode(PDO::FETCH_ASSOC);
    //     // Retrieve each row as an Associative Array
        

    //     // STEP 4
    //     // Retrieve query results - ONE ROW AT A TIME
    //     $cats = [];
    //     // Initialize an empty (indexed) Array
    //     // so I can return it to whoever called this function
    //     // Use WHILE loop to loop through
    //     while ($row = $stmt->fetch() ) {
    //         $cat = new Cat( $row['name'], $row['age'], $row['gender'], $row['status'] );
    //         $cats[] = $cat;
    //     }

        
    //     // STEP 5
    //     // Close DB Connection & SQL Statement
    //     $stmt = null;
    //     $conn = null;        
        

    //     // STEP 6
    //     // YAY! We're ready to return the array!
    //     return $cats;
    // }
}
