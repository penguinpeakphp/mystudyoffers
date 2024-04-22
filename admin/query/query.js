$(function()
{

    //Function for getting conversation of a query
    function getconversation(queryid , name)
    {
        $.get("../controllers/query/getconversation.php" , {"queryid":queryid} , function(data)
        {
            try
            {
                //Parse the data received from the server
                let response = JSON.parse(data);

                //If the response is not successful, then show the error in alert
                if(response.success == false)
                {
                    alert(response.error);

                    //Redirect to login page if the user is required to be login again
                    if(response.login == true)
                    {
                        window.location.href = "../login/login.php";
                    }
                }
                else
                {
                    $("#conversation").html("");

                    //Loop through the conversation and render the data into the modal
                    for(let i=0; i<response.conversation.length; i++)
                    {
                        let chat = response.conversation[i];
                        let tr = `
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-12">
                                        <div class="card-body">`;

                        //If admin has sent the message
                        if(chat.studentid == null && chat.adminid != null)
                        {
                            tr += `<h5 class="card-title">You</h5>`;
                        }

                        //If student has sent the message
                        if(chat.studentid != null && chat.adminid == null)
                        {
                            tr += `<h5 class="card-title">${name}</h5>`;
                        }

                        tr += `
                                    <p class="time">${chat.timestring}</p>
                                    <p class="card-text">${chat.message}</p> `;

                        //If the last message is sent by the student, render reply section
                        if(chat.studentid != null && i == 0)
                        {
                            tr += `
                                <input type="text" id="reply"/>
                                <button class="btn btn-primary" id="replybtn">Reply</button>
                            `;
                        }

                        tr += `     </div>
                                </div>
                            </div>
                        </div>
                        `;

                        $("#conversation").append(tr);
                    }

                    $("#replybtn").on("click" , function()
                    {
                        let reply = $("#reply").val();
                        $.post("../controllers/query/updateconversation.php" , {"queryid":queryid , "reply":reply} , function(data)
                        {   
                            try
                            {
                                //Parse the data received from the server
                                let response = JSON.parse(data);

                                //If the response is not successful, then show the error in alert
                                if(response.success == false)
                                {
                                    alert(response.error);
                                    if(response.login == true)
                                    {
                                        window.location.href = "login.php";
                                    }
                                }
                                else
                                {
                                    //Reload the conversation after successul reply
                                    getconversation(queryid , name);
                                }
                            }
                            catch(error)
                            {
                                alert("Error occurred while trying to read server response " + error);
                            }
                        });
                    });
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
        });
    }

    //Function for getting query list
    function getquerylist()
    {
        $.get("../controllers/query/getqueries.php" , {} , function(data)
        {
            try
            {
                //Parse the data received from the server
                let response = JSON.parse(data);

                //If the response is not successful, then show the error in alert
                if(response.success == false)
                {
                    alert(response.error);

                    //Redirect to login page if the user is required to be login again
                    if(response.login == true)
                    {
                        window.location.href = "../login/login.php";
                    }
                }
                else
                {
                    //Loop through the queries and render the table
                    for(let i=0; i<response.queries.length; i++)
                    {
                        let query = response.queries[i];
                        let tr = `
                            <tr>
                                <th scope="row">${query.qi}</th>
                                <td>${query.name}</td>
                                <td>${query.querytopic}</td>
                                <td>${query.messagetime}</td>
                                <td><button type="button" data-queryid="${query.qi}" data-studentname="${query.name}" class="btn btn-primary view" data-bs-toggle="modal" data-bs-target="#ExtralargeModal">
                                    View
                                </button></td>
                        `;

                        $("#querybody").append(tr);
                    }

                    $(".view").on("click" , function()
                    {
                        getconversation($(this).attr("data-queryid") , $(this).attr("data-studentname"));
                    });
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
        });
    }

    getquerylist();
});