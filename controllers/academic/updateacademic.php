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

            //Delete old academic data of the student
            $delete = $db->prepare("DELETE FROM studentacademics WHERE studentid = ?");
            if($delete == false)
            {
                failure($response , "Error while removing old academic data");
                goto end;
            }
            else
            {
                //Bind the student id from the session
                $delete->bind_param("i" , $_SESSION["studentid"]);
                if($delete->execute() == false)
                {
                    failure($response , "Error while removing old academic data");
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
                    goto end;
                }
                else
                {
                    //Bind the studentid and academicid from the for each loop
                    $insert->bind_param("ii" , $_SESSION["studentid"] , $academicid);
                    if($insert->execute() == false)
                    {
                        failure($response , "Error while adding your academic data");
                        goto end;
                    }
                }
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
            
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while updating academic data - " . $e->getCode());
    }

    echo json_encode($response);

?>