<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";
    require_once "../functions/validatepassword.php";

    try
    {
        $response["success"] = true;

        //Check in the session if the user has logged in
        if(checksession($response) == false)
        {
            goto end;
        }

        if(!isset($_POST["npassword"]) || !isset($_POST["cpassword"]) ||
            empty($_POST["npassword"]) || empty($_POST["cpassword"]))
        {
            failure($response , "All fields are required");
            goto end;
        }

        if($_POST["npassword"] != $_POST["cpassword"])
        {
            failure($response , "Passwords do not match");
            goto end;
        }

        if(validatePassword($response , $_POST["npassword"]) == false)
        {
            goto end;
        }

        $update = $db->prepare("UPDATE student SET password = ? WHERE studentid = ?");

        $hashedpassword = hash("sha512", $_POST["npassword"]);
        $update->bind_param("si", $hashedpassword, $_SESSION["studentid"]);

        if($update->execute() == false)
        {
            failure($response , "Error Occurred while updating the password");
            goto end;
        }

        $response["message"] = "Password updated successfully";
        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred : " . $e->getCode());
    }

    echo json_encode($response);
?>