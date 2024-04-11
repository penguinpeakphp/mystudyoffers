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
        if(!isset($_POST["resultname"]) || !isset($_POST["resultstatus"]) || $_POST["resultname"] == "" || $_POST["resultstatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting result into the database
        $insert = $db->prepare("INSERT INTO result(resultname , resultstatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the result");
            goto end;
        }
        else
        {
            //Bind the result name and status
            $insert->bind_param("si" , $_POST["resultname"] , $_POST["resultstatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the result");
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