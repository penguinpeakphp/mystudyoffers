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

        //Check if all the fields are set and have some value
        if(!isset($_POST["awardingbodyid"]) || !isset($_POST["awardingbodyname"]) || !isset($_POST["awardingbodystatus"]) || !isset($_POST["academicid"]) || $_POST["awardingbodyid"] == "" || $_POST["awardingbodyname"] == "" || $_POST["awardingbodystatus"] == "" || $_POST["academicid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing awarding body based on the awardigbodyid
        $update = $db->prepare("UPDATE awardingbody SET awardingbodyname = ? , awardingbodystatus = ? , academicid = ? WHERE awardingbodyid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the awarding body");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("siii" , $_POST["awardingbodyname"] , $_POST["awardingbodystatus"] , $_POST["academicid"] , $_POST["awardingbodyid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the awarding body");
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