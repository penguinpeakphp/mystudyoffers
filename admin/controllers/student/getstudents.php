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

        //Declare variable for storing student lead
        $response["students"] = [];

        //Check if the admin type is admin
        if($_SESSION["admintype"] == "admin")
        {
            //Query the database for fetching all the student data
            $result = $db->query("SELECT * , (SELECT distinct(adminname) FROM studenttelecaller st INNER JOIN adminuser au ON st.telecallerid = au.adminid WHERE st.studentid = s.studentid) AS telecallername FROM student s");
            if($result == false)
            {
                failure($response , "Error while fetching student list");
                goto end;
            }
        }

        //Check if the admin type is telecaller
        if($_SESSION["admintype"] == "telecaller")
        {
            //Query the database for fetching the student data assigned to this telecaller only
            $select = $db->prepare("SELECT * FROM student WHERE studentid IN (SELECT studentid FROM studenttelecaller WHERE telecallerid = ?)");
            if($select == false)
            {
                failure($response , "Error while fetching student list");
                goto end;
            }
            else
            {
                //Bind the parameters
                $select->bind_param("i" , $_SESSION["adminid"]);

                //Execute the query
                if($select->execute() == false)
                {
                    failure($response , "Error while fetching student list");
                    goto end;
                }

                $result = $select->get_result();
            }
        }

        //Loop through the result and push the data into the array
        while($row =$result->fetch_assoc())
        {
            array_push($response["students"] , $row);
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