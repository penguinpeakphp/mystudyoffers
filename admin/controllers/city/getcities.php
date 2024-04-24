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

        //Declare states array for storing the data of different cities
        $response["cities"] = [];

        //Query the database for selecting all the cities data from the city table
        $select = $db->query("SELECT cityid , cityname , citystatus , c.stateid AS stateid, c.countryid AS countryid , statename , countryname FROM city c INNER JOIN state s ON c.stateid = s.stateid INNER JOIN country cnt ON c.countryid = cnt.countryid");
        if($select == false)
        {
            failure($response , "Error while fetching city list");
            goto end;
        }

        //Loop through all the rows and push the state data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["cities"] , $row);
        }

        //Declare countries for storing the country list
        $response["countries"] = [];

        //Declare states for storing the state list
        $response["states"] = [];

        //Get the countries into the array with the help of reference
        getcountries($response , $response["countries"]);

        //Get the states into the array with the help of reference
        getstates($response , $response["states"]);

        end:;
    }
    catch(Exception  $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>