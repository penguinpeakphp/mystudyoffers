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

        //Declare accreditations array for storing the data of different accreditation
        $response["accreditations"] = [];

        //Query the database for selecting all the accreditation data from the accreditation table
        $select = $db->query("SELECT * FROM accreditation");
        if($select == false)
        {
            failure($response , "Error while fetching accreditation list");
            goto end;
        }

        //Loop through all the rows and push the accreditation data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["accreditations"] , $row);
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