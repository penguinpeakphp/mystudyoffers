$(function()
{
    //Function for getting work experience and test scores
    function getworkexpandtestscores()
    {
        //
        $.ajax({
            url: "controllers/testscore/gettestscoremaster.php",
            type: "GET",
            data: {},
            async:false,
            success: function(data)
            {
                try
                {
                    //Parse the data received from the server
                    let response = JSON.parse(data);

                    //If the response is not successful, then show the error in alert
                    if(response.success == false)
                    {
                        $(".error-msg").text(response.error);
                        if(response.login == true)
                        {
                            window.location.href = "login.php";
                        }
                    }
                    else
                    {
                        //Render the workexperiences by looping through the array
                        for(let i=0; i<response.workexperiences.length; i++)
                        {
                            let workexperience = response.workexperiences[i];
                            $("#workexperience").append(`
                                <div class="formrow col-lg-6">
                                    <input class="checkbox" type="radio" id="listworkexp${workexperience.workexperienceid}" name="listworkexp" value="${workexperience.workexperienceid}">
                                    <label class="checklabel" for="listworkexp${workexperience.workexperienceid}" data-content="${workexperience.workexperiencename}">${workexperience.workexperiencename}</label>
                                </div>
                            `);
                        }

                        //Check the existing work experience
                        $("#listworkexp"+response.workexperience).prop("checked" , true);

                        //Loop through the test types
                        for(let i=0; i<response.testtypes.length; i++)
                        {
                            let testtype = response.testtypes[i];
                            //Render the heading and the division for the test scores
                            $("#testtypes").append(`
                                <h4 class="title mb-10 mt-30">${testtype.testname}</h4>
                                <div class="row clearfix testscores" id="testtype${testtype.testid}"></div>
                            `);

                            //Loop through the test scores
                            for(let j=0; j<response.testscores.length; j++)
                            {
                                let testscore = response.testscores[j];

                                //Render test scores in each test type
                                $("#testtype"+testtype.testid).append(`
                                    <div class="formrow col-lg-4">
                                        <input class="checkbox" type="radio" id="${testtype.testid}testscore${testscore.testscoreid}" name="testtype${testtype.testid}" value="${testscore.testscoreid}">
                                        <label class="checklabel" for="${testtype.testid}testscore${testscore.testscoreid}" data-content="${testscore.testscore}">${testscore.testscore}</label>
                                    </div>
                                `);
                            }
                        }

                        //Loop through all the sets of test types and test scores
                        for(let i=0; i<response.testtypetestscores.length; i++)
                        {
                            let testtypetestscore = response.testtypetestscores[i];

                            //Check the respective radios
                            $("#"+testtypetestscore.testid+"testscore"+testtypetestscore.testscoreid).prop("checked" , true);
                        }
                    }
                }
                catch(error)
                {
                    alert("Error occurred while trying to read server response");
                }
            }
        });
    }

    getworkexpandtestscores();

    $("#testscoreform").on("submit" , function(e)
    {
        e.preventDefault();

        let testscores = [];

        $(".testscores").each(function()
        {
            //Fetch the checkbox
            let $checkbox = $(this).find("input[type='radio']:checked");

            //Only proceed if anything is checked
            if($checkbox.length != 0)
            {
                //Fetch the value
                let value = $checkbox.val();

                //Extract the test id from the name attribute
                let testid = $checkbox.attr("name").substring("testtype".length);

                //Create object and push into the array
                let testscoreobj = {};
                testscoreobj[testid] = value;

                testscores.push(testscoreobj);
            }
        });

        $.ajax({
            url: "controllers/testscore/updatetestscore.php",
            type: "POST",
            data: {"testscores":testscores , "workexperience":$("input[name=listworkexp]:checked").val()},
            success: function(data)
            {
                try
                {
                    //Parse the data received from the server
                    let response = JSON.parse(data);

                    //If the response is not successful, then show the error in alert
                    if(response.success == false)
                    {
                        $(".error-msg").text(response.error);
                        if(response.login == true)
                        {
                            window.location.href = "login.php";
                        }
                    }
                    else
                    {
                        //Redirect to country interest page
                        window.location.href = "countryinterest.php";
                    }
                }
                catch(error)
                {
                    alert("Error occurred while trying to read server response");
                }
            }
        });
    });
}); 