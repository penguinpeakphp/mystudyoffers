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
        if(!isset($_POST["workexperiencename"]) || !isset($_POST["workexperiencestatus"]) || $_POST["workexperiencename"] == "" || $_POST["workexperiencestatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting workexperience into the database
        $insert = $db->prepare("INSERT INTO workexperience(workexperiencename , workexperiencestatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the work experience");
            goto end;
        }
        else
        {
            //Bind the work experience name and status
            $insert->bind_param("si" , $_POST["workexperiencename"] , $_POST["workexperiencestatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the work experience");
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