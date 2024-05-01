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

        //Declare an array to store the follow ups
        $response["followups"] = [];

        //Query the database for fetching follow up of students
        $select = $db->prepare("SELECT followupid , remarks , followuptemplatename , sf.followuptemplatebody , DATE_FORMAT(noteaddedon,'%d-%m-%Y %H:%i:%s') AS noteaddedon ,  DATE_FORMAT(nextfollowupdate,'%d-%m-%Y') AS nextfollowupdate FROM studentfollowup sf INNER JOIN followuptemplate ft ON sf.followuptemplateid = ft.followuptemplateid WHERE studentid = ? ORDER BY noteaddedon DESC");
        if($select == false)
        {
            failure($response , "Error while fetching follow up");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("i" , $_GET["studentid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching follow up");
                goto end;
            }

            //Fetch the result
            $result = $select->get_result();

            //Loop through the result and push data into the array
            while($row = $result->fetch_assoc())
            {
                array_push($response["followups"] , $row);
            }
        }

        //Query the database for fetching follow up templates
        $result = $db->query("SELECT followuptemplateid , followuptemplatename , followuptemplatebody FROM followuptemplate WHERE followuptemplatestatus = 1");
        if($result == false)
        {
            failure($response , "Error while fetching follow up templates");
            goto end;
        }

        //Loop through the result and push the data into the array
        $response["followuptemplates"] = [];
        while($row = $result->fetch_assoc())
        {
            array_push($response["followuptemplates"] , $row);
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