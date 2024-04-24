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
        if(!isset($_POST["passingyear"]) || !isset($_POST["passingyearstatus"]) || $_POST["passingyear"] == "" || $_POST["passingyearstatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting passingyear into the database
        $insert = $db->prepare("INSERT INTO passingyear(passingyear , passingyearstatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the passing year");
            goto end;
        }
        else
        {
            //Bind the passing year and status
            $insert->bind_param("si" , $_POST["passingyear"] , $_POST["passingyearstatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the passing year");
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