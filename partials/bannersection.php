<section class="banner-section mb-4">
    <div class="banner-content ">
        <small><?= date("d-m-Y") ?></small>
        <h2>Welcome back, <span class="name"><?= $_SESSION["name"] ?></span>!</h2>
        <p>Always stay updated in your student portal</p>

        <div class="search-option">
            <div>
                <label for="exampleFormControlInput1" class="form-label"><img src="images/icons/teacher.png" />Course Search</label>
                <div class="search-content">
                    <a class="form-icon"><img src="images/icons/search.png" /></a>
                    <input type="text" placeholder="Search..." name class="form-control" />
                </div>
            </div>

        </div>
    </div>
</section>