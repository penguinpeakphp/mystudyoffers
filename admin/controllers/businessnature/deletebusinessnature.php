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

        //Check if the businessid has been received
        if(!isset($_POST["businessid"]))
        {
            failure($response , "Not enough data for deleting business nature");
            goto end;
        }

        //Query the database for deleting the business nature with the help of businessid
        $delete = $db->prepare("DELETE FROM businessnature WHERE businessid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the business nature");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["businessid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the business nature");
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