$(function()
{
    //Extract the queryid from the get parameters
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const queryid = urlParams.get('queryid');

    $(".currentpage").text("Conversation").prev().remove();

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
                    showalert(response.error)
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
                        `;

                        tr += `<h6>`;
                        //If the admin has replied
                        if(chat.studentid == null && chat.adminid != null)
                        {
                            tr += `MSO`;
                        }
                        //If the student has replied
                        if(chat.studentid != null && chat.adminid == null)
                        {
                            tr += `You`;
                        }

                        tr += `<span>(${chat.timestring})</span>`;

                        tr += `</h6>`;

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

                        //Reply to the last message
                        if(i == 0)
                        {
                            tr += `
                            <div class="review-content">
                                <div class="form-file">
                                    <label for="file" class="file-upload-label">
                                        <i class="bi-paperclip" style="font-size:24px;"></i>
                                    </label>
                                    <input type="file" id="file" name="file" accept=".pdf, .doc" style="display: none;">
                                </div>
                                <a href="javascript:void(0)" class="form-icon" id="replybtn"><img src="images/icons/send-icon.png"></a>
                                <div class="form-input">
                                    <input type="text" placeholder="Reply" id="reply" class="form-control">
                                </div>
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