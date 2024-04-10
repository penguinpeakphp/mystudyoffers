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
        if(!isset($_POST["qualificationsubid"]) || !isset($_POST["qualificationsubname"]) || !isset($_POST["qualificationsubstatus"]) || $_POST["qualificationsubname"] == "" || $_POST["qualificationsubstatus"] == "" || $_POST["qualificationsubid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing qualificationsub based on the qualificationsub id
        $update = $db->prepare("UPDATE qualificationsub SET qualificationsubname = ? , qualificationsubstatus = ? WHERE qualificationsubid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the Qualification Sub");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["qualificationsubname"] , $_POST["qualificationsubstatus"] , $_POST["qualificationsubid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the Qualification Sub");
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