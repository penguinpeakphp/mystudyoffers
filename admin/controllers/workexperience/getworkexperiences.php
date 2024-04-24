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

        //Declare workexperiences array for storing the data of different work experiences
        $response["workexperiences"] = [];

        //Query the database for selecting all the work experience data from the work experience table
        $select = $db->query("SELECT * FROM workexperience");
        if($select == false)
        {
            failure($response , "Error while fetching work experience list");
            goto end;
        }

        //Loop through all the rows and push the workexperience data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["workexperiences"] , $row);
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