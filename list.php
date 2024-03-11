<?php
include './Admin/includes/dbcon.php';
include './includes/login_required.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include './includes/head.php'; ?>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include './includes/nav.php'; ?>
    <?php
if(isset($_GET['Exams'])){
  ?>
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Exams</h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Exams</li>
        </ol>
      </div>

      <!-- Row -->
      <div class="row">


        <?php
                  $no = 1;
                  $select = mysqli_query($con, "SELECT * FROM exam WHERE status = 1 ORDER BY id DESC");
                  if(mysqli_num_rows($select) > 0){
                 
                   while($row = mysqli_fetch_array($select)){
                      $examID = $row['exam_id'];
                      $examType = $row['type'];
                      $duration = $row['duration'];
                      $exam_start_date = strtotime($row['exam_start']);
                      $new_start_date = date('d M Y', $exam_start_date);
                      $exam_start_time = strtotime($row['exam_start_time']);
                      $new_start_time = date('h:i A',$exam_start_time);
                      $exam_end_date = strtotime($row['exam_end']);
                      $new_end_date = date('d M Y', $exam_end_date);
                      $exam_end_time = strtotime($row['exam_end_time']);
                      $new_end_time = date('h:i A',$exam_end_time);
                      // current time
                      date_default_timezone_set("Asia/Dhaka");
                      $date = date('Y-m-d H:i');
                      $current_time = strtotime($date);

                      // convert into timestamp
                        $examStartDate = $row['exam_start']." ".$row['exam_start_time'];
                        $examEndDate = $row['exam_end']." ".$row['exam_end_time'];
  
                        $examStartTimestamp = strtotime($examStartDate);
                        $examEndTimestamp = strtotime($examEndDate);
                      ?>

        <div class="col-lg-6">
          <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-dark" style="font-size:22px"><?=$row['exam_name']?></h6>
              <h6 class="m-0 font-weight-bold text-dark"># <?=$no?></h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 mb-4">
                  <div class="card bg-light text-dark">
                    <div class="card-body">
                      <?php 
                      if($current_time >= $examStartTimestamp && $current_time < $examEndTimestamp){
                        ?>
                      <span class="float-right text-light"><img src="./img/live.png" width="50px" height="40px"
                          alt=""></span>
                      <?php
                      }
                      ?>

                      <div class="text-dark font-weight-bold"><span class="badge bg-dark btn-sm text-light">Total
                          Marks</span>
                        : <?=$row['mcq_marks']+$row['written_marks']?></div>
                      <div class="text-dark font-weight-bold"><span class="badge bg-dark btn-sm text-light my-2">MCQ
                          Marks</span> : <?=$row['mcq_marks']?></div>
                      <div class="text-dark font-weight-bold"><span class="badge bg-dark btn-sm text-light">Written
                          Marks</span> : <?=$row['written_marks']?></div>
                      <div class="text-dark font-weight-bold"><span class="badge bg-dark btn-sm text-light">Number
                          of questions</span> : <?php 
                    $countQuestion = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$examID'");
                    $countNumbers = mysqli_num_rows($countQuestion);
                    echo $countNumbers;
                    ?></div>
                      <div class="text-dark font-weight-bold"><span class="badge bg-dark btn-sm text-light my-2">Exam
                          Start
                        </span> : <?=$new_start_date." ".$new_start_time?></div>
                      <div class="text-dark font-weight-bold"><span class="badge bg-dark btn-sm text-light">Exam
                          End</span> : <?=$new_end_date." ".$new_end_time?></div>
                      <div class="text-dark font-weight-bold"><span class="badge bg-dark btn-sm text-light my-2">Exam
                          Duration</span> : <?php
                      if(((int)($duration/3600)) == 0 && ((int)($duration%3600)/60) != 0 && (($duration%3600)%60) != 0){
                        echo ((int)(($duration%3600)/60)." min ".(($duration%3600)%60)." Sec");
                      }elseif (((int)($duration/3600)) != 0 && ((int)($duration%3600)/60) != 0 && (($duration%3600)%60) == 0) {
                        echo ((int)($duration/3600)." hour ".(int)(($duration%3600)/60)." min " );
                      }elseif (((int)($duration/3600)) == 0 && (($duration%3600)%60) == 0 && ((int)($duration%3600)/60) != 0) {
                        echo ((int)(($duration%3600)/60)." min " );
                      }elseif (((int)($duration/3600)) != 0 && ((int)($duration%3600)/60) == 0 && (($duration%3600)%60)==0) {
                        echo ((int)($duration/3600)." hour ");
                      } else{
                        echo ((int)($duration/3600)." hour ".(int)(($duration%3600)/60)." min ".(($duration%3600)%60)." Sec");
                      }
                      ?></div>
                      <div class="my-2">
                        <?php 
                       // exam type condition 
                       if($examType == 1){
                      // check is user already give exam or not
                      $checkStudent = mysqli_query($con, "SELECT * FROM result WHERE student_id='$student_id' AND exam_id='$examID'");
                      if(mysqli_num_rows($checkStudent) > 0){
                      ?>
                        <span class="btn btn-light btn-sm">Already Given</span> <br>
                        <a href="result.php?Exam-History=<?=$row['exam_id']?>"><button
                            class="btn btn-danger mr-2 my-2">View
                            Result
                          </button></a>
                        <?php
                      }else{
                      
                      if($current_time < $examStartTimestamp){
                        ?>
                        <button style="max-width:100%; color:#000000; font-size:0.6rem;" class="badge bg-warning">Exam
                          will started at
                          <?=$new_start_date." ".$new_start_time?></button>
                        <?php
                      }elseif($current_time >= $examStartTimestamp && $current_time < $examEndTimestamp){
                        ?>
                        <a href="exam.php?Exam-ID=<?=$row['exam_id']?>"><button class="btn btn-success mr-2">Start
                          </button></a>
                        <a href="result.php?Leader-Board=<?=$row['exam_id']?>"><button
                            class="btn btn-info my-2 mx-2">Leader
                            Board</button></a>
                        <?php
                      }elseif($current_time >= $examEndTimestamp){
                        ?>
                        <button class="btn btn-light btn-sm">Finished</button>
                        <a href="result.php?Leader-Board=<?=$row['exam_id']?>"><button
                            class="btn btn-info my-2 mx-2">Leader
                            Board</button></a>
                        <?php
                      }
                      ?>
                        <!-- <a href="exam.php?Exam-ID=<?=$row['exam_id']?>"><button class="btn btn-success mr-2">Start
                        </button></a> -->
                        <?php
                      }
                       }else{     
                        if($current_time < $examStartTimestamp){
                          ?>
                        <button style="max-width:100%; color:#000000; font-size:0.6rem;" class="badge bg-warning">Exam
                          will started at
                          <?=$new_start_date." ".$new_start_time?></button>
                        <?php
                        }elseif($current_time >= $examStartTimestamp && $current_time < $examEndTimestamp){
                          ?>
                        <a href="exam.php?Exam-ID=<?=$row['exam_id']?>"><button class="btn btn-success mr-2">Start
                          </button></a>
                        <a href="result.php?Leader-Board=<?=$row['exam_id']?>"><button
                            class="btn btn-info my-2 mx-2">Leader
                            Board</button></a>
                        <?php
                        }elseif($current_time >= $examEndTimestamp){
                          ?>
                        <button class="btn btn-light btn-sm">Finished</button>
                        <a href="result.php?Leader-Board=<?=$row['exam_id']?>"><button
                            class="btn btn-info my-2 mx-2">Leader
                            Board</button></a>
                        <?php
                        }
                        ?>
                        <!-- <a href="exam.php?Exam-ID=<?=$row['exam_id']?>"><button class="btn btn-success mr-2">Start
                          </button></a> -->
                        <?php
                       
                       }
                       
                       ?>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
                $no++;
                    }
                    ?>
        <?php
                  }else{
                    echo "<p class='alert alert-danger'>No data found!</p>";
                  }
                  ?>



        <!--Row-->
      </div>
      <!---Container Fluid-->
      <?php
}elseif(isset($_GET['Given-Exams'])){
  ?>
      <!-- Container Fluid-->
      <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Given Exams</h1>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Given Exams</li>
          </ol>
        </div>

        <?php
        $no = 1;
        $searchGivenExam = mysqli_query($con, "SELECT * FROM result WHERE student_id='$student_id' ORDER BY id DESC");
        if(mysqli_num_rows($searchGivenExam) > 0){
          ?>
        <div class="row">
          <?php
         while( $givenExamRow = mysqli_fetch_array($searchGivenExam)){
          $givenExamId = $givenExamRow['exam_id'];
         
          
          
          $select = mysqli_query($con, "SELECT * FROM exam WHERE exam_id='$givenExamId' ORDER BY id DESC");
          if(mysqli_num_rows($select) > 0){
         
              $row = mysqli_fetch_array($select);
              $examID = $row['exam_id'];
              $duration = $row['duration'];
              ?>

          <div class="col-lg-6">
            <div class="card mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark" style="font-size:22px"><?=$row['exam_name']?></h6>
                <h6 class="m-0 font-weight-bold text-dark"># <?=$no?></h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 mb-4">
                    <div class="card bg-light text-dark">
                      <div class="card-body">
                        <div class="text-dark font-weight-bold"><span class="badge bg-dark btn-sm text-light">Total
                            Marks</span>
                          : <?=$row['mcq_marks']+$row['written_marks']?></div>
                        <div class="text-dark font-weight-bold"><span class="badge bg-dark btn-sm text-light my-2">MCQ
                            Marks</span> : <?=$row['mcq_marks']?></div>
                        <div class="text-dark font-weight-bold"><span class="badge bg-dark btn-sm text-light">Written
                            Marks</span> : <?=$row['written_marks']?></div>
                        <div class="text-dark font-weight-bold"><span class="badge bg-dark btn-sm text-light">Number
                            of questions</span> : <?php 
                    $countQuestion = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$examID'");
                    $countNumbers = mysqli_num_rows($countQuestion);
                    echo $countNumbers;
                    ?></div>
                        <div class="text-dark font-weight-bold"><span class="badge bg-dark btn-sm text-light my-2">Exam
                            Start
                          </span> : <?=$row['exam_start']?></div>
                        <div class="text-dark font-weight-bold"><span class="badge bg-dark btn-sm text-light">Exam
                            End</span> : <?=$row['exam_end']?></div>
                        <div class="text-dark font-weight-bold"><span class="badge bg-dark btn-sm text-light my-2">Exam
                            Duration</span> : <?php
              if(((int)($duration/3600)) == 0 && ((int)($duration%3600)/60) != 0 && (($duration%3600)%60) != 0){
                echo ((int)(($duration%3600)/60)." min ".(($duration%3600)%60)." Sec");
              }elseif (((int)($duration/3600)) != 0 && ((int)($duration%3600)/60) != 0 && (($duration%3600)%60) == 0) {
                echo ((int)($duration/3600)." hour ".(int)(($duration%3600)/60)." min " );
              }elseif (((int)($duration/3600)) == 0 && (($duration%3600)%60) == 0 && ((int)($duration%3600)/60) != 0) {
                echo ((int)(($duration%3600)/60)." min " );
              }elseif (((int)($duration/3600)) != 0 && ((int)($duration%3600)/60) == 0 && (($duration%3600)%60)==0) {
                echo ((int)($duration/3600)." hour ");
              } else{
                echo ((int)($duration/3600)." hour ".(int)(($duration%3600)/60)." min ".(($duration%3600)%60)." Sec");
              }
              ?></div>
                        <div class="my-2">
                          <a href="result.php?Exam-History=<?=$row['exam_id']?>"><button
                              class="btn btn-danger mr-2">View
                              Result
                            </button></a>
                          <a href="result.php?Leader-Board=<?=$row['exam_id']?>"><button
                              class="btn btn-info my-2">Leader
                              Board</button></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php   
            ?>
          <?php
          }else{
            echo "<p class='alert alert-danger'>No data found!</p>";
          }
          $no++;
        }
          ?>
          <!--Row-->
        </div>
        <?php
        }else{
          ?>
        <p class="alert alert-danger"> No data Found!</p>
        <?php
        }
        ?>
      </div>
      <!---Container Fluid-->
      <?php
}else{
  ?>
      <!-- Container Fluid-->
      <div class="container-fluid" id="container-wrapper">
        <div class="text-center">
          <img src="img/error.svg" style="max-height: 100px;" class="mb-3">
          <h3 class="text-gray-800 font-weight-bold">Oopss!</h3>
          <p class="lead text-gray-800 mx-auto">404 Page Not Found</p>
          <button onclick="history.back()" class="btn btn-danger">&larr; Back to Dashboard</button>
        </div>
      </div>
      <!---Container Fluid-->
      <?php
}
?>

    </div>
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
            <a href="login.html" class="btn btn-primary">Logout</a>
          </div>
        </div>
      </div>
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
  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
  $(document).ready(function() {
    $('#dataTable').DataTable(); // ID From dataTable 
    $('#dataTableHover').DataTable(); // ID From dataTable with Hover
  });
  </script>

</body>

</html>