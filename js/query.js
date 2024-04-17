$(function()
{
    $("#askquery").on("click" , function()
    {
        let query = $("#query").val();
        
        $.post("controllers/query/createquery.php" , {"query":query} , function(data)
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
                    $("#query").val("");
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response " + error);
            }
        });
    });

    $.get("controllers/query/getqueries.php" , {} , function(data)
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
            alert("Error occurred while trying to read server response " + error);
        }
    });
});