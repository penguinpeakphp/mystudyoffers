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

        //Check if the cityid has been received
        if(!isset($_POST["cityid"]))
        {
            failure($response , "Not enough data for deleting city");
            goto end;
        }

        //Query the database for deleting the city with the help of cityid
        $delete = $db->prepare("DELETE FROM city WHERE cityid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the city");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["cityid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the city");
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