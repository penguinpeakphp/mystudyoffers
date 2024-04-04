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

        //Declare level of courses array for storing the data of different level of courses
        $response["levelofcourses"] = [];

        //Query the database for selecting all the level of courses data from the level of courses table
        $select = $db->query("SELECT * FROM levelofcourse");
        if($select == false)
        {
            failure($response , "Error while fetching level of courses list");
            goto end;
        }

        //Loop through all the rows and push the level of course data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["levelofcourses"] , $row);
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