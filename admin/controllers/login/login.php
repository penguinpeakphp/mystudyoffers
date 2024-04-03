<?php
    require_once "../../database/db.php";
    require_once "../globalfunctions.php";

    $response["success"] = true;
    if(!isset($_SESSION))
    {
        session_start();
    }

    try
    {
        //Check if the email is valid or not
        if(!filter_var($_POST["email"] , FILTER_VALIDATE_EMAIL))
        {
            failure($response , "Please enter appropriate email");
            goto end;
        }

        //Check if both email and password has been submitted by the user
        if(!isset($_POST["email"]) || !isset($_POST["password"]))
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        if($_POST["email"] != "admin@admin.com" || $_POST["password"] != "admin")
        {
            failure($response , "Login Failed");
            goto end;
        }

        //Set the session variables
        $_SESSION["email"] = $_POST["email"];

        end:;
    }
    catch(Exception  $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>