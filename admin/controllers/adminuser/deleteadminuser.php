<?php
    require_once "../../database/db.php";
    require_once "../globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check session and go to end if session verification is failed
        if(checksession($response) == false)
        {
            goto end;
        }

        //Check if the adminid has been received
        if(!isset($_POST["adminid"]))
        {
            failure($response , "Not enough data for admin");
            goto end;
        }

        //Query the database for deleting the admin user with the help of adminid
        $delete = $db->prepare("DELETE FROM adminuser WHERE adminid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the admin user");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["adminid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the admin user");
                goto end;
            }
        }

        end:;
    }
    catch(Exception  $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>