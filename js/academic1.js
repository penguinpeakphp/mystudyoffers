$(function()
{
    //Function for getting academic data
    function getacademicdata()
    {
        //Make a synchronous ajax call for getting the list of academic qualifications from the masters table
        $.ajax({
            url: "controllers/academic/getacademicmaster.php",
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
                        //Loop through the data and append the list of academics checkboxes
                        for(let i=0, cnt=1; i<response.data.length; i++ , cnt++)
                        {
                            let data = response.data[i];
                            $(".academicoptionlist").append(`
                            <div class="formrow col-lg-4">
                                <input type="checkbox" id="chkquali${cnt}" name="chkquali[]" value="${data['academicid']}" class="checkbox" onclick="return checklowereducation('${cnt}');">
                                <label class="checklabel" for="chkquali${cnt}" data-content="${data['academicname']}">${data['academicname']}</label>
                            </div>
                            `);
                        }

                        //Loop through all the academic ids that we selected by the student
                        for(let i=0; i<response.academic1.length; i++)
                        {
                            //Check each one of them
                            $(`#chkquali${response.academic1[i]}`).prop("checked" , true);
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

    //Load the data when the page is loaded
    getacademicdata();

    $("#academicform1").on("submit" , function(e)
    {
        e.preventDefault();

        //Create the form data for this submission
        let formdata = new FormData(this);

        //Attach one key value pair for defining the first step of submitting academic data
        formdata.append("academic1" , "academic1");

        //Request the server to update the newly selected academics into the table
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
                        //Redirect to the second steop of the profile update
                        window.location.href = "academicprofile2.php";
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