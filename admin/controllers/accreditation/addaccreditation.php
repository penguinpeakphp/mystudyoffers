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
        if(!isset($_POST["accreditationname"]) || !isset($_POST["accreditationstatus"]) || $_POST["accreditationname"] == "" || $_POST["accreditationstatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting accreditation into the database
        $insert = $db->prepare("INSERT INTO accreditation(accreditationname , accreditationstatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the accrediation");
            goto end;
        }
        else
        {
            //Bind the accreditation name and status
            $insert->bind_param("si" , $_POST["accreditationname"] , $_POST["accreditationstatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the accreditation");
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