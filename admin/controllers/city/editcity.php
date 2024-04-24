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
        if(!isset($_POST["cityid"]) || !isset($_POST["cityname"]) || !isset($_POST["citystatus"]) || !isset($_POST["countryid"]) || !isset($_POST["stateid"]) || $_POST["cityid"] == "" || $_POST["cityname"] == "" || $_POST["citystatus"] == "" || $_POST["countryid"] == "" || $_POST["stateid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing city based on the city id
        $update = $db->prepare("UPDATE city SET cityname = ? , citystatus = ? , countryid = ? , stateid = ? WHERE cityid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the city");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("siiii" , $_POST["cityname"] , $_POST["citystatus"] , $_POST["countryid"] , $_POST["stateid"] , $_POST["cityid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the city");
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