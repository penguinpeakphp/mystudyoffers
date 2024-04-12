<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Start the session for storing information of the user
        session_start();

        //Check if email and password has been supplied
        if(!isset($_POST["email"]) || !isset($_POST["password"]) || $_POST["email"] == "" || $_POST["password"] == "")
        {
            failure($response , "Please fill in all the information");
            goto end;
        }
        
        //Get the student with specified email
        $select = $db->prepare("SELECT * FROM student WHERE email = ?");
        if($select == false)
        {
            failure($response , "Error while checking the credentials");
            goto end;
        }
        else
        {
            $select->bind_param("s" , $_POST["email"]);
            if($select->execute() == false)
            {
                failure($response , "Error while checking the credentials");
                goto end;
            }
            $result = $select->get_result();

            //Check if the user exists in the database or not
            if(mysqli_num_rows($result) == 0)
            {
                failure($response , "Your account does not exists");
                goto end;
            }
            
            //Fetch a single row
            $row = $result->fetch_assoc();

            //Check if the password matches with the original one after hashing the supplied one
            if($row["password"] != hash("sha512" , $_POST["password"]))
            {
                failure($response , "Wrong email/password entered");
                goto end;
            }

            //Check if the user is active or not
            if($row["status"] == false)
            {
                failure($response , "You have not activated your account");
                goto end;
            }

            //Set the session with the variables
            $_SESSION["name"] = $row["name"];
            $_SESSION["email"] = $row["email"];
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while logging in - " . $e->getCode());
    }

    echo json_encode($response);
?>