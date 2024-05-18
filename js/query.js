$(function()
{
    $(".currentpage").text("Ask Queries").prev().remove();

    //Function for getting query lists
    function getquerylist()
    {
        $.get("controllers/query/getqueries.php" , {} , function(data)
        {
            try
            {
                //Parse the data received from the server
                let response = JSON.parse(data);

                //If the response is not successful, then show the error in alert
                if(response.success == false)
                {
                    showalert(response.error)
                    if(response.login == true)
                    {
                        window.location.href = "login.php";
                    }
                }
                else
                {
                    //Loop through the query types and render the table rows
                    for(let i=0; i<response.querytypes.length; i++)
                    {
                        let querytype = response.querytypes[i];
                        $("#querytype").append(`
                            <option value="${querytype.querytypeid}">${querytype.querytypename}</option>
                        `);
                    }
                
                    $("#querybody").html("");

                    if(response.queries.length == 0)
                    {
                        $("#querybody").append('<tr><td colspan="5" class="text-center text-danger">No queries found</td></tr>');
                    }
                    //Loop through the queries and render the table rows
                    for(let i=0; i<response.queries.length; i++)
                    {
                        let query = response.queries[i];
                        let tr = '';
                        if(query.readbystudent == 0)
                        {
                            tr += '<tr style="background: lightgoldenrodyellow;">';
                        }
                        else
                        {
                            tr += '<tr>';
                        }

                        tr += `<td>${i+1}</td>
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

                        //Format the last message if the length is greater than max length
                        let maxLength = 100;
                        if (query.lastmessage.length > maxLength) {
                            query.lastmessage =  query.lastmessage.substring(0, maxLength) + '...';
                        }

                        tr += `
                            <td>${query.lastmessage}</td>
                            <td>${query.querytypename}</td>
                        `;

                        tr += `
                                <td><a href="conversation.php?queryid=${query.qi}" class="btn btn-reply">View/Replies</a></td>
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
    }

    getquerylist();

    $("#askquery").on("click" , function()
    {
        let query = $("#query").val();
        let querytypeid = $("#querytype").val();
        
        $.post("controllers/query/createquery.php" , {"query":query , "querytypeid":querytypeid} , function(data)
        {
            try
            {
                //Parse the data received from the server
                let response = JSON.parse(data);

                //If the response is not successful, then show the error in alert
                if(response.success == false)
                {
                    showalert(response.error)
                    if(response.login == true)
                    {
                        window.location.href = "login.php";
                    }
                }
                else
                {
                    //Empty the input field
                    $("#query").val("");
                    $("#querytype").val("");

                    getquerylist();
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response " + error);
            }
        });
    });
});