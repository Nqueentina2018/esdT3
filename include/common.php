<?php


// this will autoload the class that we need in our code
spl_autoload_register(function($class) {
 
    // we are assuming that it is in the same directory as common.php
    // otherwise we have to do
    // $path = 'path/to/' . $class . ".php"    
    require_once "$class.php"; 
  
});

// session related stuff

session_start();

function printErrors() {
    if(isset($_SESSION['errors'])){
        echo "<table border='1'>";  
        echo "<tr>
                <th>Error</th>";
        foreach ($_SESSION['errors'] as $value) {
            echo "<tr>
            <td style = 'color:red;'>" . $value . "</td>
            </tr>";
        }
        echo "</table>";   
        unset($_SESSION['errors']);
    }    
}

function printErrorsFloat() {    
    if(isset($_SESSION['errors'])){
        echo "<table border='1' style='width:80%; float:left;'>";   
        echo "<tr>
                <th>Error</th>";
        foreach ($_SESSION['errors'] as $value) {
            echo "<tr>
            <td style = 'color:red;'>" . $value . "</td>
            </tr>";
        }
        echo "</table>";   
        unset($_SESSION['errors']);
    }    
}


# this is better than empty when use with array, empty($var) returns FALSE even when
# $var has only empty cells
function isEmpty($var) {
    if (isset($var) && is_array($var))
        foreach ($var as $key => $value) {
            if (empty($value)) {
               unset($var[$key]);
            }
        }

    if (empty($var))
        return TRUE;
}


function printSuccess() {
    if(isset($_SESSION['success'])){
        echo "<table border='1'>";

        foreach ($_SESSION['success'] as $value) {
            echo "<tr>
            <td style='color:DarkGreen;'>" . $value . "</td>
            </tr>";
        }
        echo "</table>";
        unset($_SESSION['success']);
    }    
}

function printSuccessFloat() {
    if(isset($_SESSION['success'])){
        echo "<table border='1' style='width:80%; float:left;'>";

        foreach ($_SESSION['success'] as $value) {
            echo "<tr>
            <td style='color:DarkGreen;'>" . $value . "</td>
            </tr>";
        }
        echo "</table>";
        unset($_SESSION['success']);
    }    
}

function isMissingOrEmpty($user) {
    if (!isset($_REQUEST[$user])) {
        return "$user cannot be empty";
    }

    // client did send the value over
    $value = $_REQUEST[$user];
    if (empty($value)) {
        return "$user cannot be empty";
    }
}

function isEmptyString($myStr) {
    if (isset($myStr) && $myStr === "") {
        return TRUE;
    } else {
        return FALSE;
    }
}

function commonValidationsJSON($filename) {
    $mandatoryFields = [
		"authenticate.php" => ["password", "username"],
    ];
    $commonValidationErrors = array();
	
	if (array_key_exists($filename, $mandatoryFields)) {
        $fieldsToCheck = $mandatoryFields[$filename];
        $request = null;
        if (isset($_REQUEST['r'])) {
            $request = json_decode($_REQUEST['r']);
        }

		foreach ($fieldsToCheck as $field) {
            if ($field == "token" || $filename == "authenticate.php") {
                if (!isset($_REQUEST[$field])) {
                    $commonValidationErrors[] = "missing $field";
                } elseif (empty($_REQUEST[$field])) {
                    $commonValidationErrors[] = "blank $field";
                } elseif ($field == "token") {
                    $token = $_REQUEST["token"];
                    $isValid = verify_token($token);
                    if (!$isValid || $isValid != "admin") {
                        $commonValidationErrors[] = "invalid token";
                    }
                }
            } elseif ($request) {
                if (!isset($request->{$field})) {
                    $commonValidationErrors[] = "missing $field";
                } elseif (isEmptyString($request->{$field})) {
                    $commonValidationErrors[] = "blank $field";
                }
            } else {
                $commonValidationErrors[] = "missing $field";
            }
		}
	}
	
    return $commonValidationErrors;
}

function jsonErrors($errors) {
    $result = [
        "status" => "error",
        "message" => array_values($errors)
    ];
    return $result;
}

?>