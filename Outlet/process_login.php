<?php

    $userid = $_POST['userid'];
    $password = $_POST['password'];

    //Validation for outlet admin
    if ($userid === 'outlet' && $password === '123') {
        header("Location: orders.html");
        exit();
        // $outletDAO = new OutletDAO();
        // $outlet = $outletDAO->retrieve($outletid);

        // if ( $outlet != null && $outlet->getPassword() == $password ) {
        //     $_SESSION['userid'] = $userid; 
        //     header("Location: ../Outlet UI/index.html"); // connect to store UI here
        //     exit();

        // }
    } 

    header("Location: login.php");
    exit();
?>