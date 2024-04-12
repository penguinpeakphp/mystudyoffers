<div class="flex-item flex-item-1">
    <h2 class="text">Student Dashboard</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item"><a href="dashboard.php">Student Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Edit Profile
            </li>
        </ol>
    </nav>
</div>
<h4 class="error-msg"></h4>
<div class="flex-item flex-item-2">
    <a href="#" class="notification_content"><img src="images/notifications-1.png" class="notifiction-img" />
        <span>0</span></a>

    <a href="#"><img src="images/user.png" alt /></a>
    <div class="d-flex flex-column">
        <h6 class="user-detail mb-0 name"><?= $_SESSION["name"] ?></h6>
        <!--<span class="user-detail-info">1234</span>-->
    </div>
</div>