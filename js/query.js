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
                    //Empty the input field
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
                //Loop through the queries and render the table rows
                for(let i=0; i<response.queries.length; i++)
                {
                    let query = response.queries[i];
                    let tr = `
                        <tr>
                            <td>${query.qi}</td>
                            <td>${query.querytopic}</td>
                    `;

                    //If the admin has replied last
                    if(query.studentid == null && query.adminid != null)
                    {
                        tr += `<td>MSO - ${query.lastdate}</td>`;
                    }

                    //If the student has replied last
                    if(query.adminid == null && query.studentid != null)
                    {
                        tr += `<td>Yourself - ${query.lastdate}</td>`;
                    }

                    tr += `
                            <td><a href="conversation.php?queryid=${query.qi}" class="btn btn-reply">Reply</a></td>
                        </tr>
                    `;

                    $("#querybody").append(tr);
                }
            }
        }
        catch(error)
        {
            alert("Error occurred while trying to read server response " + error);
        }
    });
});