<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link collapsed" href="../dashboard/dashboard.php">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="../adminuser/adminuser.php">
      <i class="bi bi-grid"></i>
      <span>Admin Users</span>
    </a>
  </li>

  <?php
    if($_SESSION["canaccessmaster"] == true)
    {
  ?>
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Masters</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="../country/country.php">
          <i class="bi bi-circle"></i><span>Country</span>
        </a>
      </li>
      <li>
        <a href="../state/state.php">
          <i class="bi bi-circle"></i><span>State</span>
        </a>
      </li>
      <li>
        <a href="../city/city.php">
          <i class="bi bi-circle"></i><span>City</span>
        </a>
      </li>
      <li>
        <a href="../subjectinterest/subjectinterest.php">
          <i class="bi bi-circle"></i><span>Subject of Interest</span>
        </a>
      </li>
      <li>
        <a href="../levelofcourse/levelofcourse.php">
          <i class="bi bi-circle"></i><span>Level of Course</span>
        </a>
      </li>
      <li>
        <a href="../planningyear/planningyear.php">
          <i class="bi bi-circle"></i><span>Year of Planning</span>
        </a>
      </li>
      <li>
        <a href="../testtype/testtype.php">
          <i class="bi bi-circle"></i><span>Type of Test</span>
        </a>
      </li>
      <li>
        <a href="../testscore/testscore.php">
          <i class="bi bi-circle"></i><span>Test Score</span>
        </a>
      </li>
      <li>
        <a href="../institutetype/institutetype.php">
          <i class="bi bi-circle"></i><span>Type of Institute</span>
        </a>
      </li>
      <li>
        <a href="../businessnature/businessnature.php">
          <i class="bi bi-circle"></i><span>Nature of Business</span>
        </a>
      </li>
      <li>
        <a href="../qualification/qualification.php">
          <i class="bi bi-circle"></i><span>Qualification</span>
        </a>
      </li>
      <li>
        <a href="../qualificationsub/qualificationsub.php">
          <i class="bi bi-circle"></i><span>Qualification Sub</span>
        </a>
      </li>
      <li>
        <a href="../workexperience/workexperience.php">
          <i class="bi bi-circle"></i><span>Work Experience</span>
        </a>
      </li>
      <li>
        <a href="../academic/academic.php">
          <i class="bi bi-circle"></i><span>Academic Qualification</span>
        </a>
      </li>
      <li>
        <a href="../majorsubject/majorsubject.php">
          <i class="bi bi-circle"></i><span>Major Subjects</span>
        </a>
      </li>
      <li>
        <a href="../awardingbody/awardingbody.php">
          <i class="bi bi-circle"></i><span>Awarding Body</span>
        </a>
      </li>
      <li>
        <a href="../passingyear/passingyear.php">
          <i class="bi bi-circle"></i><span>Passing Year</span>
        </a>
      </li>
      <li>
        <a href="../result/result.php">
          <i class="bi bi-circle"></i><span>Result</span>
        </a>
      </li>
      <li>
        <a href="../querytype/querytype.php">
          <i class="bi bi-circle"></i><span>Query Type</span>
        </a>
      </li>
    </ul>
  </li><!-- End Masters Nav -->
  <?php
    }
  ?>

  <li class="nav-item">
    <a class="nav-link collapsed" href="../student/student.php">
      <i class="bi-person-badge"></i>
      <span>Students</span>
    </a>
  </li><!-- End Students Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="../query/query.php">
      <i class="bi-chat-left-text"></i>
      <span>Query (<span class="newchats"></span>)</span>
    </a>
  </li><!-- End Queries Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="../followup/followup.php">
      <i class="bi-telephone-forward-fill"></i>
      <span>Follow Ups</span>
    </a>
  </li>

</ul>

</aside><!-- End Sidebar-->