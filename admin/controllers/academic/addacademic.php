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
        if(!isset($_POST["academicname"]) || !isset($_POST["academicstatus"]) || $_POST["academicname"] == "" || $_POST["academicstatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting academic into the database
        $insert = $db->prepare("INSERT INTO academic(academicname , academicstatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the academic qualification");
            goto end;
        }
        else
        {
            //Bind the academic name and status
            $insert->bind_param("si" , $_POST["academicname"] , $_POST["academicstatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the academic qualification");
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