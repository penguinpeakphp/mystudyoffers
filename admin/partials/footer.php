<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/vendor/chart.js/chart.umd.js"></script>
<script src="../assets/vendor/echarts/echarts.min.js"></script>
<script src="../assets/vendor/quill/quill.min.js"></script>
<script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="../assets/vendor/tinymce/tinymce.min.js"></script>
<script src="../assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="../assets/js/main.js"></script>

<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/"></script>

<script>
    let parts = window.location.href.split('/');
    if(parts[parts.length - 1] != "login.php")
    {
        $.get("../controllers/dashboard/getdashboarddata.php" , {} , function(data)
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
                    //Fill the data where necessary
                    $("#newstudents").text(response.newstudents);
                    $("#newqueries").text(response.newqueries);
                    $(".newchats").text(response.newchats);

                    for(let i=0; i<response.followups.length; i++)
                    {
                        let followup = response.followups[i];
                        $("#followupbody").append(`
                            <tr>
                                <th scope="row"><a>${followup.followupid}</a></th>
                                <td>${followup.name}</td>
                                <td><a class="text-primary">${followup.followup}</a></td>
                            </tr>
                        `);
                    }
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
        });
    }
</script>