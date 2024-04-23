<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    function getFileExtension($filename) 
    {
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    }

    try
    {
        $response["success"] = true;

        //Check if the user has already logged in
        if(checksession($response) == false)
        {
            goto end;
        }

        //Check if we have got all the information that we needed
        if(!isset($_POST["queryid"]) || !isset($_POST["reply"]) || $_POST["reply"] == "" || $_POST["queryid"] == "")
        {
            failure($response , "Please enter all the information needed to make a reply");
            goto end;
        }

        //Start the transaction as there are multiple operations for one functionality
        $db->begin_transaction();

        //Query the database to insert the reply into the database
        $insert = $db->prepare("INSERT INTO queryconversation(queryid , studentid , message) VALUES(? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding your reply to the conversation");
            $db->rollback();
            goto end;
        }
        else
        {
            //Bind the parameters
            $insert->bind_param("iis" , $_POST["queryid"] , $_SESSION["studentid"] , $_POST["reply"]);

            //Excecute the query
            if($insert->execute() == false)
            {
                failure($response , "Error while adding your reply to the conversation");
                $db->rollback();
                goto end;
            }
        }

        //Get the latest auto incremented id
        $conversationid = $db->insert_id;

        //Check if the file is uploaded and then only perform upload action
        if(isset($_FILES["file"]))
        {
            //Generate the filename
            $filename = $conversationid.".".getFileExtension($_FILES["file"]["name"]);

            //Move the file to the respective directory
            if(move_uploaded_file($_FILES["file"]["tmp_name"] , "../../conversationfiles/".$filename) == false)
            {
                failure($response , "Error while uploading the file");
                $db->rollback();
                goto end;
            }

            //Update the query for setting the file name
            $update = $db->query("UPDATE queryconversation SET filename = '{$filename}' WHERE conversationid = '{$conversationid}'");
            if($update == false)
            {
                failure($response , "Error while uploading the file location in database");
                $db->rollback();
                goto end;
            }
        }

        //Commit the database if everything goes well
        if($response["success"] == true)
        {
            $db->commit();
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while updating the conversation - " . $e->getMessage());
    }

    echo json_encode($response);

?>