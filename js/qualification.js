$(function()
{
    //Function for fetching qualification data and student's selected qualification data
    function getqualificationdata()
    {
        $.get("controllers/qualification/getqualificationmaster.php" , {} , function(data)
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
                    for(let i=0; i<response.qualificationdata.length; i++)
                    {
                        let qualification = response.qualificationdata[i];
                        $("#qualification").append(`
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkqualilevel${qualification.qualificationid}" name="chkqualilevel[]" value="${qualification.qualificationid}" onclick="return chkboxlengthchk('chkqualilevel[]',2);">
                                <label class="checklabel" for="chkqualilevel${qualification.qualificationid}" data-content="${qualification.qualificationname}">${qualification.qualificationname}</label>
                            </div>
                        `);
                    }

                    for(let i=0; i<response.qualificationsubdata.length; i++)
                    {
                        let qualificationsub = response.qualificationsubdata[i];
                        $("#qualificationsub").append(`
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali${qualificationsub.qualificationsubid}" name="chkquali[]" value="${qualificationsub.qualificationsubid}" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali${qualificationsub.qualificationsubid}" data-content="${qualificationsub.qualificationsubname}">${qualificationsub.qualificationsubname}</label>
                            </div>
                        `);
                    }

                    for(let i=0; i<response.qualifications.length; i++)
                    {
                        let qualification = response.qualifications[i];
                        $("#chkqualilevel"+qualification.qualificationid).prop("checked" , true);
                    }

                    for(let i=0; i<response.qualificationsubs.length; i++)
                    {
                        let qualificationsub = response.qualificationsubs[i];
                        $("#chkquali"+qualificationsub.qualificationsubid).prop("checked" , true);
                    }
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
        });
    }

    getqualificationdata();

    $("#qualificationform").on("submit" , function(e)
    {
        e.preventDefault();

        let formdata = new FormData(this);

        $.ajax({
            url: "controllers/qualification/updatequalification.php",
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