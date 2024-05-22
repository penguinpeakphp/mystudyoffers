<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    //Function for generating 6 digit random OTP
    function generateOTP() 
    {
        $otp = mt_rand(100000, 999999);
        return $otp;
    }

    try
    {
        $response["success"] = true;

        //Check in the session if the user has logged in
        if(checksession($response) == false)
        {
            goto end;
        }

        if(isset($_GET["send"]) && $_GET["send"] == "send")
        {
            //Generate the OTP
            $otp = generateOTP();

            //Query the database to update OTP
            $update = $db->prepare("UPDATE student SET studentOTP = ? WHERE studentid = ?");
            if($update == false)
            {
                failure($response , "Error while updating the student OTP");
                goto end;
            }
            else
            {
                //Bind the parameters
                $update->bind_param("si" , $otp , $_SESSION["studentid"]);

                //Execute the query
                if($update->execute() == false)
                {
                    failure($response , "Error while updating the student OTP");
                    goto end;
                }
            }

            //Send the OTP as SMS
        }

        if(isset($_POST["verify"]) && $_POST["verify"] == "verify")
        {
            if(!isset($_POST["OTP"]) || $_POST["OTP"] == "")
            {
                failure($response , "Please enter OTP");
                goto end;
            }

            //Query the database to fetch the OTP
            $select = $db->prepare("SELECT studentOTP FROM student WHERE studentid = ?");
            if($select == false)
            {
                failure($response , "Error while fetching the student OTP");
                goto end;
            }
            else
            {
                //Bind the parameters
                $select->bind_param("i" , $_SESSION["studentid"]);

                //Execute the query
                if($select->execute() == false)
                {
                    failure($response , "Error while fetching the student OTP");
                    goto end;
                }

                //Fetch the result
                $result = $select->get_result();
                $row = $result->fetch_assoc();
                if($row["studentOTP"] != $_POST["OTP"])
                {
                    failure($response , "Invalid OTP");
                    goto end;
                }

                //Query the database to reset the OTP to null
                $update = $db->prepare("UPDATE student SET studentOTP = NULL , phoneverified = 1 WHERE studentid = ?");
                if($update == false)
                {
                    failure($response , "Error while deleting the student OTP");
                    goto end;
                }
                else
                {
                    //Bind the parameters
                    $update->bind_param("i" , $_SESSION["studentid"]);

                    //Execute the query
                    if($update->execute() == false)
                    {
                        failure($response , "Error while deleting the student OTP");
                        goto end;
                    }
                }
            }
        }
        
        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while fetching student data - " . $e->getCode());
    }

    echo json_encode($response);
?>