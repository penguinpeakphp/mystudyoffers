$(function () 
{
    async function getuniversitylist()
    {
        await $.get("../controllers/university/getuniversitylist.php" , {}, function(data) 
        {
            try 
            {
                let response = JSON.parse(data);
                if(response.success == false)
                {
                    alert(response.error);
                    
                    if(response.login == true)
                    {
                        window.location.href = "../login/login.php";
                    }
                }
                else
                {
                    $("#universitybody").html("");
                    //Loop through the response array and render the table
                    for (let i = 0; i < response.universitylist.length; i++)
                    {
                        let university = response.universitylist[i];
                        let tr = '<tr>';

                        tr += `
                            <td>${i+1}</td>
                            <td>${university.universityname}</td>
                            <td>${university.universitylicensenumber}</td>
                            <td>${university.keycontactname}</td>
                            <td>${university.keycontactemail}</td>
                        `;

                        //Render badge based on the status flag
                        if(university.universitystatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(university.universitystatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }

                        //Render buttons and have index in the data-index attribute to fetch the country details for editing
                        tr += `
                        <td>
                            <a type="button" href="adduniversity.php?view=${university.universityid}" class="btn btn-primary view" data-index="${i}" data-id="${university.universityid}">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${university.universityid}">
                                <i class="bi-pencil-square"></i>
                            </button>
                            <button type="button" class="btn btn-danger delete" data-id="${university.universityid}">
                                <i class="bi-trash"></i>
                            </button>
                        </td>`;

                        tr += '</tr>';

                        $("#universitybody").append(tr);
                    }

                    // $("#universitytable").DataTable().destroy();

                    // let universitytable = $("#universitytable")[0]; // Select the table element using jQuery

                    // new simpleDatatables.DataTable(universitytable, {
                    //     perPageSelect: [5, 10, 15, ["All", -1]],
                    //     columns: [
                    //         {
                    //             select: 2,
                    //             sortSequence: ["desc", "asc"]
                    //         },
                    //         {
                    //             select: 3,
                    //             sortSequence: ["desc"]
                    //         },
                    //         {
                    //             select: 4,
                    //             cellClass: "green",
                    //             headerClass: "red"
                    //         }
                    //     ]
                    // });

                    $(".delete").on("click", function ()
                    {
                        if(!confirm("Are you sure you want to delete this university"))
                        {
                            return;
                        }
                        let universityid = $(this).attr("data-id");

                        $.get("../controllers/university/deleteuniversity.php" , {"universityid":universityid} , function(data)
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
                                        window.location.href = "../login/login.php";
                                    }
                                }
                                else
                                {
                                    alert("University successfully deleted");
                                    getuniversitylist();
                                }
                            }
                            catch(error)
                            {
                                alert("Error occurred while trying to read server response");
                            }
                        });
                    });
                }
            } catch (error) 
            {
                alert("Error occurred while trying to read server response");
            }
        });
    }

    getuniversitylist();
});