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

        //Query the database for inserting country into the database
        $insert = $db->prepare("INSERT INTO country(countryname , status) VALUES(? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the country");
            goto end;
        }
        else
        {
            //Bind the country name and status
            $insert->bind_param("si" , $_POST["countryname"] , $_POST["status"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the country");
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