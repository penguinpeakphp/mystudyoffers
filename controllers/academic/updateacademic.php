<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check the session for user authentication
        if(checksession($response) == false)
        {
            goto end;
        }

        //Check if it is the first part of acadmic data submission
        if(isset($_POST["academic1"]) && $_POST["academic1"] == "academic1")
        {
            //Check if any one of the options have been selected
            if(!isset($_POST["chkquali"]))
            {
                failure($response , "Please enter your academic qualification");
                goto end;
            }

            //Start the transaction as there are two queries need to be run for one functionality
            $db->begin_transaction();

            //Delete old academic data of the student
            $delete = $db->prepare("DELETE FROM studentacademics WHERE studentid = ?");
            if($delete == false)
            {
                failure($response , "Error while removing old academic data");
                $db->rollback();
                goto end;
            }
            else
            {
                //Bind the student id from the session
                $delete->bind_param("i" , $_SESSION["studentid"]);
                if($delete->execute() == false)
                {
                    failure($response , "Error while removing old academic data");
                    $db->rollback();
                    goto end;
                }
            }

            //Loop through all the options selected
            foreach($_POST["chkquali"] as $academicid)
            {
                //Insert the student id and academic id into the studentacademic table
                $insert = $db->prepare("INSERT INTO studentacademics(studentid , academicid) VALUES(? , ?)");
                if($insert == false)
                {
                    failure($response , "Error while adding your academic data");
                    $db->rollback();
                    goto end;
                }
                else
                {
                    //Bind the studentid and academicid from the for each loop
                    $insert->bind_param("ii" , $_SESSION["studentid"] , $academicid);
                    if($insert->execute() == false)
                    {
                        failure($response , "Error while adding your academic data");
                        $db->rollback();
                        goto end;
                    }
                }
            }

            //If everything is successful, then commit the database
            if($response["success"] == true)
            {
                $db->commit();
            }
        }

        //Check if it is the second part of acadmic data submission
        if(isset($_POST["academic2"]) && $_POST["academic2"] == "academic2")
        {
            //Loop through the post data as key value pairs
            foreach($_POST as $academicidstr => $majorsubjectid) 
            {
                //Bypass the academic2 key value pair as rest of the data signifies academicid => majorsubjectid
                if($academicidstr != "academic2")
                {
                    //Query the database to update the majorsubjectid according to the student id and academicid
                    $update = $db->prepare("UPDATE studentacademics SET majorsubjectid = ? WHERE studentid = ? AND academicid = ?");
                    if($update == false)
                    {
                        failure($response , "Error while updating major subject");
                        goto end;
                    }
                    else
                    {
                        //Extract the academic id after bypassing the string "academicsubject"
                        $academicid = substr($academicidstr , 15);

                        //Bind the majorsubject id, student id and academic id
                        $update->bind_param("iii" , $majorsubjectid , $_SESSION["studentid"] , $academicid);
                        if($update->execute() == false)
                        {
                            failure($response , "Error while updating major subject");
                            goto end;
                        }
                    }
                }
            }
        }

        //Check if it is the second part of acadmic data submission
        if(isset($_POST["academic3"]) && $_POST["academic3"] == "academic3")
        {
            //Loop through all the passing year objects
            foreach($_POST["passingyears"] as $passingyear)
            {
                //Break passing year into key value pairs
                foreach($passingyear as $key => $value)
                {
                    //Query the database to update the passing year for the respective academic id and studentid
                    $update = $db->prepare("UPDATE studentacademics SET passingyearid = ? WHERE studentid = ? AND academicid = ?");

                    //Bind the parameters
                    $update->bind_param("iii" , $value , $_SESSION["studentid"] , $key);

                    //Execute the query
                    if($update->execute() == false)
                    {
                        failure($response , "Error while updating passing year");
                        goto end;
                    }
                }
            }

            //Loop through all the result objects
            foreach($_POST["results"] as $result)
            {
                //Break passing year into key value pairs
                foreach($result as $key => $value)
                {
                    //Query the database to update the result for the respective academic id and studentid
                    $update = $db->prepare("UPDATE studentacademics SET resultid = ? WHERE studentid = ? AND academicid = ?");

                    //Bind the parameters
                    $update->bind_param("iii" , $value , $_SESSION["studentid"] , $key);

                    //Execute the query
                    if($update->execute() == false)
                    {
                        failure($response , "Error while updating result");
                        goto end;
                    }
                }
            }

            //Loop through all the awarding body objects
            foreach($_POST["awardingbodies"] as $awardingbody)
            {
                //Break awarding body into key value pairs
                foreach($awardingbody as $key => $value)
                {
                    //Query the database to update the awarding body for the respective academic id and studentid
                    $update = $db->prepare("UPDATE studentacademics SET awardingbodyid = ? WHERE studentid = ? AND academicid = ?");

                    //Bind the parameters
                    $update->bind_param("iii" , $value , $_SESSION["studentid"] , $key);

                    //Execute the queries
                    if($update->execute() == false)
                    {
                        failure($response , "Error while updating the awardingbody");
                        goto end;
                    }
                }
            }

            //Query the database to update the profile status
            $update = $db->prepare("UPDATE student SET profilestatus = 'qualification' WHERE studentid = ?");
            if($update == false)
            {
                failure($response , "Error updating profile status");
                goto end;
            }
            else
            {
                //Bind the parameters
                $update->bind_param("i" , $_SESSION["studentid"]);

                //Excecute the query
                if($update->execute() == false)
                {
                    failure($response , "Error updating profile status");
                    goto end;
                }
            }
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while updating academic data - " . $e->getCode());
    }

    echo json_encode($response);

?>