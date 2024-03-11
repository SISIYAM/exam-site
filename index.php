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
   $studentReportCount = mysqli_query($con, "SELECT * FROM result WHERE student_id='$student_id'");
    $givenExams = mysqli_num_rows($studentReportCount);

    $examNumberCount = mysqli_query($con, "SELECT * FROM exam WHERE status = 1");
    $ActiveExamNumber = mysqli_num_rows($examNumberCount);
   ?>

    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
      </div>

      <div class="row mb-3">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-6 col-md-6 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-uppercase mb-1">Exams</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php 
                  if($ActiveExamNumber < 10){
                    echo "0".$ActiveExamNumber;
                  }else{
                    echo $ActiveExamNumber;
                  }
                  ?></div>
                  <div class="mt-2 mb-0 text-muted text-xs">
                    <span class="text-success mr-2">Available</span>
                  </div>

                </div>
                <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-primary"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-6 col-md-6 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-uppercase mb-1">Given Exams</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php 
                  if($givenExams < 10){
                    echo "0".$givenExams;
                  }else{
                    echo $givenExams;
                  }
                  ?></div>
                  <div class="mt-2 mb-0 text-muted text-xs">
                    <span class="text-danger mr-2">Already Given</span>
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-success"></i>
                </div>
              </div>
            </div>
          </div>
        </div>


        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
          <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Monthly Recap Report</h6>
              <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                  aria-labelledby="dropdownMenuLink">
                  <div class="dropdown-header">Dropdown Header:</div>
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <!-- Pie Chart -->

        <!-- Invoice Example -->

      </div>
      <!--Row-->


    </div>
    <!---Container Fluid-->
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
</body>

</html>