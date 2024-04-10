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

        //Check if the awardingbodyid has been received
        if(!isset($_POST["awardingbodyid"]))
        {
            failure($response , "Not enough data for deleting awarding body");
            goto end;
        }

        //Query the database for deleting the awardingbody with the help of awardingbodyid
        $delete = $db->prepare("DELETE FROM awardingbody WHERE awardingbodyid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the awarding body");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["awardingbodyid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error wihle deleting the awarding body");
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