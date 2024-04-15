$(function()
{
    function getrestacademicdata()
    {
        $.ajax({
            url: "controllers/master/getrestacademicmaster.php",
            type: "GET",
            data: {},
            success: function(data)
            {
                console.log(data);
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
                        for(let i=0; i<response.academicsubject; i++)
                        {
                            let academicsubject = response.academicsubject[i];

                            $("#submitbtns").before(`
                                <div id="academic${academicsubject.academicid}">
                                    <h4 class="title mb-10 mt-30">${response.academicname} > ${response.majorsubjectname}</h4>
                                </div>
                            `);

                            $("#academic"+academicsubject.academicid).append(`
                                <div class="sec-title mt-30">
                                    <h5 class="title mb-10">Passing Year</h5>
                                    <p>If pursuing tap predicted</p>
                                </div>
                                <div class="row clearfix" id="passingyear${academicsubject.academicid}"></div>
                            `);

                            $("#academic"+academicsubject.academicid).append(`
                                <div class="sec-title mt-30">
                                    <h5 class="title mb-10">Result</h5>
                                    <p>If pursuing tap predicted</p>
                                </div>
                                <div class="row clearfix" id="result${academicsubject.resultid}"></div>
                            `);

                            $("#academic"+academicsubject.academicid).append(`
                                <div class="sec-title mt-30">
                                    <h5 class="title mb-10">Awarding Body</h5>
                                    <p>If pursuing tap predicted</p>
                                </div>
                                <div class="row clearfix" id="awardingbody${academicsubject.awardingbodyid}"></div>
                            `);
                        }
                       

                        for(let i=0; i<response.passingyears.length; i++)
                        {
                            let passingyear = response.passingyears[i];
                            $("#passingyear"+passingyear.passingyearid).append(`
                                <div class="formrow col-lg-3">
                                    <input class="checkbox" type="radio" name="passingyear" id="passingyear${passingyear.passingyearid}" value="${passingyear.passingyearid}">
                                    <label class="checklabel" for="passingyear${passingyear.passingyearid}" data-content="${passingyear.passingyear}">${passingyear.passingyear}</label>
                                </div>
                            `);
                        }

                        for(let i=0; i<response.results.length; i++)
                        {
                            let result = response.results[i];
                            $("#result"+result.resultid).append(`
                                <div class="formrow col-lg-3">
                                    <input class="checkbox" type="radio" name="result" id="result${result.resultid}" value="${result.resultname}">
                                    <label class="checklabel" for="result${result.resultid}" data-content="${result.resultname}">${result.resultname}</label>
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

});