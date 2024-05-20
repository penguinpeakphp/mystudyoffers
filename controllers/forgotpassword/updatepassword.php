<?php
require_once "../../admin/database/db.php";
require_once "../functions/globalfunctions.php";

try 
{
    $response["success"] = true;

    if (
        !isset($_POST["password"]) || empty($_POST["password"]) ||
        !isset($_POST["cpassword"]) || empty($_POST["cpassword"]) ||
        !isset($_POST["token"]) || empty($_POST["token"]) ||
        !isset($_POST["email"]) || empty($_POST["email"])
    ) 
    {
        failure($response, "Incomplete data provided");
        goto end;
    }

    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $token = $_POST["token"];
    $email = $_POST["email"];

    if ($password != $cpassword) 
    {
        failure($response, "Passwords do not match");
        goto end;
    }

    $check = $db->prepare("SELECT * FROM `studentforgotpassword` WHERE `email` = ? AND `token` = ?");
    $check->bind_param("ss", $email, $token);
    if ($check->execute() === false) 
    {
        failure($response, "Error while checking for token");
        goto end;
    }
    $result = $check->get_result();
    if ($result->num_rows == 0) 
    {
        failure($response, "Error while checking for token");
        goto end;
    }

    $password = hash("sha512", $password);

    $db->begin_transaction();

    $update = $db->prepare("UPDATE `student` SET `password` = ? WHERE `email` = ?");
    $update->bind_param("ss", $password, $email);
    if ($update->execute() === false) 
    {
        failure($response, "Error while setting new password");
        $db->rollback();
        goto end;
    }

    $delete = $db->prepare("DELETE FROM `studentforgotpassword` WHERE `email` = ?");
    $delete->bind_param("s", $email);
    if ($delete->execute() === false) 
    {
        failure($response, "Error while deleting old token");
        $db->rollback();
        goto end;
    }

    if($response["success"] == true)
    {
        $db->commit();
    }

    end:;
} catch (Exception $e) 
{
    failure($response, "Error Occurred while processing your request - " . $e->getCode());
}

echo json_encode($response);
?>