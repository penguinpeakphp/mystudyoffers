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

        //Check if the qualificaltionid has been received
        if(!isset($_POST["qualificationid"]))
        {
            failure($response , "Not enough data for deleting qualification");
            goto end;
        }

        //Query the database for deleting the qualification with the help of qualificationid
        $delete = $db->prepare("DELETE FROM qualification WHERE qualificationid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the qualification");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["qualificationid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the qualification");
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