<?php
include './includes/login_required.php';
include 'includes/dbcon.php';

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

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <a href="scripts.php?index"><button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
              <i class="fa fa-home"></i>
            </button></a>

        </nav>
        <!-- Topbar -->

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
                  }
                }
                ?>

                <div style="overflow-x: auto; white-space: nowrap;">
                  <div class="card-body">
                    <button class="btn btn-dark" data-toggle="modal" data-target="#myModal">Solution</button>
                    <b class="" style="float: right;">Mark : <?=$mark?></b>
                    <div class="form-group questionPart">
                      <p for="" class="font-weight-bold text-dark mt-3"><?=$question?></p>

                      <div style="overflow-x: auto; white-space: nowrap;">
                        <button id="draw" style="background-color:red; border:none; padding:20px 40px"></button>
                        <button id="remove" class="btn btn-danger btn-sm">Clear</button>
                        <input type="hidden" id="imgSRC" value="../img/writtenAnswer/<?=$answered_image?>">
                        <form action="" method="post" accept-charset="utf-8" id="submitForm" class="mt-3">
                          <input type="hidden" value="" id="saveImage" name="saveImage">
                          <input type="hidden" value="" id="" name="submitBtn">
                          <input type="hidden" value="<?=$student_id?>" name="studentID">
                          <input type="hidden" value="<?=$exam_id?>" name="examID">
                          <input type="hidden" value="<?=$record_id?>" name="record_id">
                          <input type="hidden" name="questionID" value="<?=$question_id?>" id="">
                          <input type="text" class="form-control col-xl-3" name="mark" placeholder="Give Mark" required>
                          <button type="submit" id="submitEvaluationBtn" class="d-none"></button>
                          <button id="tosvg" class="btn btn-primary mt-2" style="">Submit Final Evaluation</button>
                        </form>
                        <br>
                        <div style="overflow-x: auto; white-space: nowrap;">
                          <canvas id="canvas" width="800" height="800"
                            style="overflow-x: auto; white-space: nowrap;"></canvas>
                        </div>
                        <br>


                      </div>


                    </div>

                  </div>

                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fabric@5.2.4/dist/fabric.min.js"></script>
    <script src="./js/evaluate.js"></script>
    <!-- Page level custom scripts -->
    <script>
    $(document).ready(function() {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
    </script>
    <?php include 'includes/code.php'; ?>
</body>

</html>