$(function()
{
    //Extract the queryid from the get parameters
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const queryid = urlParams.get('queryid');

    //Function for loading conversation
    function loadconversation()
    {
        $(".review-section").html("");
        $.get("controllers/query/getconversation.php" , {"queryid":queryid} , function(data)
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
                    //Loop through the conversation
                    for(let i=0; i<response.conversation.length; i++)
                    {
                        let chat = response.conversation[i];
                        let tr = `
                        <div class="review-list">
                            <div class="review-box d-block">
                                <div class="review-img">
                                    <img src="images/icons/usericon.png" class="img-fluid" />
                                </div>
                                <div class="review-detail">
                        `;

                        //If the admin has replied
                        if(chat.studentid == null && chat.adminid != null)
                        {
                            tr += `<h6>MSO</h6>`;
                        }
                        //If the student has replied
                        if(chat.studentid != null && chat.adminid == null)
                        {
                            tr += `<h6>You</h6>`
                        }

                        tr += `<span>${chat.timestring}</span>`;

                        //Check if the file was attached or not
                        if(chat.filename != null)
                        {
                            tr += `<p><a href="conversationfiles/${chat.filename}" target="_blank">View File</a></p>`;
                        }

                        tr += `
                                    <p>
                                        ${chat.message}
                                    </p>
                               `;

                        //If the last message is sent by the admin, render reply section
                        if(chat.adminid != null && i == 0)
                        {
                            tr += `
                                <div class="review-content">
                                    <a href="javscript:void(0)" class="form-icon" id="replybtn"><img src="images/icons/send-icon.png"></a>
                                    <input type="file" name="file" id="file" accept=".pdf, .doc" />
                                    <input type="text" placeholder="Reply" name="" id="reply" class="form-control">
                                </div>
                            `;
                        }

                        tr += `</div>
                            </div>
                        </div>`;

                        //Append the chat
                        $(".review-section").append(tr);
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
                            url: "controllers/query/updateconversation.php",
                            type: "POST",
                            data:  formdata,
                            contentType: false,
                            processData: false,
                            success: function(data)
                            {
                                console.log(data);
                                return;
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
                                        //Reload the conversation after successul reply
                                        loadconversation();
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
                alert("Error occurred while trying to read server response " + error);
            }
        });
    }

    loadconversation();
});