$(function()
{
    $(".currentpage").text("Dashboard");

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
                for(let i=0; i<response.academicsubject.length; i++)
                {
                    let academic = response.academicsubject[i];

                    academic.majorsubjectname = academic.majorsubjectname == null ? "-" : academic.majorsubjectname;
                    academic.passingyear = academic.passingyear == null ? "N/A" : academic.passingyear;
                    academic.resultname = academic.resultname == null ? "N/A" : academic.resultname;
                    academic.awardingbodyname = academic.awardingbodyname == null ? "N/A" : academic.awardingbodyname;

                    $("#academicdetail").append(`
                        <div class="mb-3">
                            <span class="education-title">
                                ${academic.academicname} > ${academic.majorsubjectname} <!--<span class="border-line"></span>-->
                                <span></span>
                        </div>
                        <div class="education mb-3">
                            <div class="subject-row">
                                <div class="progress-bar">
                                    <div class="progress-fill pboxwidth">Passing Year<br>${academic.passingyear}</div>
                                    <div class="progress-fill pboxwidth">Result<br>${academic.resultname}</div>
                                    <div class="progress-fill pboxwidth" title="CBSE">Awarding Body<br>${academic.awardingbodyname}</div>
                                </div>
                            </div>
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
                //Loop through the qualifications and render it in the dashboard
                for(let i=0; i<response.qualifications.length; i++)
                {
                    let qualification = response.qualifications[i];
                    $("#qualificationlevel").append(`
                        <div class="education mb-3">
                            <div class="subject-row">
                                <div class="progress-bar">
                                    <div class="progress-fill pboxwidth_full">${qualification.qualificationname}</div>
                                </div>
                            </div>
                        </div>
                    `);
                }

                //Loop through the qualification subs and render it in the dashboard
                for(let i=0; i<response.qualificationsubs.length; i++)
                {
                    let qualificationsub = response.qualificationsubs[i];
                    $("#nextqualification").append(`
                        <div class="education mb-3">
                            <div class="subject-row">
                                <div class="progress-bar">
                                    <div class="progress-fill pboxwidth_full">${qualificationsub.qualificationsubname}</div>
                                </div>
                            </div>
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
                //Loop through all the test scores and render in the dashboard
                for(let i=0; i<response.testtypetestscores.length; i++)
                {
                    let testtypetestscore = response.testtypetestscores[i];
                    $("#testscores").append(`
                        <div class="progress-fill pboxwidth col-4 my-1">${testtypetestscore.testname}<br>${testtypetestscore.testscore} </div>
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