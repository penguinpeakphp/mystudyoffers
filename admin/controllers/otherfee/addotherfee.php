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
        if(!isset($_POST["otherfeename"]) || !isset($_POST["otherfeestatus"]) || $_POST["otherfeename"] == "" || $_POST["otherfeestatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting otherfee into the database
        $insert = $db->prepare("INSERT INTO otherfee(otherfeename , otherfeestatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the other fee");
            goto end;
        }
        else
        {
            //Bind the otherfee name and status
            $insert->bind_param("si" , $_POST["otherfeename"] , $_POST["otherfeestatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the other fee");
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