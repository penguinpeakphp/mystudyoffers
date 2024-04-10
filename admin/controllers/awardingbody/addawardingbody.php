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
        if(!isset($_POST["awardingbodyname"]) || !isset($_POST["awardingbodystatus"]) || !isset($_POST["academicid"]) || $_POST["awardingbodyname"] == "" || $_POST["awardingbodystatus"] == "" || $_POST["academicid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting awarding body into the database
        $insert = $db->prepare("INSERT INTO awardingbody(awardingbodyname , awardingbodystatus , academicid) VALUES(? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the awarding body");
            goto end;
        }
        else
        {
            //Bind the awarding body name , awarding body status, and academicid
            $insert->bind_param("sii" , $_POST["awardingbodyname"] , $_POST["awardingbodystatus"] , $_POST["academicid"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the awarding body");
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