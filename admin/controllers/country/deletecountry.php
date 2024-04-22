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

        //Check if the countryid has been received
        if(!isset($_POST["countryid"]))
        {
            failure($response , "Not enough data for deleting country");
            goto end;
        }

        //Query the database for deleting the country with the help of countryid
        $delete = $db->prepare("DELETE FROM country WHERE countryid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the country");
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["countryid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the country");
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