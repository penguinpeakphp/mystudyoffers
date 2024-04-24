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

        //Declare qualifications array for storing the data of different qualifications
        $response["qualifications"] = [];

        //Query the database for selecting all the qualification data from the qualification table
        $select = $db->query("SELECT * FROM qualification");
        if($select == false)
        {
            failure($response , "Error while fetching qualification list");
            goto end;
        }

        //Loop through all the rows and push the qualification data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["qualifications"] , $row);
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