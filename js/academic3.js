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
                        console.log(response.passingyear);
                        console.log(response.results);
                        console.log(response.awardingbodies);
                        //window.location.href = "academicprofile3.php";
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