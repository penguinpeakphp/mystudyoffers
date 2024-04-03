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
        if(!isset($_POST["countryname"]) || !isset($_POST["status"]) || $_POST["countryname"] == "" || $_POST["status"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing country based on the country id
        $update = $db->prepare("UPDATE country SET countryname = ? , status = ? WHERE countryid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the country");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["countryname"] , $_POST["status"] , $_POST["countryid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the country");
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