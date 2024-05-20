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
        $select = $db->prepare("SELECT count(*) as count FROM student WHERE email = ?");
        if(!$select) 
        {
            failure($response , "Error while checking email");
            goto end;
        }
        $select->bind_param("s", $email);
        if($select->execute() === false) 
        {
            failure($response , "Error while checking email");
            goto end;
        }

        $result = $select->get_result();

        if($result->num_rows == 0) 
        {
            failure($response , "Email not found");
            goto end;
        }
        else 
        {
            $token = uniqid();
            $insert = $db->prepare("INSERT INTO studentforgotpassword (email, token) VALUES (?, ?)");
            if(!$insert) 
            {
                failure($response , "Error Occurred while generating token");
                goto end;
            }

            $insert->bind_param("ss", $email, $token);
            if($insert->execute() === false)
            {
                failure($response , "Error Occurred while generating token");
                goto end;
            }
            // if(sendrecoverymail($email, "Forgot Password", $token) === false)
            // {
            //     failure($response , "Error Occurred while sending mail");
            //     goto end;
            // }

            echo sendrecoverymail($email, "Forgot Password", $token);
            
        }
        end:;
    } 
    catch(Exception $e)
    {
        failure($response , "Error Occurred while processing your request - " . $e->getCode());
    }

    echo json_encode($response);
?>