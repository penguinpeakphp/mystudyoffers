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

        //Check if the rankawardingbodyid has been received
        if(!isset($_POST["rankawardingbodyid"]))
        {
            failure($response , "Not enough data for deleting rank awarding body");
            goto end;
        }

        //Query the database for deleting the rankawardingbody with the help of rankawardingbodyid
        $delete = $db->prepare("DELETE FROM rankawardingbody WHERE rankawardingbodyid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the rank awarding body");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["rankawardingbodyid"]);

            //Execute the query
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the rank awarding body");
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