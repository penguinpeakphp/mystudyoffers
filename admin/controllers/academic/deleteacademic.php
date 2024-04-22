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

        //Check if the academicid has been received
        if(!isset($_POST["academicid"]))
        {
            failure($response , "Not enough data for deleting academic qualification");
            goto end;
        }

        //Query the database for deleting the academic with the help of academicid
        $delete = $db->prepare("DELETE FROM academic WHERE academicid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the academic");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["academicid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the academic qualification");
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