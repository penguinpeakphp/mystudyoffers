<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";
    require_once "../functions/mailfunction.php";

    try 
    {
        $response["success"] = true;

        //Check if the email is provided
        if(!isset($_POST["email"]) || empty($_POST["email"])) 
        {
            failure($response , "Please provide email");
            goto end;
        }

        $email = $_POST["email"];

        //Query the database for checking the email existence
        $select = $db->prepare("SELECT count(*) as count FROM student WHERE email = ?");
        if(!$select) 
        {
            failure($response , "Error while checking email");
            goto end;
        }

        //Bind the parameters
        $select->bind_param("s", $email);

        //Execute the query
        if($select->execute() === false) 
        {
            failure($response , "Error while checking email");
            goto end;
        }

        //Get the results
        $result = $select->get_result();

        //If the email is not found in the forgot password token table
        if($result->num_rows == 0) 
        {
            failure($response , "Email not found");
            goto end;
        }
        else 
        {
            //Generate the token
            $token = uniqid();

            //Insert the token in the forgot password table
            $insert = $db->prepare("INSERT INTO studentforgotpassword (email, token) VALUES (?, ?)");
            if(!$insert) 
            {
                failure($response , "Error Occurred while generating token");
                goto end;
            }

            //Bind the parameters
            $insert->bind_param("ss", $email, $token);

            //Execute the query
            if($insert->execute() === false)
            {
                failure($response , "Error Occurred while generating token");
                goto end;
            }

            //Send the recovery email
            if(sendrecoverymail($email, "Forgot Password", $token) === false)
            {
                failure($response , "Error Occurred while sending mail");
                goto end;
            }            
        }
        end:;
    } 
    catch(Exception $e)
    {
        failure($response , "Error Occurred while processing your request");
    }

    echo json_encode($response);
?>