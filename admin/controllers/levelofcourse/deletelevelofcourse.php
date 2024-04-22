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

        //Check if the levelofcourseid has been received
        if(!isset($_POST["levelofcourseid"]))
        {
            failure($response , "Not enough data for deleting level of course");
            goto end;
        }

        //Query the database for deleting the level of course with the help of levelofcourseid
        $delete = $db->prepare("DELETE FROM levelofcourse WHERE levelofcourseid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the level of course");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["levelofcourseid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the level of course");
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