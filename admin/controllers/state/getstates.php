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

        //Declare states array for storing the data of different states
        $response["states"] = [];

        //Query the database for selecting all the states data from the state table
        $select = $db->query("SELECT stateid , statename , statestatus , countryname , s.countryid AS countryid FROM state s INNER JOIN country c ON s.countryid = c.countryid");
        if($select == false)
        {
            failure($response , "Error while fetching state list");
            goto end;
        }

        //Loop through all the rows and push the state data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["states"] , $row);
        }

        //Declare countries for storing the country list
        $response["countries"] = [];

        //Get the countries into the array with the help of reference
        getcountries($response , $response["countries"]);

        end:;
    }
    catch(Exception  $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>