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
        if(!isset($_POST["statename"]) || !isset($_POST["statestatus"]) || !isset($_POST["countryid"]) || $_POST["statename"] == "" || $_POST["statestatus"] == "" || $_POST["countryid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting state into the database
        $insert = $db->prepare("INSERT INTO state(statename , statestatus , countryid) VALUES(? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the state");
            goto end;
        }
        else
        {
            //Bind the state name , state status, and countryid
            $insert->bind_param("sii" , $_POST["statename"] , $_POST["statestatus"] , $_POST["countryid"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the state");
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