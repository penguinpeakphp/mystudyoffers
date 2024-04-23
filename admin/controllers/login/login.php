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

        //Query the database to fetch the respective user
        $select = $db->prepare("SELECT adminid , email , password , canaccessmaster FROM adminuser WHERE email = ?");
        if($select == false)
        {
            failure($response , "Error checking your credentials");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_POST["email"]);
            
            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error checking your credientials");
                goto end;
            }

            $result = $select->get_result();

            //Check if the user exists or not
            if(mysqli_num_rows($result) == 0)
            {
                failure($response , "Wrong email/password entered");
                goto end;
            }

            //Fetch a row
            $row = $result->fetch_assoc();

            //Check hash passwords for authentication
            if($row["password"] != hash("sha512" , $_POST["password"]))
            {
                failure($response , "Wrong email/password entered");
                goto end;
            }
        }

        //Set the session variables
        $_SESSION["adminemail"] = $_POST["email"];
        $_SESSION["adminid"] = $row["adminid"];
        $_SESSION["canaccessmaster"] = $row["canaccessmaster"];

        end:;
    }
    catch(Exception  $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>