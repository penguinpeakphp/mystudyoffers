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
                                    <input type="text" placeholder="More Question..?" name="" id="reply" class="form-control">
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

                        //Request the server to update the conversation with the reply
                        $.post("controllers/query/updateconversation.php" , {"queryid":queryid , "reply":reply} , function(data)
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
                                    //Reload the conversation after successul reply
                                    loadconversation();
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
                alert("Error occurred while trying to read server response " + error);
            }
        });
    }

    loadconversation();
});