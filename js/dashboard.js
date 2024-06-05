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
                            <div class="progress-fill pboxwidth">Passing Year<br />${academic.passingyear}</div>
                            <div class="progress-fill pboxwidth">Result<br />${academic.resultname}</div>
                            <div class="progress-fill pboxwidth" title="CBSE">Awarding Body<br />${academic.awardingbodyname}</div>
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
                $("#qualificationlevel").prepend(`
                    <div class="text-end">
                        <a href="qualificationprofile.php" class="edit-text">Edit</a>
                    </div>
                `)
                //Loop through the qualifications and render it in the dashboard
                for(let i=0; i<response.qualifications.length; i++)
                {
                    let qualification = response.qualifications[i]; 

                    $("#qualificationlevel .progress-bar").append(`
                        <div class="progress-fill pboxwidth">${qualification.qualificationname}</div>
                    `)
                }

                $("#nextqualification").prepend(`
                    <div class="text-end">
                        <a href="qualificationprofile.php" class="edit-text">Edit</a>
                    </div>
                `);
                //Loop through the qualification subs and render it in the dashboard
                for(let i=0; i<response.qualificationsubs.length; i++)
                {
                    let qualificationsub = response.qualificationsubs[i];

                    $("#nextqualification .progress-bar").append(`
                        <div class="progress-fill pboxwidth">${qualificationsub.qualificationsubname}</div>
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
                $("#testscores").prepend(`
                    <div class="text-end">
                        <a href="testscoreprofile.php" class="edit-text">Edit</a>
                    </div>
                `)
                //Loop through all the test scores and render in the dashboard
                for(let i=0; i<response.testtypetestscores.length; i++)
                {
                    let testtypetestscore = response.testtypetestscores[i];

                    $("#testscores .progress-bar").append(`
                        <div class="progress-fill pboxwidth">${testtypetestscore.testname}<br>${testtypetestscore.testscore}</div>
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