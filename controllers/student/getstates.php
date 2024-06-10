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

        //Declare states array for storing the data of different states
        $response["states"] = [];

        //Query the database for selecting all the state data from the state table
        $select = $db->query("SELECT * FROM allstates where country_id = " . $_GET["countryid"]);
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

        end:;
    }
    catch(Exception  $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>