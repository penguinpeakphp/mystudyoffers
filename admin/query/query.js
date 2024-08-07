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

                        tr += '<div class="d-flex align-items-center justify-content-start gap-2">';

                        //If admin has sent the message
                        if(chat.studentid == null && chat.adminid != null)
                        {
                            tr += `<img src="../../images/icons/usericon.png" alt="Profile" style="padding: 0px !important;" class="m-0  rounded-circle" style="height: 2vh; width: 2vh;">`;
                            tr += `<h5 class="card-title d-inline m-0" style="padding: 0px !important;">You (<span class="time">${chat.timestring}</span>)</h5>`;
                        }

                        //If student has sent the message
                        if(chat.studentid != null && chat.adminid == null)
                        {
                            tr += `<img src="../../images/icons/usericon-admin.png" alt="Profile" style="padding: 0px !important;" class="m-0  rounded-circle" style="height: 2vh; width: 2vh;">`;
                            tr += `<h5 class="card-title d-inline m-0" style="padding: 0px !important;">${name} (<span class="time">${chat.timestring}</span>)</h5>`;
                        }

                        tr += '</div>';

                        //Check if the file was attached or not
                        if(chat.filename != null)
                        {
                            tr += `<p><a href="../../../conversationfiles/${chat.filename}" target="_blank">View File</a></p>`
                        }

                        tr += `
                                    <p class="card-text">${chat.message}</p> `;

                        //Reply to the last message
                        if(i == 0)
                        {
                            tr += `
                                <div class="form-container">
                                    <div class="file-input-container">
                                        <label for="file" class="file-upload-label">
                                            <i class="bi bi-paperclip"></i>
                                        </label>
                                        <input type="file" class="form-control custom-file-input" name="file" id="file" accept=".pdf, .doc">
                                    </div>
                                    <div class="textarea-container">
                                        <textarea type="text" id="reply" class="form-control"></textarea>
                                        <div class="button-container">
                                            <button class="btn btn-primary" id="replybtn">Reply</button>
                                        </div>
                                    </div>
                                </div>
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
                        //Fetch the message from input field
                        let reply = $("#reply").val();
                        let file = $("#file")[0].files[0];

                        let formdata = new FormData();
                        formdata.append("queryid",queryid);
                        formdata.append("reply" , reply);
                        if(file)
                        {
                            formdata.append("file" , file);
                        }

                        $.ajax({
                            url: "../controllers/query/updateconversation.php",
                            type: "POST",
                            data:  formdata,
                            contentType: false,
                            processData: false,
                            success: function(data)
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
                        
                        let tr = '';
                        if(query.readbyadmin == 0 && query.adminid == null)
                        {
                            tr += '<tr style="--bs-table-bg:lightyellow !important;">';
                        }
                        else
                        {
                            tr += '<tr>';
                        }

                        tr += `
                                <th scope="row">${query.qi}</th>
                                <td>${query.name}</td>
                                <td>${query.querytopic}</td>
                                <td>${query.querytypename}</td>
                                <td>${query.messagetime}</td>
                                <td><button type="button" data-queryid="${query.qi}" data-studentname="${query.name}" class="btn btn-primary view" data-bs-toggle="modal" data-bs-target="#ExtralargeModal">
                                    View
                                </button></td>
                        `;

                        $("#querybody").append(tr);
                    }

                    $('#querytable').DataTable({
                        dom: '<"top-controls"fl>tp'
                    });
                    
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