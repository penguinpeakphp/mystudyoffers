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
        if(!isset($_POST["rankawardingbodyid"]) || !isset($_POST["rankawardingbodyname"]) || !isset($_POST["rankawardingbodystatus"]) || $_POST["rankawardingbodyname"] == "" || $_POST["rankawardingbodystatus"] == "" || $_POST["rankawardingbodyid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing rank awarding body based on the rank awarding body id
        $update = $db->prepare("UPDATE rankawardingbody SET rankawardingbodyname = ? , rankawardingbodystatus = ? WHERE rankawardingbodyid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the rank awarding body");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["rankawardingbodyname"] , $_POST["rankawardingbodystatus"] , $_POST["rankawardingbodyid"]);

            //Execute the query
            if($update->execute() == false)
            {
                failure($response , "Error while updating the rank awarding body");
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