<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";
    require_once "../functions/mailfunction.php";

    try 
    {
        var_dump($_POST);
        if(!isset($_POST["email"]) || empty($_POST["email"])) 
        {
            failure($response , "Please provide email");
            goto end;
        }

        $email = $_POST["email"];
        $stmt = $db->prepare("SELECT count(*) as count FROM student WHERE email = ?");
        if(!$stmt) 
        {
            failure($response , "Error Occurred while processing your request - " . $db->errno);
            goto end;
        }
        $stmt->bind_param("s", $email);
        if($stmt->execute() === false) 
        {
            failure($response , "Error Occurred while processing your request - " . $stmt->errno);
            goto end;
        }

        $result = $stmt->get_result();

        if($result->num_rows == 0) 
        {
            failure($response , "Email not found");
            goto end;
        }
        else 
        {
            $token = uniqid();
            $stmt = $db->prepare("INSERT INTO studentforgotpassword (email, token) VALUES (?, ?)");
            if(!$stmt) 
            {
                failure($response , "Error Occurred while processing your request - " . $db->errno);
                goto end;
            }

            $stmt->bind_param("ss", $email, $token);
            if($stmt->execute() === false)
            {
                failure($response , "Error Occurred while processing your request - " . $stmt->errno);
                goto end;
            }
            if(sendrecoverymail($email, "Forgot Password", $token) === false)
            {
                failure($response , "Error Occurred while processing your request - " . $stmt->errno);
                goto end;
            }
            
        }
        end:;
    } 
    catch(Exception $e)
    {
        failure($response , "Error Occurred while processing your request - " . $e->getCode());
    }

    echo json_encode($response);
?>