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

        //If the action is to change the telecaller
        if(isset($_POST["action"]) && $_POST["action"] == "changetelecaller")
        {
            $update = $db->prepare("UPDATE studenttelecaller SET telecallerid = ? WHERE studentid = ?");
            if($update == false)
            {
                failure($response , "Error while assigning new telecaller to the student");
                goto end;
            }
            else
            {
                //Bind the parameters
                $update->bind_param("ii" , $_POST["adminid"] , $_POST["studentid"]);

                //Execute the query
                if($update->execute() == false)
                {
                    failure($response , "Error while assigning new telecaller to the student");
                    goto end;
                }
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