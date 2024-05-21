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
    if (!isset($_POST["forgotemail"])) {
        failure($response, "Please fill all the fields");
        goto end;
    }

    //Check if the email is valid or not
    if (!filter_var($_POST["forgotemail"], FILTER_VALIDATE_EMAIL)) {
        failure($response, "Please enter appropriate email");
        goto end;
    }

    $email = $_POST["forgotemail"];

    $db->begin_transaction();

    $select = $db->prepare("SELECT count(*) as count FROM `adminuser` WHERE `adminemail` = ? ");
    $select->bind_param("s", $email);
    if($select->execute() == false) {
        failure($response, "Error occurred while fetching data");
        $db->rollback();
        goto end;
    }

    $result = $select->get_result();
    $row = $result->fetch_assoc();

    if ($row["count"] == 0) {
        failure($response, "Email not found");
        $db->rollback();
        goto end;
    }

    $token = uniqid();
    $insert = $db->prepare("INSERT INTO `adminforgotpassword` (`adminemail`, `token`) VALUES (?, ?)");
    $insert->bind_param("ss", $email, $token);
    if($insert->execute() == false) {
        failure($response, "Error occurred while inserting data");
        $db->rollback();
        goto end;
    }



    try {
        $emailContent = "<h1>Forgot Password</h1>
        <p>Click the link below to reset your password</p>
        <a href='$siteurl/admin/login/resetpassword.php?adminemail=$email&token=$token'>Reset Password</a>";
        
        //Use global mail variable for sending mail to the dedicated recipient
        global $mail;

        $mail->addAddress($email);

        //Send email as HTML
        $mail->isHTML(true);

        $mail->Subject = "Forgot Password";
        $mail->Body = $emailContent;
        $mail->send();
    } catch (Exception $e) {
        failure($response, "Error sending email - " . $e->getMessage());
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