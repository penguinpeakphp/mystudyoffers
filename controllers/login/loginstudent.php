<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        if(!isset($_POST["email"]) || !isset($_POST["password"]) || $_POST["email"] == "" || $_POST["password"] == "")
        {
            failure($response , "Please fill in all the information");
            goto end;
        }
        
        $select = $db->prepare("SELECT * FROM student WHERE email = ?");
        if($select == false)
        {
            failure($response , "Error while checking the credentials");
            goto end;
        }
        else
        {
            $select->bind_param("s" , $_POST["email"]);
            if($select->execute() == false)
            {
                failure($response , "Error while checking the credentials");
                goto end;
            }
            $result = $select->get_result();
            if(mysqli_num_rows($result) == 0)
            {
                failure($response , "Your account does not exists");
                goto end;
            }
            $row = $result->fetch_assoc();
            if($row["password"] != hash("sha512" , $_POST["password"]))
            {
                failure($response , "Wrong email/password entered");
                goto end;
            }
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while logging in - " . $e->getCode());
    }

    echo json_encode($response);
?>