<?php

require_once 'CustDAO.php';
$dao = new CustDAO();

// if (isset($_POST['Status'])){
//     $cats=$dao->getCatsByStatus($_POST['Status']);
//     }
// else{
//     $cats = $dao->getCatsByStatus('A');
// }
// var_dump($_POST);

$customers = $dao->getCust();

if (isset($_POST['id'])){
    $customer = $dao->getCustByID($id);
    $result = [
        'id' => $customer->getId(),
        'name' => $customer->getName(),
        'phone' => $customer->getPhone(),
        'ewallet' => $customer->getEwallet()
    ];
}
else{
    $customers = $dao->getCust();
    foreach ($customers as $customer){
        $result = [
            'id' => $customer->getId(),
            'name' => $customer->getName(),
            'phone' => $customer->getPhone(),
            'ewallet' => $customer->getEwallet()
        ];
    }
}

// if (!isEmpty($errors)) {
//     $result = [
//         "status" => "error",
//         "message" => $errors
//         ];
// }
// else {

//     // if ( $username==$db_user && $password==$db_pass){
//     if (empty($errors)){

//         $result = [
//             'id' => $ewallet
//         ];
//     }
//     else {
//         $result = ['status' => 'error',
//                     'message' => $errors];
//     }

// }

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);
?>