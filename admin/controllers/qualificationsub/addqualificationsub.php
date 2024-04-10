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
        if(!isset($_POST["qualificationsubname"]) || !isset($_POST["qualificationsubstatus"]) || $_POST["qualificationsubname"] == "" || $_POST["qualificationsubstatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting qualificationsub into the database
        $insert = $db->prepare("INSERT INTO qualificationsub(qualificationsubname , qualificationsubstatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the Qualification Sub");
            goto end;
        }
        else
        {
            //Bind the qualificationsub name and status
            $insert->bind_param("si" , $_POST["qualificationsubname"] , $_POST["qualificationsubstatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the Qualification Sub");
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