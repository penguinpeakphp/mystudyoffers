$(function()
{
    //Function for getting the followups
    function getfollowuplist()
    {
        $.get("../controllers/followup/getfollowups.php" , {} , function(data)
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
                    for(let i=0; i<response.followups.length; i++)
                    {
                        let followup = response.followups[i];
                        let tr = `
                            <tr>
                                <th scope="row">${followup.followupid}</th>
                                <td>${followup.name}</td>
                                <td>${followup.followup}</td>
                                <td>${followup.noteaddedon}</td>
                                <td>${followup.nextfollowupdate}</td>
                        `;
                        $("#followupbody").append(tr);
                    }

                    //Initialize data table
                    $("#followup").DataTable({
                        dom: '<"top-controls"fl>t'
                    });
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response " + error);
            }
        });
    }

    getfollowuplist();
});