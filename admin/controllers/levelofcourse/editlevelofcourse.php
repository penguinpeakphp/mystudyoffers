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
        if(!isset($_POST["levelofcourseid"]) || !isset($_POST["levelofcoursename"]) || !isset($_POST["levelofcoursestatus"]) || $_POST["levelofcoursename"] == "" || $_POST["levelofcoursestatus"] == "" || $_POST["levelofcourseid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing level of course based on the level of course id
        $update = $db->prepare("UPDATE levelofcourse SET levelofcoursename = ? , levelofcoursestatus = ? WHERE levelofcourseid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the level of course");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["levelofcoursename"] , $_POST["levelofcoursestatus"] , $_POST["levelofcourseid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the level of course");
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