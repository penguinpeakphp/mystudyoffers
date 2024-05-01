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

        //Check if the followuptemplate has been received
        if(!isset($_POST["followuptemplateid"]))
        {
            failure($response , "Not enough data for deleting follow up template");
            goto end;
        }

        //Query the database for deleting the followuptemplate with the help of followuptemplateid
        $delete = $db->prepare("DELETE FROM followuptemplate WHERE followuptemplateid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the follow up template");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["followuptemplateid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the follow up template");
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