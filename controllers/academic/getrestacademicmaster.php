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

        //Declare passing year array for storing the passing years
        $response["passingyears"] = [];

        //Query the database to fetch all the passing year from the database that are active
        $select = $db->prepare("SELECT * FROM passingyear WHERE passingyearstatus = 1");
        if($select == false)
        {
            failure($response , "Error while fetching passing year list");
            goto end;
        }
        else
        {
            //Excecute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching passing year list");
                goto end;
            }

            //Fetch the result
            $result = $select->get_result();

            //Push the passing year values into the array
            while($row = $result->fetch_assoc())
            {
                array_push($response["passingyears"] , $row);
            }
        }

        $response["selecteddata"] = [];
        //Get selected passing years
        $select = $db->prepare("SELECT academicid , majorsubjectid , passingyearid , resultid , awardingbodyid FROM studentacademics WHERE studentid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching selected passing year list");
            goto end;
        }
        else
        {
            //Bind the student id from the session
            $select->bind_param("i" , $_SESSION["studentid"]); 

            //Excecute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching selected passing year list");
                goto end;
            }
            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["selecteddata"] , $row);
            }
        }

        $response["results"] = [];
        //Query the database to fetch all the results from the database that are active
        $select = $db->prepare("SELECT * FROM result WHERE resultstatus = 1");
        if($select == false)
        {
            failure($response , "Error while fetching result list");
            goto end;
        }
        else
        {
            //Excecute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching result list");
                goto end;
            }

            //Fetch the result
            $result = $select->get_result();

            //Push the result name into the array
            while($row = $result->fetch_assoc())
            {
                array_push($response["results"] , $row);
            }
        }

        $response["awardingbodies"] = [];

        $select = $db->prepare("SELECT sa.academicid , ab.awardingbodyid , awardingbodyname FROM awardingbody ab INNER JOIN studentacademics sa ON ab.academicid = sa.academicid WHERE studentid = ? AND awardingbodystatus = 1");
        if($select == false)
        {
            failure($response , "Error while fetching awarding body list");
            goto end;
        }
        else
        {
            $select->bind_param("i" , $_SESSION["studentid"]);
            if($select->execute() == false)
            {
                failure($response , "Error while fetching awarding body list");
                goto end;
            }
            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["awardingbodies"] , $row);
            }
        }

        $response["academicsubject"] = [];

        $select = $db->prepare("SELECT sa.academicid , academicname , majorsubjectname , ms.majorsubjectid , (SELECT passingyear FROM passingyear WHERE passingyearid = sa.passingyearid) AS passingyear , (SELECT resultname FROM result WHERE resultid = sa.resultid) AS resultname , (SELECT awardingbodyname FROM awardingbody WHERE awardingbodyid = sa.awardingbodyid) AS awardingbodyname FROM studentacademics sa INNER JOIN academic a ON sa.academicid = a.academicid INNER JOIN majorsubject ms ON ms.majorsubjectid = sa.majorsubjectid WHERE studentid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching selected academics and major subjects");
            goto end;
        }
        else
        {
            $select->bind_param("i" , $_SESSION["studentid"]);
            if($select->execute() == false)
            {
                failure($response , "Error while fetching selected academics and major subjects");
                goto end;
            }
            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["academicsubject"] , $row);
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