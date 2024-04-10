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

        //Declare awardingbodies array for storing the data of different awarding bodies
        $response["awardingbodies"] = [];

        //Query the database for selecting all the awarding bodies data from the awardingbody table
        $select = $db->query("SELECT awardingbodyid , awardingbodyname , awardingbodystatus , academicname , ab.academicid AS academicid FROM awardingbody ab INNER JOIN academic a ON ab.academicid = a.academicid");
        if($select == false)
        {
            failure($response , "Error while fetching awarding body list");
            goto end;
        }

        //Loop through all the rows and push the state data into the array one by one
        while($row = $select->fetch_assoc())
        {
            array_push($response["awardingbodies"] , $row);
        }

        //Declare countries for storing the academic list
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