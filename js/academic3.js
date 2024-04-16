$(function()
{
    //Function for getting result , passing year and awarding bodies for the respective academic major subject
    function getrestacademicdata()
    {
        $.ajax({
            url: "controllers/master/getrestacademicmaster.php",
            type: "GET",
            data: {},
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
                        //Loop through all academic subject and major subject pair of the student
                        for(let i=0; i<response.academicsubject.length; i++)
                        {
                            let academicsubject = response.academicsubject[i];

                            //Add the heading of academic and major subject
                            $("#submitbtns").before(`
                                <div id="academic${academicsubject.academicid}">
                                    <h4 class="title mb-10 mt-30">${academicsubject.academicname} > ${academicsubject.majorsubjectname}</h4>
                                </div>
                            `);

                            //Add the sub heading of passing year
                            $("#academic"+academicsubject.academicid).append(`
                                <div class="sec-title mt-30">
                                    <h5 class="title mb-10">Passing Year</h5>
                                    <p>If pursuing tap predicted</p>
                                </div>
                                <div class="row clearfix passingyear" id="passingyeardiv${academicsubject.academicid}"></div>
                            `);

                            //Add the sub heading of result
                            $("#academic"+academicsubject.academicid).append(`
                                <div class="sec-title mt-30">
                                    <h5 class="title mb-10">Result</h5>
                                    <p>If pursuing tap predicted</p>
                                </div>
                                <div class="row clearfix result" id="resultdiv${academicsubject.academicid}"></div>
                            `);

                            //Add the sub heading of awarding body
                            $("#academic"+academicsubject.academicid).append(`
                                <div class="sec-title mt-30">
                                    <h5 class="title mb-10">Awarding Body</h5>
                                    <p>If pursuing tap predicted</p>
                                </div>
                                <div class="row clearfix awardingbody" id="awardingbodydiv${academicsubject.academicid}"></div>
                            `);

                            //Loop through all the passing years and add under respective academic id
                            for(let j=0; j<response.passingyears.length; j++)
                            {
                                let passingyear = response.passingyears[j];
                                $("#passingyeardiv"+academicsubject.academicid).append(`
                                    <div class="formrow col-lg-3">
                                        <input class="checkbox" type="radio" name="passingyear${academicsubject.academicid}" id="${academicsubject.academicid}passingyear${passingyear.passingyearid}" value="${passingyear.passingyearid}">
                                        <label class="checklabel" for="${academicsubject.academicid}passingyear${passingyear.passingyearid}" data-content="${passingyear.passingyear}">${passingyear.passingyear}</label>
                                    </div>
                                `);
                            }

                            //Loop through all the results and add under respective academic id
                            for(let j=0; j<response.results.length; j++)
                            {
                                let result = response.results[j];
                                $("#resultdiv"+academicsubject.academicid).append(`
                                    <div class="formrow col-lg-3">
                                        <input class="checkbox" type="radio" name="result${academicsubject.academicid}" id="${academicsubject.academicid}result${result.resultid}" value="${result.resultid}">
                                        <label class="checklabel" for="${academicsubject.academicid}result${result.resultid}" data-content="${result.resultname}">${result.resultname}</label>
                                    </div>
                                `);
                            }
                        }

                        //Loop through all the awarding bodies and add to their academic id
                        for(let j=0; j<response.awardingbodies.length; j++)
                        {
                            let awardingbody = response.awardingbodies[j];
                            $("#awardingbodydiv"+awardingbody.academicid).append(`
                                <div class="formrow col-lg-3">
                                    <input class="checkbox" type="radio" name="awardingbody${awardingbody.academicid}" id="awardingbody${awardingbody.awardingbodyid}" value="${awardingbody.awardingbodyid}">
                                    <label class="checklabel" for="awardingbody${awardingbody.awardingbodyid}" data-content="${awardingbody.awardingbodyname}">${awardingbody.awardingbodyname}</label>
                                </div>
                            `);
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

    getrestacademicdata();

    $("#academicform3").on("submit" , function(e)
    {
        e.preventDefault()  ;

        //Variables for storing objects with academicid : value
        let results = [];
        let passingyears = [];
        let awardingbodies = [];

        //Loop through all the passing year divs
        $(".passingyear").each(function()
        {
            //Fetch the checked radio
            let $checkbox = $(this).find("input[type='radio']:checked");

            //Fetch the value
            let value = $checkbox.val();

            //Extract the academic id from the name attribute
            let academicid = $checkbox.attr("name").substring("passingyear".length);

            //Create object and push into the array
            let passingyearobj = {};
            passingyearobj[academicid] = value;

            passingyears.push(passingyearobj);
        });

        //Loop through all the result divs
        $(".result").each(function()
        {
            //Fetch the checked radio
            let $checkbox = $(this).find("input[type='radio']:checked");

            //Fetch the value
            let value = $checkbox.val();

            //Extract the academic id from the name attribute
            let academicid = $checkbox.attr("name").substring("result".length);

            //Create object and push into the array
            let resultobj = {};
            resultobj[academicid] = value;

            results.push(resultobj);
        });

        $(".awardingbody").each(function()
        {
            //Fetch the checked radio
            let $checkbox = $(this).find("input[type='radio']:checked");

            //Fetch the value
            let value = $checkbox.val();

            //Extract the academic id from the name attribute
            let academicid = $checkbox.attr("name").substring("awardingbody".length);

            //Create object and push into the array
            let awardingbodyobj = {};
            awardingbodyobj[academicid] = value;

            awardingbodies.push(awardingbodyobj);
        });

        //Request the server for updating the major subject of the respective academic
        $.ajax({
            url: "controllers/academic/updateacademic.php",
            type: "POST",
            data: {"academic3":"academic3" , "results":results , "passingyears":passingyears , "awardingbodies":awardingbodies},
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