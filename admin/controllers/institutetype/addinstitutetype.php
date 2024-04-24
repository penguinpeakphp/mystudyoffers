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
        if(!isset($_POST["institutename"]) || !isset($_POST["institutestatus"]) || $_POST["institutename"] == "" || $_POST["institutestatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting institute type into the database
        $insert = $db->prepare("INSERT INTO institutetype(institutename , institutestatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the institute type");
            goto end;
        }
        else
        {
            //Bind the test name and status
            $insert->bind_param("si" , $_POST["institutename"] , $_POST["institutestatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the institute type");
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