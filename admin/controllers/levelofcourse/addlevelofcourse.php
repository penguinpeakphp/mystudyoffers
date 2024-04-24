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
        if(!isset($_POST["levelofcoursename"]) || !isset($_POST["levelofcoursestatus"]) || $_POST["levelofcoursename"] == "" || $_POST["levelofcoursestatus"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting level of course into the database
        $insert = $db->prepare("INSERT INTO levelofcourse(levelofcoursename , levelofcoursestatus) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the level of course");
            goto end;
        }
        else
        {
            //Bind the level of course name and status
            $insert->bind_param("si" , $_POST["levelofcoursename"] , $_POST["levelofcoursestatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the level of course");
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