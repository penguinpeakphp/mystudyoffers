$(function()
{
    function getacademicdata(type)
    {
        $.get("controllers/master/getmasterdata.php" , {"type":type} , function(data)
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
                    for(let i=0, cnt=1; i<response.data.length; i++ , cnt++)
                    {
                        let data = response.data[i];
                        $(".academicoptionlist").append(`
                        <div class="formrow col-lg-4">
                            <input type="checkbox" id="chkquali${cnt}" name="chkquali[]" value="${data[type+'id']}" class="checkbox" onclick="return checklowereducation('${cnt}');">
                            <label class="checklabel" for="chkquali${cnt}" data-content="${data[type+'name']}">${data[type+'name']}</label>
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
    }

    getacademicdata("academic");

    $("#academicform1").on("submit" , function(e)
    {
        e.preventDefault();

        let formdata = new FormData(this);

        $.ajax({
            url: "controllers/academic/updateacademic.php",
            type: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            success: function(data)
            {
                console.log(data);
            }
        });
    });
});