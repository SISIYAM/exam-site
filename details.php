<?php
include './includes/login_required.php';
include './Admin/includes/dbcon.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include './includes/head.php'; ?>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include 'includes/nav.php' ?>
    <?php
    if(isset($_GET['Profile'])){
      ?>
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Personal Information</h1>

      </div>
      <div class="row">
        <div class="col-lg-12">
          <!-- Form Basic -->
          <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
            </div>
            <div class="card-body">
              <?php ?>
              <form action="" method="post">
                <div class="form-group">
                  <label for="">Full Name</label>
                  <input type="text" class="form-control" value="<?=$studentFullName?>" id="" name="full_name">
                </div>
                <div class="form-group">
                  <label for="">Username</label>
                  <input type="text" class="form-control" value="<?=$studentUserName?>" id="" name="username" required>
                </div>
                <div class="form-group">
                  <label for="">Mobile Number</label>
                  <input type="text" class="form-control" value="<?=$studentMobile?>" id="" name="mobile">
                </div>
                <div class="form-group">
                  <label for="">Email address</label>
                  <input type="email" class="form-control" value="<?=$studentEmail?>" id="" name="email" required>
                </div>
                <div class="form-group">
                  <label for="">Institute</label>
                  <input type="text" class="form-control" value="<?=$studentInstitute?>" id="" name="college">
                </div>
                <div class="form-group">
                  <label for="">HSC</label>
                  <input type="text" class="form-control" value="<?=$studentHsc?>" id="" name="hsc">
                </div>

                <button type="submit" name="updateStudentsInformation" class="btn btn-primary">Update</button>
                <button type="button" value="<?=$student_id?>" class="btn btn-info" href="javascript:void(0);"
                  data-toggle="modal" data-target="#passwordModal">
                  Change Password
                </button>
              </form>
            </div>
          </div>
        </div>
        <!--Row-->




      </div>
      <!---Container Fluid-->



      <?php
    }else{
      echo "Page not Found";
    }
?>
    </div>
    <!-- Footer -->
    <footer class="sticky-footer bg-white">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>copyright &copy; <script>
            document.write(new Date().getFullYear());
            </script> - developed by
            <b><a href="#" target="_blank">Siyam</a></b>
          </span>
        </div>
      </div>

    </footer>
    <!-- Footer -->
  </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="./Admin/js/sweetalert.js"></script>
  <script src="./js/script.js"></script>
  <?php include './includes/code.php';?>
</body>

</html>