<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require_once "PHPMailer/vendor/autoload.php";

    require_once "../admin/database/db.php";
    require_once "globalfunctions.php";

    try
    {
        $response["success"] = true;

        if(checksession($response) == false)
        {
            goto end;
        }

        //Check if all the fields are filled and received on the server
        if(!isset($_POST["name"]) || !isset($_POST["surname"]) || !isset($_POST["phone"]) || !isset($_POST["email"]) || !isset($_POST["pincode"]) || !isset($_POST["password"]) || $_POST["name"] == "" || $_POST["surname"] == "" || $_POST["phone"] == "" || $_POST["email"] == "" || $_POST["pincode"] == "" || $_POST["password"] == "")
        {
            failure($response , "Please fill in all the details");
            goto end;
        }

        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) 
        {
            failure($response , "Please enter valid email address");
            goto end;
        }

        //Query the database for inserting student data into the student table
        $insert = $db->prepare("INSERT INTO student(name , surname , phone , email , password , pincode) VALUES(? , ? , ? , ? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error Occurred while creating student account");
            goto end;
        }
        else
        {
            //Hash the password with the sha512 algorithm
            $password = hash("sha512" , $_POST["password"]);

            //Bind the parameters to the query
            $insert->bind_param("ssssss" , $_POST["name"] , $_POST["surname"] , $_POST["phone"] , $_POST["email"] , $password , $_POST["pincode"]);

            //Execute the query
            if($insert->execute() == false)
            {
                failure($response , "Error Occurred while creating student account");
                goto end;
            }
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage());
    }

    echo json_encode($response);
?>