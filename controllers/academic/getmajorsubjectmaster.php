<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check if the user has already logged in
        if(checksession($response) == false)
        {
            goto end;
        }

        //Declare array for storing the data
        $response["data"] = [];

        //Query the major subject table as recieved in the get query
        $result = $db->query("SELECT ms.majorsubjectid , majorsubjectname , ms.academicid , academicname FROM majorsubject ms INNER JOIN studentacademics sa ON ms.academicid = sa.academicid INNER JOIN academic a ON a.academicid = sa.academicid WHERE studentid = '{$_SESSION['studentid']}'");
        if($result == false)
        {
            failure($response , "Error while fetching data");
            goto end;
        }

        //Push the data into the associative array
        while($row = $result->fetch_assoc())
        {
            array_push($response["data"] , $row);
        }

        //Declare array for storing the selected data
        $response["selecteddata"] = [];

        //Query the database to get the selected data
        $result = $db->query("SELECT academicid , majorsubjectid FROM studentacademics WHERE studentid = '{$_SESSION['studentid']}'");
        if($result == false)
        {
            failure($response , "Error while fetching data");
            goto end;
        }

        //Push the data into the associative array
        while($row = $result->fetch_assoc())
        {
            array_push($response["selecteddata"] , $row);
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while fetching data - " . $e->getCode());
    }

    echo json_encode($response);

?>