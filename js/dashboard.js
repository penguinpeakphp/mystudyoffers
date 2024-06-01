$(function()
{
    $(".currentpage").text("Dashboard");

    //Send the get request to OTP controller
    $("#sendotp").on("click" , function()
    {
        $.get("controllers/student/OTPaction.php" , {"send":"send"} , function(data)
        {
            try
            {
                //Parse the data received from the server
                let response = JSON.parse(data);

                //If the response is not successful, then show the error in alert
                if(response.success == false)
                {
                    showalert(response.error);
                    if(response.login == true)
                    {
                        window.location.href = "login.php";
                    }
                }
                else
                {
                    $("#OTPModal").modal("show");
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
        });
    });

    //Resend the OTP on clicking the button
    $("#resendotp").on("click" , function()
    {
        //Close the current Modal
        $("#OTPModal").modal("hide");

        //Click the send otp button after giving some time to jquery
        setTimeout(function()
        {
            $("#sendotp").click();
        } , 1000);
    });

    //Verify the OTP
    $("#verifyotp").on("click" , function()
    {
        $.post("controllers/student/OTPaction.php" , {"verify":"verify" , "OTP":$("#OTP").val()} , function(data)
        {
            try
            {
                //Parse the data received from the server
                let response = JSON.parse(data);

                //If the response is not successful, then show the error in alert
                if(response.success == false)
                {
                    alert(response.error);
                    if(response.login == true)
                    {
                        window.location.href = "login.php";
                    }
                }
                else
                {
                    $("#OTPModal").modal("hide");
                    showalert("OTP verified successfully");
                    $(".warning-banner").remove();
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
        });
    });

    $.get("controllers/student/getstudentdata.php" , {} , function(data)
    {
        try
        {
            //Parse the data received from the server
            let response = JSON.parse(data);

            //If the response is not successful, then show the error in alert
            if(response.success == false)
            {
                showalert(response.error)
                if(response.login == true)
                {
                    window.location.href = "login.php";
                }
            }
            else
            {
                let student = response.studentdata;

                $(".name").text(student.name);
                $(".email").text(student.email);
                $(".phone").text(student.phone);

                if(student.profilepic != "")
                {
                    $(".profilepic").attr("src" , "../../studentdata/" + student.studentid + "/" + student.profilepic);
                }

                $("#OTPmobile").text(student.phone);

                //Remove the banner is phone is already verified
                if(student.phoneverified == 1)
                {
                    $(".warning-banner").remove();
                }
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response");
        }
    });

    //Get the academic and major subject
    $.get("controllers/academic/getrestacademicmaster.php" , {} , function(data)
    {
        try
        {
            //Parse the data received from the server
            let response = JSON.parse(data);

            //If the response is not successful, then show the error in alert
            if(response.success == false)
            {
                showalert(response.error)
                if(response.login == true)
                {
                    window.location.href = "login.php";
                }
            }
            else
            {
                $("#academicdetail").append(`
                    <div class="text-end">
                        <a href="academicprofile1.php" class="edit-text">Edit</a>
                    </div>
                `);
                for(let i=0; i<response.academicsubject.length; i++)
                {
                    let academic = response.academicsubject[i];

                    academic.majorsubjectname = academic.majorsubjectname == null ? "" : academic.majorsubjectname;
                    academic.passingyear = academic.passingyear == null ? "-" : academic.passingyear;
                    academic.resultname = academic.resultname == null ? "-" : academic.resultname;
                    academic.awardingbodyname = academic.awardingbodyname == null ? "-" : academic.awardingbodyname;

                    $("#academicdetail").append(`
                        <div class="according-text">
                          <h5> ${academic.academicname} > ${academic.majorsubjectname} </h5>
                        </div>
                        <div class="progress-bar mb-2">
                            <div class="progress-fill pboxwidth">Passing Year ${academic.passingyear}</div>
                            <div class="progress-fill pboxwidth">Result ${academic.resultname}</div>
                            <div class="progress-fill pboxwidth" title="CBSE">Awarding Body ${academic.awardingbodyname}</div>
                        </div>
                    `)
                }
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response");
        }
    });

    //Get the qualification data
    $.get("controllers/qualification/getqualificationmaster.php" , {} , function(data)
    {
        try
        {
            //Parse the data received from the server
            let response = JSON.parse(data);

            //If the response is not successful, then show the error in alert
            if(response.success == false)
            {
                showalert(response.error)
                if(response.login == true)
                {
                    window.location.href = "login.php";
                }
            }
            else
            {
                $("#qualificationlevel").append(`
                    <div class="text-end">
                        <a href="qualificationprofile.php" class="edit-text">Edit</a>
                    </div>
                `)
                //Loop through the qualifications and render it in the dashboard
                for(let i=0; i<response.qualifications.length; i++)
                {
                    let qualification = response.qualifications[i]; 

                    $("#qualificationlevel").append(`
                        <div class="progress-bar mb-2">
                            <div class="progress-fill pboxwidth">${qualification.qualificationname}</div>
                        </div>
                    `)
                }

                $("#nextqualification").append(`
                    <div class="text-end">
                        <a href="qualificationprofile.php" class="edit-text">Edit</a>
                    </div>
                `);
                //Loop through the qualification subs and render it in the dashboard
                for(let i=0; i<response.qualificationsubs.length; i++)
                {
                    let qualificationsub = response.qualificationsubs[i];

                    $("#nextqualification").append(`
                        <div class="progress-bar mb-2">
                            <div class="progress-fill pboxwidth">${qualificationsub.qualificationsubname}</div>
                        </div>
                    `);
                }
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response");
        }
    });

    //Get the test score data
    $.get("controllers/testscore/gettestscoremaster.php" , {} , function(data)
    {
        try
        {
            //Parse the data received from the server
            let response = JSON.parse(data);

            //If the response is not successful, then show the error in alert
            if(response.success == false)
            {
                showalert(response.error)
                if(response.login == true)
                {
                    window.location.href = "login.php";
                }
            }
            else
            {
                $("#testscores").append(`
                    <div class="text-end">
                        <a href="testscoreprofile.php" class="edit-text">Edit</a>
                    </div>
                `)
                //Loop through all the test scores and render in the dashboard
                for(let i=0; i<response.testtypetestscores.length; i++)
                {
                    let testtypetestscore = response.testtypetestscores[i];

                    $("#testscores").append(`
                        <div class="progress-bar mb-2">
                            <div class="progress-fill pboxwidth">${testtypetestscore.testname}<br>${testtypetestscore.testscore}</div>
                        </div>
                    `);
                }
                $("#workexperience").text(response.workexperiencename);
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response");
        }
    });

    //Get the country of interest
    $.get("controllers/countryinterest/getcountryinterestmaster.php" , {} , function(data)
    {
        try
        {
            //Parse the data received from the server
            let response = JSON.parse(data);

            //If the response is not successful, then show the error in alert
            if(response.success == false)
            {
                showalert(response.error)
                if(response.login == true)
                {
                    window.location.href = "login.php";
                }
            }
            else
            {
                for(let i=0; i<response.selectedcountrynames.length; i++)
                {
                    let country = response.selectedcountrynames[i];
                    $("#countrylist").append(`
                        <span># ${country}</span>
                    `);
                }
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response");
        }
    });
});