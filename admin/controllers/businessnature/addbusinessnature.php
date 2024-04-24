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
        if(!isset($_POST["businessname"]) || !isset($_POST["businessstatus"]) || $_POST["businessname"] == "" || $_POST["businessstatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting business nature into the database
        $insert = $db->prepare("INSERT INTO businessnature(businessname , businessstatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the business nature");
            goto end;
        }
        else
        {
            //Bind the business nature name and status
            $insert->bind_param("si" , $_POST["businessname"] , $_POST["businessstatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the business nature");
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