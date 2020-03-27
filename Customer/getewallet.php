<?php

require_once 'CustDAO.php';
$dao = new CustDAO();

$errors=[];

if (isset($_POST['id'])){
    $ewallet=$dao->getEwalletByID($_POST['id']);
    }
else{
    $errors[] = 'missing id';
}
var_dump($_POST);

$customers = $dao->getCust();


if (!isEmpty($errors)) {
    $result = [
        "status" => "error",
        "message" => $errors
        ];
}
else {

    // if ( $username==$db_user && $password==$db_pass){
    if (empty($errors)){

        $result = [
            'id' => $ewallet
        ];
    }
    else {
        $result = ['status' => 'error',
                    'message' => $errors];
    }

}

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);
 
?>
