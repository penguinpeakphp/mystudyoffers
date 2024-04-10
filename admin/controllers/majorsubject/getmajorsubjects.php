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

        //Declare majorsubjects array for storing the data of different major subjects
        $response["majorsubjects"] = [];

        //Query the database for selecting all the major subjects data from the majorsubject table
        $select = $db->query("SELECT majorsubjectid , majorsubjectname , majorsubjectstatus , academicname , m.academicid AS academicid FROM majorsubject m INNER JOIN academic a ON m.academicid = a.academicid");
        if($select == false)
        {
            failure($response , "Error while fetching major subject list");
            goto end;
        }

        //Loop through all the rows and push the state data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["majorsubjects"] , $row);
        }

        //Declare academics for storing the academic list
        $response["academics"] = [];

        //Get the academics into the array with the help of reference
        if(getacademics($response , $response["academics"]) == false)
        {
            goto end;
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