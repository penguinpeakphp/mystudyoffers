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

        //Check if the avatarid has been received
        if(!isset($_POST["avatarid"]) || !isset($_POST["avatarimage"]))
        {
            failure($response , "Not enough data for deleting avatar");
            goto end;
        }

        $db->begin_transaction();

        //Query the database for deleting the avatar with the help of avatarid
        $delete = $db->prepare("DELETE FROM avatar WHERE avatarid = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the avatar");
            $db->rollback();
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("i" , $_POST["avatarid"]);
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the avatar");
                $db->rollback();
                goto end;
            }
        }

        if(unlink("../../avatarimages/" . $_POST["avatarimage"]) == false)
        {
            failure($response , "Error while deleting avatar image");
            $db->rollback();
            goto end;
        }

        if($response["success"] == true)
        {
            $db->commit();
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