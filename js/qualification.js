$(function()
{
    //Function for fetching qualification data and student's selected qualification data
    function getqualificationdata()
    {
        $.get("controllers/qualification/getqualificationmaster.php" , {} , function(data)
        {
            console.log(data);
        });
    }

    getqualificationdata();
});