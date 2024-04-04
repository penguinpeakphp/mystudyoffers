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

        //Declare subject interests array for storing the data of different subject interests
        $response["subjectinterests"] = [];

        //Query the database for selecting all the subject interest data from the subject interest table
        $select = $db->query("SELECT * FROM subjectinterest");
        if($select == false)
        {
            failure($response , "Error while fetching subject interest list");
            goto end;
        }

        //Loop through all the rows and push the subject interest data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["subjectinterests"] , $row);
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