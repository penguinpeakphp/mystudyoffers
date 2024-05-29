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

    $db->begin_transaction();

    if(isset($_GET["universityimage"]))
    {
        //Query the database to update the university image record in table
        $update = $db->prepare("UPDATE university SET universityimage = '' WHERE universityid = ?");
        if($update == false)
        {
            failure($response , "Error while deleting the university image name");
            $db->rollback();
            goto end;
        }
        else
        {
            //Bind the parameters
            $update->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($update->execute() == false)
            {
                failure($response , "Error while deleting the university image name");
                $db->rollback();
                goto end;
            }
        }

        //Delete the university image
        if(unlink("../../universitydata/".$_GET["universityid"]."/". $_GET["universityimage"]) == false)
        {
            failure($response , "Error while deleting the university image");
            $db->rollback();
            goto end;
        }
    }

    if(isset($_GET["logoimage"]))
    {
        //Query the database to update the university image record in table
        $update = $db->prepare("UPDATE universityassets SET logoimage = '' WHERE universityid = ?");
        if($update == false)
        {
            failure($response , "Error while deleting the logo image name");
            $db->rollback();
            goto end;
        }
        else
        {
            //Bind the parameters
            $update->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($update->execute() == false)
            {
                failure($response , "Error while deleting the logo image name");
                $db->rollback();
                goto end;
            }
        }

        //Delete the logo image
        if(unlink("../../universitydata/".$_GET["universityid"]."/". $_GET["logoimage"]) == false)
        {
            failure($response , "Error while deleting the logo image");
            $db->rollback();
            goto end;
        }
    }

    if(isset($_GET["mascotimage"]))
    {
        //Query the database to update the university image record in table
        $update = $db->prepare("UPDATE universityassets SET mascotimage = '' WHERE universityid = ?");
        if($update == false)
        {
            failure($response , "Error while deleting the mascot image name");
            $db->rollback();
            goto end;
        }
        else
        {
            //Bind the parameters
            $update->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($update->execute() == false)
            {
                failure($response , "Error while deleting the mascot image name");
                $db->rollback();
                goto end;
            }
        }

        //Delete the logo image
        if(unlink("../../universitydata/".$_GET["universityid"]."/". $_GET["mascotimage"]) == false)
        {
            failure($response , "Error while deleting the mascot image");
            $db->rollback();
            goto end;
        }
    }

    if(isset($_GET["facilityimage"]))
    {
        //Query the database to remove the entry of the facility image
        $delete = $db->prepare("DELETE FROM universityfacilityimages WHERE universityid = ? AND image = ?");
        if($delete == false)
        {
            failure($response , "Error while deleting the facility image name");
            $db->rollback();
            goto end;
        }
        else
        {
            //Bind the parameters
            $delete->bind_param("ss" , $_GET["universityid"] , $_GET["facilityimage"]);

            //Execute the query
            if($delete->execute() == false)
            {
                failure($response , "Error while deleting the facility image name");
                $db->rollback();
                goto end;
            }
        }

        //Delete the logo image
        if(unlink("../../universitydata/".$_GET["universityid"]."/". $_GET["facilityimage"]) == false)
        {
            failure($response , "Error while deleting the facility image");
            $db->rollback();
            goto end;
        }
    }

    end:;

    if($response["success"] == true)
    {
        $db->commit();
    }
} 
catch (Exception  $e) 
{
    $response["success"] = false;
    $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
}

echo json_encode($response);
?>