<div class="flex-item flex-item-1">
    <h2 class="text currentpage"></h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active currentpage" aria-current="page"></li>
        </ol>
    </nav>
</div>
<div class="flex-item flex-item-2">
    <div class="notification-icon d-none" onmouseover="showNotifications()" onmouseout="hideNotifications()">
        <a href="#" class="notification_content"><img src="images/notifications-1.png" class="notifiction-img" /> <span>05</span></a>
        <div class="notification-dropdown" id="notificationDropdown">
            <div class="notification-item">
                <div class="notification-box">
                    <div class="notification-img">
                        <img src="images/users/c1.jpg" class="img-fluid rounded-circle" />
                    </div>
                    <div class="notification-detail">
                        <h6>Lorem ipsum dolor sit amet.</h6>
                        <span>05/03/2024 . 3:00 pm</span>
                    </div>
                </div>
            </div>
            <div class="notification-item">
                <div class="notification-box">
                    <div class="notification-img">
                        <img src="images/users/c2.jpg" class="img-fluid rounded-circle" />
                    </div>
                    <div class="notification-detail">
                        <h6>Lorem ipsum dolor sit amet.</h6>
                        <span>05/03/2024 . 3:00 pm</span>
                    </div>
                </div>
            </div>
            <div class="notification-item">
                <div class="notification-box">
                    <div class="notification-img">
                        <img src="images/users/c3.jpg" class="img-fluid rounded-circle" />
                    </div>
                    <div class="notification-detail">
                        <h6>Lorem ipsum dolor sit amet.</h6>
                        <span>05/03/2024 . 3:00 pm</span>
                    </div>
                </div>
            </div>
            <div class="notification-item">
                <div class="notification-box">
                    <div class="notification-img">
                        <img src="images/users/c4.jpg" class="img-fluid rounded-circle" />
                    </div>
                    <div class="notification-detail">
                        <h6>Lorem ipsum dolor sit amet.</h6>
                        <span>05/03/2024 . 3:00 pm</span>
                    </div>
                </div>
            </div>
            <div class="text-center p-2">
                <a href="notification.html" class="text-dark fw-bolder">View All Notification</a>
            </div>
        </div>
    </div>

    <a href="#"><img src="images/user.png" class="profilepic" alt /></a>
    <div class="d-flex flex-column">
        <h6 class="user-detail mb-0"><?= $_SESSION["name"] ?></h6>
    </div>
</div>
<script>
    function showNotifications() {
        document.getElementById("notificationDropdown").style.display = "block";
    }

    function hideNotifications() {
        document.getElementById("notificationDropdown").style.display = "none";
    }
</script>