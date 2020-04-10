<?php
    require_once '../include/common.php';
    require_once '../include/protect.php';

    if(!isset($_POST['userid']) || !isset($_POST['password'])) {
        $_SESSION['errors'][] = "Please enter your login details";
        header("Location: login.php");
        exit();
    }

    $userid = $_POST['userid'];
    $password = $_POST['password'];

    //Validation for outlet admin
    if ($userid === 'outlet' && $password === '123') {
        header("Location: ../Outlet UI/index.html");
        // $outletDAO = new OutletDAO();
        // $outlet = $outletDAO->retrieve($outletid);

        // if ( $outlet != null && $outlet->getPassword() == $password ) {
        //     $_SESSION['userid'] = $userid; 
        //     header("Location: ../Outlet UI/index.html"); // connect to store UI here
        //     exit();

        // }


    } else {
        //Validation for customer - how to link this to customer.py?
        if ($userid === 'customer' && $password === '123'){
            header("Location: http://localhost/esd/OBTOS%20UI/");
        }
            
        // $CustomerDAO = new CustomerDAO();
        // $customer = $customerDAO->retrieve($userid);

        // if ( $customer != null && $customer->getPassword() == $password ) {
        //     $_SESSION['userid'] = $userid; 
        //     header("Location: wallet.php"); // routes to the wallet
        //     exit();

        // }
    }
        
    $_SESSION['errors'][] = 'Invalid username / password';
    header("Location: login.php");
    exit();
?>