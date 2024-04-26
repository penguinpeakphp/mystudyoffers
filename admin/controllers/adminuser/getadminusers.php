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

        //Declare admin users array for storing the data of different admin users
        $response["adminusers"] = [];

        //Query the database for selecting all the admin user data from the adminuser table
        $select = $db->prepare("SELECT adminid , adminname , adminemail , adminstatus FROM adminuser WHERE adminid <> 1 AND adminid <> ?");
        if($select == false)
        {
            failure($response , "Error while fetching admin user list");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("i" , $_SESSION["adminid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching admin user list");
                goto end;
            }
        }
        $result = $select->get_result();

        //Loop through all the rows and push the admin user data into the array one by one
        while($row = $result->fetch_assoc())
        {
            array_push($response["adminusers"] , $row);
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