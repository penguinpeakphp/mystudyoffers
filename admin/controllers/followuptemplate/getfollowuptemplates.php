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

        //Declare followuptemplates array for storing the data of different followuptemplates
        $response["followuptemplates"] = [];

        //Query the database for selecting all the followuptemplate data from the followuptemplate table
        $select = $db->query("SELECT * FROM followuptemplate");
        if($select == false)
        {
            failure($response , "Error while fetching follow up template list");
            goto end;
        }

        //Loop through all the rows and push the followup template data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["followuptemplates"] , $row);
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