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

        //Check if all the fields are set and have some value
        if(!isset($_POST["subjectinterestid"]) || !isset($_POST["subjectinterestname"]) || !isset($_POST["subjectintereststatus"]) || $_POST["subjectinterestname"] == "" || $_POST["subjectintereststatus"] == "" || $_POST["subjectinterestid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database to update the existing subject interest based on the subject interest id
        $update = $db->prepare("UPDATE subjectinterest SET subjectinterestname = ? , subjectintereststatus = ? WHERE subjectinterestid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the subject interest");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["subjectinterestname"] , $_POST["subjectintereststatus"] , $_POST["subjectinterestid"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the subject interest");
                goto end;
            }
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