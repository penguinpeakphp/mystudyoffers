<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check session and go to end if session verification is failed
        if(checksession($response) == false)
        {
            goto end;
        }

        //Declare countries array for storing the data of different countries
        $response["countries"] = [];

        //Query the database for selecting all the country data from the country table
        $select = $db->query("SELECT * FROM allcountries");
        if($select == false)
        {
            failure($response , "Error while fetching country list");
            goto end;
        }

        //Loop through all the rows and push the country data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["countries"] , $row);
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