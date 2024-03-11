<?php
include './includes/login_required.php';
include 'includes/dbcon.php';
include 'includes/code.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../img/logo/logo.png" rel="icon">
  <title>Evaluate Script </title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/ruang-admin.min.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <style>
  .modal-body img {
    max-width: 100%;
    height: auto !important;
  }
  </style>
</head>


<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="scripts.php?index">
        <div class="sidebar-brand-icon">
          <strong>Evaluate Script</strong>
        </div>
        <div class="sidebar-brand-text mx-3"></div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Back To Admin Panel</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Features
      </div>
      <li class="nav-item">
        <a class="nav-link" href="scripts.php?Exams">
          <i class="fab fa-fw fa-wpforms"></i>
          <span>Evaluate Scripts</span>
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

        </nav>
        <!-- Topbar -->

        <?php
        if(isset($_GET['Exams'])){
          ?>
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Evaluate Scripts</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Evaluate Scripts</li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Exams</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>No</th>
                        <th>Exam ID</th>
                        <th>Exam Name</th>
                        <th>Questions</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php 
                      $i=0;
                    $select = mysqli_query($con, "SELECT * FROM exam WHERE status=1");
                    if(mysqli_num_rows($select) > 0){
                      while($row=mysqli_fetch_array($select)){
                        $i++;
                        $exam_id = $row['exam_id'];
  
                        // current time
                        date_default_timezone_set("Asia/Dhaka");
                        $date = date('Y-m-d H:i');
                        $current_time = strtotime($date);
  
                        // convert into timestamp
                          $examEndDate = $row['exam_end']." ".$row['exam_end_time'];
                          $examEndTimestamp = strtotime($examEndDate);
                       if($current_time > $examEndTimestamp){
                        ?>
                      <tr>
                        <td><?=$i?></td>
                        <td><?=$row['exam_id']?></td>
                        <td><?=$row['exam_name']?>t</td>
                        <td><?php
                        echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM written_questions WHERE exam_id='$exam_id'"));
                        ?></td>
                        <td><a href="scripts.php?Exam-ID=<?=$exam_id?>"><button
                              class="btn btn-primary btn-sm border-0 text-light">Open</button></a></td>
                      </tr>
                      <?php
                       }
                      }
                    }
                    ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!--Row-->



        </div>
        <!---Container Fluid-->
        <?php
        }elseif (isset($_GET['Exam-ID'])) {
          $exam_id = $_GET['Exam-ID'];
          ?>
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Evaluate Scripts</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Evaluate Scripts</li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Available Scripts</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>No</th>
                        <th>Student ID</th>
                        <th>Exam ID</th>
                        <th>Exam Name</th>
                        <th>Question ID</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php 
                      $i=0;
                    $select = mysqli_query($con, "SELECT * FROM written_record WHERE exam_id='$exam_id'");
                    if(mysqli_num_rows($select) > 0){
                      while($row=mysqli_fetch_array($select)){
                        $i++;
                        $exam_id = $row['exam_id'];

                        ?>
                      <tr>
                        <td><?=$i?></td>
                        <td><?=$row['student_id']?></td>
                        <td><?=$row['exam_id']?></td>
                        <td><?php
                        echo mysqli_fetch_array(mysqli_query($con,"SELECT * FROM exam WHERE exam_id='$exam_id'"))['exam_name'];
                        ?></td>
                        <td><?=$row['question_id']?></td>
                        <td><?php
                        if($row['evaluation_status'] == 1){
                          echo "<span class='badge bg-success text-white'>Evaluated</span>";
                        }else{
                          echo "<span class='badge bg-warning text-white'>Pending</span>";
                        }
                        ?></td>
                        <td><?php
                        if($row['evaluation_status'] == 1){
                          ?>
                          <a href="scripts.php?Evaluate=<?=$row['id']?>"><button
                              class="btn btn-primary btn-sm border-0 text-light">View Evaluation</button>
                          </a>
                          <?php
                        }else{
                          ?>
                          <a href="evaluate.php?Evaluate=<?=$row['id']?>"><button
                              class="btn btn-success btn-sm border-0 text-light">Start Evaluation</button>
                          </a>
                          <?php
                        }
                        ?>
                        </td>
                      </tr>
                      <?php
                       
                      }
                    }
                    ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!--Row-->



        </div>
        <!---Container Fluid-->
        <?php
        }elseif(isset($_GET['index'])){
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
          <!--Row-->

        </div>
        <!---Container Fluid-->
        <?php
        }elseif(isset($_GET['Evaluate'])){
          ?>
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <a onclick="history.back()"><button class="btn btn-danger btn-lg">Go Back</button></a>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item">Tables</li>
              <li class="breadcrumb-item active" aria-current="page">DataTables</li>
            </ol>
          </div>

          <?php
          $record_id = $_GET['Evaluate'];
          ?>
          <!-- Row -->
          <div class="row">
            <!-- DataTable with Hover -->
            <div class="col-lg-12" style="overflow-x: auto;
            white-space: nowrap;">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                </div>
                <?php
                $searchRecord = mysqli_query($con, "SELECT * FROM written_record WHERE id='$record_id'");
                if(mysqli_num_rows($searchRecord) > 0){
                  $row = mysqli_fetch_array($searchRecord);
                  $question_id = $row['question_id'];
                  $student_id = $row['student_id'];
                  $exam_id = $row['exam_id'];
                  $answered_image = $row['answered_image'];
                  
                  $searchQuestion = mysqli_query($con, "SELECT * FROM written_questions WHERE id='$question_id'");
                  if(mysqli_num_rows($searchQuestion) > 0){
                    $fetch = mysqli_fetch_array($searchQuestion);
                    $question = $fetch['question'];
                    $mark = $fetch['mark'];
                    $solution = $fetch['solution'];
                    ?>
                <div>
                  <div class="card-body">
                    <button class="btn btn-dark" data-toggle="modal" data-target="#myModal">Solution</button>
                    <b class="" style="float: right;">Mark : <?=$mark?></b>
                    <div class="form-group questionPart">
                      <p for="" class="font-weight-bold text-dark mt-3"><?=$question?></p>

                      <center><img src="../img/writtenAnswer/<?=$answered_image?>" class="img-fluid"
                          alt="Responsive image">
                      </center>

                    </div>

                  </div>

                </div>
                <?php
                  }
                }
                ?>


              </div>
            </div>
            <!--Row-->



          </div>
          <!---Container Fluid-->

          <!-- The Modal -->
          <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Solution</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                  <?=$solution?>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

              </div>
            </div>
          </div>

          <?php
        }
        ?>

        </div>
        <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto py-2">
            <div class="copyright text-center my-auto">
              <span>copyright &copy; <script>
                document.write(new Date().getFullYear());
                </script> - distributed by
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

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/ruang-admin.min.js"></script>
    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fabric@5.2.4/dist/fabric.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
    $(document).ready(function() {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
    </script>
</body>

</html>