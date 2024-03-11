<?php
$student_id = $_SESSION['student_id'];
$selectStudent = mysqli_query($con,"SELECT * FROM students WHERE student_id='$student_id'");
if(mysqli_num_rows($selectStudent) > 0){
  $studentRow = mysqli_fetch_array($selectStudent);
  $studentUserName = $studentRow['username'];
  $studentFullName = $studentRow['full_name'];
  $studentEmail = $studentRow['email'];
  $studentMobile = $studentRow['mobile'];
  $studentInstitute = $studentRow['college'];
  $studentHsc = $studentRow['hsc'];
}else{
  $studentUserName = "Not Added";
  $studentFullName = "Not Added";
}
?>
<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
      <img src="img/logo/logo2.png">
    </div>
    <div class="sidebar-brand-text mx-3">HSC Savior</div>
  </a>
  <hr class="sidebar-divider my-0">
  <li class="nav-item">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
    Exam Status
  </div>



  <li class="nav-item">
    <a class="nav-link" href="list.php?Exams">
      <i class="far fa-fw fa-window-maximize"></i>
      <span>Exams</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="list.php?Given-Exams">
      <i class="far fa-fw fa-window-maximize"></i>
      <span>Given Exams</span>
    </a>
  </li>
</ul>
<!-- Sidebar -->
<div id="content-wrapper" class="d-flex flex-column">
  <div id="content">
    <!-- TopBar -->
    <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
      <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-search fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
            <form class="navbar-search">
              <div class="input-group">
                <input type="text" class="form-control bg-light border-1 small"
                  placeholder="What do you want to look for?" aria-label="Search" aria-describedby="basic-addon2"
                  style="border-color: #3f51b5;">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>



        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <img class="img-profile rounded-circle" src="img/boy.png" style="max-width: 60px">
            <span class="ml-2 d-none d-lg-inline text-white small"><?=$studentUserName?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="details.php?Profile">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
            </a>
            <a class="dropdown-item" href="#">
              <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
              Settings
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- Topbar -->


    <!-- Modal Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to logout?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
            <a href="includes/logout.php" class="btn btn-primary">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal PassWord Change -->
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelPassword"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabelPassword">Change Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="post">
            <div class="modal-body">
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Old Password:</label>
                <input type="text" class="form-control" id="recipient-name" name="old_password"
                  placeholder="Enter Old Password">
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">New Password:</label>
                <input type="text" class="form-control" id="recipient-name" name="new_password"
                  placeholder="Enter New Password">
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Confirm Password:</label>
                <input type="text" class="form-control" id="recipient-name" name="confirm_password"
                  placeholder="Enter Confirm Password">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancel</button>
              <button type="submit" name="changePassword" class="btn btn-primary">Change</button>
            </div>
          </form>
        </div>
      </div>
    </div>