<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        function checkadminlogin() 
        { 
            global $db;
            $stmt = $db->query("SELECT count(*) as count FROM adminuser where adminemail = '$_SESSION[adminemail]' and adminpassword = '$_SESSION[adminpassword]'");
            $row = $stmt->fetch_assoc();
            if($row['count'] <= 0) 
            {
                return false;
            }

            return true;
        }

        $response["success"] = true;

        //Start the session for storing information of the user
        session_start();

        $admincheck = false;
        //Check if the user is already logged in`
        if(isset($_GET["admin-login"]))
        {
            $admincheck = checkadminlogin();
            if($admincheck == true)
            {

                $_POST["email"] = $_COOKIE["student-email"];
                goto studentlogin;
            }
        }

        //Check if email and password has been supplied
        if(!isset($_POST["email"]) || !isset($_POST["password"]) || $_POST["email"] == "" || $_POST["password"] == "")
        {
            failure($response , "Please fill in all the information");
            goto end;
        }
        
        studentlogin:;

        //Get the student with specified email
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

            //Check if the user exists in the database or not
            if(mysqli_num_rows($result) == 0)
            {
                failure($response , "Your account does not exists");
                goto end;
            }
            
            //Fetch a single row
            $row = $result->fetch_assoc();

            if(isset($_GET["admin-login"]) && $admincheck == false)
            {
                //Check if the password matches with the original one after hashing the supplied one
                if($row["password"] != hash("sha512" , $_POST["password"]))
                {
                    failure($response , "Wrong email/password entered");
                    goto end;
                }
            }

            //Check if the user is active or not
            if($row["status"] == false)
            {
                failure($response , "You have not activated your account");
                goto end;
            }

            //Assign the redirect url according to the profile completion status
            if($row["profilestatus"] == "academic")
            {
                $response["url"] = "academicprofile1.php";
            }
            if($row["profilestatus"] == "qualification")
            {
                $response["url"] = "qualificationprofile.php";
            }
            if($row["profilestatus"] == "testscore")
            {
                $response["url"] = "testscoreprofile.php";
            }
            if($row["profilestatus"] == "countryinterest")
            {
                $response["url"] = "countryinterest.php";
            }
            if($row["profilestatus"] == "dashboard")
            {
                $response["url"] = "dashboard.php";
            }
            
            //Set the session with the variables
            $_SESSION["studentid"] = $row["studentid"];
            $_SESSION["name"] = $row["name"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["profilestatus"] = $row["profilestatus"];
            $_SESSION["url"] = $response["url"];
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while logging in - " . $e->getCode());
    }

    echo json_encode($response);
?>