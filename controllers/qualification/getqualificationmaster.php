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

        //Declare array for getting qualification data
        $response["qualificationdata"] = [];

        //Query the database to get all the active qualification data from the qualification table
        $result = $db->query("SELECT * FROM qualification WHERE qualificationstatus = 1");
        if($result == false)
        {
            failure($response , "Error while getting qualification list");
            goto end;
        }

        //Loop through the entire result and push the data into the array
        while($row = $result->fetch_assoc())
        {
            array_push($response["qualificationdata"] , $row);
        }

        //Declare array for getting qualification sub data
        $response["qualificationsubdata"] = [];

        //Query the database to get all the active qualification sub data from qualification sub table
        $result = $db->query("SELECT * FROM qualificationsub WHERE qualificationsubstatus = 1");
        if($result == false)
        {
            failure($response , "Error while getting qualification sub list");
            goto end;
        }

        //Loop through the entire result and push the data into the array
        while($row = $result->fetch_assoc())
        {
            array_push($response["qualificationsubdata"] , $row);
        }

        //Declare array for storing the selected qualifications of the student
        $response["qualifications"] = [];

        //Query the database for selecting selected qualifications
        $select = $db->prepare("SELECT sq.qualificationid , qualificationname FROM qualification q INNER JOIN studentqualification sq ON q.qualificationid = sq.qualificationid WHERE studentid = ?");
        if($select == false)
        {
            failure($response , "Error while getting student qualification");
            goto end;
        }
        else
        {
            //Bind the paramters
            $select->bind_param("i" , $_SESSION["studentid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while getting student qualification");
                goto end;
            }

            //Fetch the results, loop through the result and push the data into the array
            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["qualifications"] , $row);
            }
        }

        //Declare array for storing qualificationsubs
        $response["qualificationsubs"] = [];

        //Query the database for selecting selected qualification subs
        $select = $db->prepare("SELECT qs.qualificationsubid , qualificationsubname FROM qualificationsub qs INNER JOIN studentqualificationsub sqs ON qs.qualificationsubid = sqs.qualificationsubid WHERE studentid = ?");
        if($select == false)
        {
            failure($response , "Error while getting student qualification sub");
            goto end;
        }
        else
        {
             //Bind the paramters
             $select->bind_param("i" , $_SESSION["studentid"]);

             //Execute the query
             if($select->execute() == false)
             {
                 failure($response , "Error while getting student qualification sub");
                 goto end;
             }

            //Fetch the results, loop through the result and push the data into the array
            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["qualificationsubs"] , $row);
            }
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while fetching data - " . $e->getMessage());
    }

    echo json_encode($response);

?>