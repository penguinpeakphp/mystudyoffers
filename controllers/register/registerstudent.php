<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";
    require_once "../functions/validatepassword.php";
    require_once "../functions/mailfunction.php";

    try
    {
        $response["success"] = true;

        //Check if all the fields are filled and received on the server
        if(!isset($_POST["name"]) || !isset($_POST["surname"]) || !isset($_POST["phone"]) || !isset($_POST["email"]) || !isset($_POST["pincode"]) || !isset($_POST["password"]) || $_POST["name"] == "" || $_POST["surname"] == "" || $_POST["phone"] == "" || $_POST["email"] == "" || $_POST["pincode"] == "" || $_POST["password"] == "")
        {
            failure($response , "Please fill in all the details");
            goto end;
        }

        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) 
        {
            failure($response , "Please enter valid email address");
            goto end;
        }

        if(validatePassword($response , $_POST["password"]) == false)
        {
            goto end;
        }

        //Generate the unique activation token which will be used for activating the account
        $activationtoken = uniqid();

        $db->begin_transaction();

        //Query the database for inserting student data into the student table
        $insert = $db->prepare("INSERT INTO student(name , surname , phone , email , password , pincode , activationtoken) VALUES(? , ? , ? , ? , ? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error Occurred while creating student account");
            $db->rollback();
            goto end;
        }
        else
        {
            //Hash the password with the sha512 algorithm
            $password = hash("sha512" , $_POST["password"]);

            //Bind the parameters to the query
            $insert->bind_param("sssssss" , $_POST["name"] , $_POST["surname"] , $_POST["phone"] , $_POST["email"] , $password , $_POST["pincode"] , $activationtoken);

            //Execute the query
            if($insert->execute() == false)
            {
                failure($response , "Error Occurred while creating student account");
                $db->rollback();
                goto end;
            }
        }

        //Get the last auto incremented ID in the table
        $id = $db->insert_id;

        //Send the activation email to the user
        if(sendactivationmail($_POST["email"] , "Verify your email - MyStudyOffers.com" , $activationtoken , $id) == false)
        {
            failure($response , "Error while sending email for activation");
            $db->rollback();
            goto end;
        }

        //Send back some information that is required to be filled in the get parameter in case the email needs to be resent
        $response["id"] = $id;
        $response["email"] = $_POST["email"];
        $response["name"] = $_POST["name"];

        //Commit only if all the actions have been successful
        if($response["success"] == true)
        {
            $db->commit();
        }

        end:;
    }
    catch(Exception $e)
    {
        if($e->getCode() == 1062)
        {
            failure($response , "Account with same details already exists");
        }
        else
        {
            failure($response , "Some Error Occurred - " . $e->getCode());
        }
    }

    echo json_encode($response);
?>