<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check in the session if the user has logged in
        if(checksession($response) == false)
        {
            goto end;
        }

        //Check if all the necessary data is provided
        if(
            !isset($_POST["editname"]) || !isset($_POST["editemail"]) || !isset($_POST["editphone"]) || !isset($_POST["editpincode"]) || !isset($_POST["editsurname"]) ||
            empty($_POST["editname"]) || empty($_POST["editemail"]) || empty($_POST["editphone"]) || empty($_POST["editpincode"] || empty($_POST["editsurname"]))
        )
        {
            failure($response , "Please fill all the required fields");
            goto end;
        }

        $name = $_POST["editname"];
        $email = $_POST["editemail"];
        $phone = $_POST["editphone"];
        $pincode = $_POST["editpincode"];
        $surname = $_POST["editsurname"];

        $db->begin_transaction();

        $update = $db->prepare("UPDATE student SET name = ?, email = ?, phone = ?, surname = ?, pincode = ? WHERE studentid = ?");
        $update->bind_param("sssssi", $name, $email, $phone, $surname, $pincode, $_SESSION["studentid"]);

        if($update->execute() == false)
        {
            failure($response , "Error Occurred while updating student data");
            $db->rollback();
            goto end;
        }

        if($_FILES["editprofilepic"]["name"] != "")
        {
            //Check if directory exists and create if not exists
            if(!is_dir("../../studentdata/" . $_SESSION["studentid"]))
            {
                if(mkdir("../../studentdata/" . $_SESSION["studentid"]) == false)
                {
                    failure($response , "Error in creating student data directory");
                    $db->rollback();
                    goto end;
                }
            }

            //Extract the extension from the filename
            $extension = pathinfo($_FILES["editprofilepic"]["name"] , PATHINFO_EXTENSION);
            $filename = "profilepic." . $extension;

            if(move_uploaded_file($_FILES["editprofilepic"]["tmp_name"] , "../../studentdata/" . $_SESSION["studentid"] . "/" . $filename) == false)
            {
                failure($response , "Error in uploading profile picture");
                $db->rollback();
                goto end;
            }

            //Query the database to edit profile pic name
            $update = $db->prepare("UPDATE student SET profilepic = ? WHERE studentid = ?");
            $update->bind_param("si" , $filename , $_SESSION["studentid"]);
            if($update->execute() == false)
            {
                failure($response , "Error in updating profile picture name in database");
                $db->rollback();
                goto end;
            }
        }

        if($response["success"] == true)
        {
            $db->commit();
        }

        $response["message"] = "Student data updated successfully";
        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while fetching student data - " . $e->getCode());
    }

    echo json_encode($response);
?>