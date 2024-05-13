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
        if(!isset($_POST["rankawardingbodyname"]) || !isset($_POST["rankawardingbodystatus"]) || $_POST["rankawardingbodyname"] == "" || $_POST["rankawardingbodystatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting rank awarding body into the database
        $insert = $db->prepare("INSERT INTO rankawardingbody(rankawardingbodyname , rankawardingbodystatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the rank awarding body");
            goto end;
        }
        else
        {
            //Bind the rank awarding body name and status
            $insert->bind_param("si" , $_POST["rankawardingbodyname"] , $_POST["rankawardingbodystatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the rank awarding body");
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