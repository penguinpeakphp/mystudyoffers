$(function()
{
    $.get("controllers/student/getstudentdata.php" , {} , function(data)
    {
        try
        {
            //Parse the data received from the server
            let response = JSON.parse(data);

            //If the response is not successful, then show the error in alert
            if(response.success == false)
            {
                $(".error-msg").text(response.error)
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
});