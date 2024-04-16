$(function()
{
    //Function for getting the major subject data for the selected academic data in the first step
    function getmajorsubjectdata()
    {
        $.ajax({
            url: "controllers/academic/getmajorsubjectmaster.php",
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
                        let uniqueAcademicArray = [];

                        response.data.forEach(function(item) {
                            // Check if the academic name already exists in the uniqueAcademicArray
                            let existingAcademic = uniqueAcademicArray.find(academic => academic.academicname === item.academicname);

                            // If the academic name doesn't exist, add it to the array
                            if (!existingAcademic) {
                                uniqueAcademicArray.push({
                                    academicid: item.academicid,
                                    academicname: item.academicname
                                });
                            }
                        });

                        //Add the unique academic data from the response and render the headings for them
                        uniqueAcademicArray.forEach(function(academicobj)
                        {
                            $("#submitbtns").before(`
                                <div id="academic${academicobj.academicid}">
                                    <div class="sec-title mt-30">
                                        <h4 class="title mb-10">${academicobj.academicname}</h4>
                                        <p>Select major subject studied</p>
                                    </div>
                                    <div class="row clearfix"></div>
                                </div>
                            `);
                        });

                        //Loop through all the major subjects of the academics and render major subjects under respective academic category
                        for(let i=0; i<response.data.length; i++)
                        {
                            let majorsubject = response.data[i];
                            $('#academic'+majorsubject.academicid).find(".clearfix").append(`
                                <div class="formrow col-lg-4">
                                    <input class="checkbox" type="radio" id="subject${majorsubject.majorsubjectid}" name="academicsubject${majorsubject.academicid}" value="${majorsubject.majorsubjectid}">
                                    <label class="checklabel" for="subject${majorsubject.majorsubjectid}" data-content="${majorsubject.majorsubjectname}">${majorsubject.majorsubjectname}</label>
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

    getmajorsubjectdata();

    $("#academicform2").on("submit" , function(e)
    {
        e.preventDefault();
        
        let formdata = new FormData(this);
        formdata.append("academic2" , "academic2");

        //Request the server for updating the major subject of the respective academic
        $.ajax({
            url: "controllers/academic/updateacademic.php",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
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
                        window.location.href = "academicprofile3.php";
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