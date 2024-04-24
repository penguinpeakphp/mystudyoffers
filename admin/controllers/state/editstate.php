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
        if(!isset($_POST["stateid"]) || !isset($_POST["statename"]) || !isset($_POST["statestatus"]) || !isset($_POST["countryid"]) || $_POST["stateid"] == "" || $_POST["statename"] == "" || $_POST["statestatus"] == "" || $_POST["countryid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing state based on the state id
        $update = $db->prepare("UPDATE state SET statename = ? , statestatus = ? , countryid = ? WHERE stateid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the state");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("siii" , $_POST["statename"] , $_POST["statestatus"] , $_POST["countryid"] , $_POST["stateid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the state");
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