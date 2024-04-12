$(function()
{
    $.get("controllers/student/getstudentdata.php" , {} , function(data)
    {
        console.log(data);
    });
});