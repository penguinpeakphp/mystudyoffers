<?php
require_once "../../database/db.php";
require_once "../globalfunctions.php";
require_once "../../../controllers/globaldata.php";

$response["success"] = true;
if (!isset($_SESSION)) {
    session_start();
}

try {
    
    //Check if both email and password has been submitted by the user
    if (!isset($_POST["password"]) || !isset($_POST["cpassword"]) || !isset($_POST["adminemail"]) || !isset($_POST["token"])) {
        failure($response, "Please fill all the fields");
        goto end;
    }

    $email = $_POST["adminemail"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $token = $_POST["token"];

    if ($password != $cpassword) { 
        failure($response, "Passwords do not match");
        goto end;
    }

    $hashedpassword = hash("sha512", $password);

    $db->begin_transaction();

    $select = $db->prepare("SELECT * FROM `adminforgotpassword` WHERE `adminemail` = '$email' AND `token` = '$token'");
    if ($select->execute() == false) {
        failure($response, "Some Error Occurred while selecting the token");
        $db->rollback();
        goto end;
    }
    $result = $select->get_result();
    if ($result->num_rows == 0) 
    {
        failure($response, "Error while checking for token");
        goto end;
    }

    $update = $db->prepare("UPDATE `adminuser` SET `adminpassword` = '$hashedpassword' WHERE `adminemail` = '$email'");
    if ($update->execute() == false) {
        failure($response, "Some Error Occurred while updating the password");
        $db->rollback();
        goto end;
    }

    $delete = $db->prepare("DELETE FROM `adminforgotpassword` WHERE `adminemail` = '$email' AND `token` = '$token'");
    if ($delete->execute() == false) {
        failure($response, "Some Error Occurred while deleting the token");
        $db->rollback();
        goto end;
    }

    if($response["success"] == true) {
        $db->commit();
    }
    
    end:;
} catch (Exception  $e) {
    $response["success"] = false;
    $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
}

echo json_encode($response);
?>