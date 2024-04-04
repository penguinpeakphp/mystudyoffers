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
        if(!isset($_POST["subjectinterestname"]) || !isset($_POST["subjectintereststatus"]) || $_POST["subjectinterestname"] == "" || $_POST["subjectintereststatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting subject interest into the database
        $insert = $db->prepare("INSERT INTO subjectinterest(subjectinterestname , subjectintereststatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the subject interest");
            goto end;
        }
        else
        {
            //Bind the subject interest name and status
            $insert->bind_param("si" , $_POST["subjectinterestname"] , $_POST["subjectintereststatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the subject interest");
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