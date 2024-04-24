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

        //Query the academic table as recieved in the get query
        $result = $db->query("SELECT * FROM academic WHERE academicstatus = 1");
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

        //Declare array for storing the selected academic data
        $response["academic1"] = [];
        $response["academic1name"] = [];

        //Query the database for selecting the selected academic data
        $select = $db->prepare("SELECT sa.academicid , a.academicname FROM studentacademics sa INNER JOIN academic a ON sa.academicid = a.academicid WHERE studentid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching your existing academic data");
            goto end;
        }
        else
        {
            //Bind the student id to the query
            $select->bind_param("i" , $_SESSION["studentid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching your existing academic data");
                goto end;
            }

            //Fetch the result
            $result = $select->get_result();

            //Push the data into the array
            while($row = $result->fetch_assoc())
            {
                array_push($response["academic1"] , $row["academicid"]);
                array_push($response["academic1name"] , $row["academicname"]);
            }
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while fetching data - " . $e->getCode());
    }

    echo json_encode($response);

?>