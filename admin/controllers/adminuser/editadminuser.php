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
        if(!isset($_POST["adminid"]) || !isset($_POST["adminname"]) || !isset($_POST["adminemail"]) || !isset($_POST["adminstatus"]) || !isset($_POST["admintype"]) || $_POST["adminname"] == "" || $_POST["adminemail"] == "" || $_POST["adminstatus"] == "" || $_POST["admintype"] == "" || $_POST["adminid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        //Query the database for inserting admin into the database

        //Check if the password is supplied or not
        if(isset($_POST["adminpassword"]) && $_POST["adminpassword"] != "")
        {
            $_POST["adminpassword"] = hash("sha512" , $_POST["adminpassword"]);

            $update = $db->prepare("UPDATE adminuser SET adminname = ? , adminemail = ?, adminpassword = ? , adminstatus = ? WHERE adminid = ?");
            //Bind the parameters
            $update->bind_param("sssis" , $_POST["adminname"] , $_POST["adminemail"] , $_POST["adminpassword"] , $_POST["adminstatus"] , $_POST["adminid"]);
        }           
        else
        {
            $update = $db->prepare("UPDATE adminuser SET adminname = ? , adminemail = ?, adminstatus = ? WHERE adminid = ?");
            //Bind the parameters
            $update->bind_param("ssis" , $_POST["adminname"] , $_POST["adminemail"] , $_POST["adminstatus"] , $_POST["adminid"]);
        }

        //Execute the query
        if($update->execute() == false)
        {
            failure($response , "Error while updating the admin user");
            goto end;
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