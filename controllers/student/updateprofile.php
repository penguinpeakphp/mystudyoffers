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

        if(
            !isset($_POST["editname"]) || !isset($_POST["editemail"]) || !isset($_POST["editphone"]) || !isset($_POST["editpincode"]) ||
            empty($_POST["editname"]) || empty($_POST["editemail"]) || empty($_POST["editphone"]) || empty($_POST["editpincode"])
        )
        {
            $response["success"] = false;
            $response["message"] = "please fill the required fields";
            goto end;
        }

        $name = $_POST["editname"];
        $email = $_POST["editemail"];
        $phone = $_POST["editphone"];
        $pincode = $_POST["editpincode"];

        if(empty($_POST["editpassword"]) || !isset($_POST["editpassword"]))
        {
            $update = $db->prepare("UPDATE student SET name = ?, email = ?, phone = ?, pincode = ? WHERE studentid = ?");
            $update->bind_param("ssssi", $name, $email, $phone, $pincode, $_SESSION["studentid"]);
        }
        else
        {
            $password = hash("sha512", $_POST["editpassword"]);
            $update = $db->prepare("UPDATE student SET name = ?, email = ?, phone = ?, pincode = ?, password = ? WHERE studentid = ?");
            $update->bind_param("sssssi", $name, $email, $phone, $pincode, $password, $_SESSION["studentid"]);
        }

        if($update->execute() == false)
        {
            failure($response , "Error Occurred while updating student data");
            goto end;
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