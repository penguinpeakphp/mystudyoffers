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

        //Declare qualificationsubs array for storing the data of different qualification subs
        $response["qualificationsubs"] = [];

        //Query the database for selecting all the qualificationsub data from the qualificationsub table
        $select = $db->query("SELECT * FROM qualificationsub");
        if($select == false)
        {
            failure($response , "Error while fetching qualificationsub list");
            goto end;
        }

        //Loop through all the rows and push the qualificationsub data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["qualificationsubs"] , $row);
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