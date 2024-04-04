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
        if(!isset($_POST["cityname"]) || !isset($_POST["citystatus"]) || !isset($_POST["countryid"]) || !isset($_POST["stateid"]) || $_POST["cityname"] == "" || $_POST["citystatus"] == "" || $_POST["countryid"] == "" || $_POST["stateid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting city into the database
        $insert = $db->prepare("INSERT INTO city(cityname , citystatus , countryid , stateid) VALUES(? , ? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the city");
            goto end;
        }
        else
        {
            //Bind the city name , city status, countryid and stateid
            $insert->bind_param("siii" , $_POST["cityname"] , $_POST["citystatus"] , $_POST["countryid"] , $_POST["stateid"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the city");
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