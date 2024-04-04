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

        //Declare planning years array for storing the data of different planning years
        $response["planningyears"] = [];

        //Query the database for selecting all the country data from the planning year table
        $select = $db->query("SELECT * FROM planningyear");
        if($select == false)
        {
            failure($response , "Error while fetching planning year list");
            goto end;
        }

        //Loop through all the rows and push the planning year data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["planningyears"] , $row);
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