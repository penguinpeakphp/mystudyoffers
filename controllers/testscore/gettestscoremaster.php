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

        //Declare an array to store work experiences
        $response["workexperiences"] = [];

        //Query the database for fetching the work experience list
        $result = $db->query("SELECT * FROM workexperience WHERE workexperiencestatus = 1");
        if($result == false)
        {
            failure($response , "Error while fetching work experience list");
            goto end;
        }

        //Loop through the result and push the data into the array
        while($row = $result->fetch_assoc())
        {
            array_push($response["workexperiences"] , $row);
        }

        //Query the database for fetching the work experience of the student
        $select = $db->prepare("SELECT s.workexperienceid , workexperiencename FROM studentworkexperience s INNER JOIN workexperience w ON s.workexperienceid = w.workexperienceid WHERE studentid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching your work experience");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("i" , $_SESSION["studentid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching your work experience");
                goto end;
            }

            //Fetch the result and fetch one row
            $result = $select->get_result();
            if(mysqli_num_rows($result) != 0)
            {
                $row = $result->fetch_assoc();
                //Assign the value to response
                $response["workexperience"] = $row["workexperienceid"];
                $response["workexperiencename"] = $row["workexperiencename"];
            }
        }

        //Declare an array to store the test types
        $response["testtypes"] = [];

        //Query the database to fetch the test types
        $result = $db->query("SELECT * FROM testtype WHERE teststatus = 1");
        if($result == false)
        {
            failure($response , "Error while fetching test types");
            goto end;
        }

        //Loop through the result and push the data into the array
        while($row = $result->fetch_assoc())
        {
            array_push($response["testtypes"] , $row);
        }

        //Declare an array to store the test scores
        $response["testscores"] = [];

        //Query the database to fetch the test scores
        $result = $db->query("SELECT * FROM testscore WHERE testscorestatus = 1");
        if($result == false)
        {
            failure($response , "Error while fetching test scores");
            goto end;
        }

        //Loop through the result and push the data into the array
        while($row = $result->fetch_assoc())
        {
            array_push($response["testscores"] , $row);
        }

        $response["testtypetestscores"] = [];
        //Query the database to fetch the test scores of each test type
        $select = $db->prepare("SELECT ttts.testid , ttts.testscoreid , testname , testscore FROM testtypetestscore ttts INNER JOIN testtype tt ON ttts.testid = tt.testid INNER JOIN testscore ts ON ttts.testscoreid = ts.testscoreid WHERE studentid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching test score in each test");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("i" , $_SESSION["studentid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching test score in each test");
                goto end;
            }

            //Fetch the result
            $result = $select->get_result();

            while($row = $result->fetch_assoc())
            {
                array_push($response["testtypetestscores"] , $row);
            }
        }
        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while fetching test score data - " . $e->getMessage());
    }

    echo json_encode($response);

?>