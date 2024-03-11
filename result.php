<?php
include './Admin/includes/dbcon.php';
include './includes/login_required.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php'; ?>
  <style>
  .inputGroup {
    background-color: #fff;
    display: block;
    margin: 10px 0;
    position: relative;
  }

  label {
    padding: 12px;
    width: 100%;
    display: block;
    text-align: left;
    color: #3C454C;
    cursor: pointer;
    position: relative;
    z-index: 2;
    overflow: hidden;
    border: 2px solid #cacaca;
    border-radius: 8px;
  }

  input {
    width: 32px;
    height: 32px;
    order: 1;
    z-index: 2;
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
  }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include 'includes/nav.php' ?>

    <?php 
    if(isset($_GET['Exam-History'])){
      $exam_id = $_GET['Exam-History'];
      $select = mysqli_query($con, "SELECT * FROM exam WHERE exam_id='$exam_id'");
      if(mysqli_num_rows($select) > 0){
        $ExamRow = mysqli_fetch_array($select);

        $examName = $ExamRow['exam_name'];
        $totalMarks = $ExamRow['mcq_marks'] + $ExamRow['written_marks'];
        $mcq_marks = $ExamRow['mcq_marks'];
        $written_marks = $ExamRow['written_marks'];
        $examStart = $ExamRow['exam_start'];
        $examEnd = $ExamRow['exam_end']; 
        $duration = $ExamRow['duration'];
      }else{
        $examName = "N/A";
        $totalMarks = "N/A";
        $mcq_marks = "N/A";
        $written_marks = "N/A";
        $examStart = "N/A";
        $examEnd = "N/A";
        $duration = "N/A";
      }
      ?>
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?=$examName?> | Result</h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=$examName?></li>
        </ol>
      </div>

      <div class="row">
        <!-- Background Gradient Utilities -->

        <div class="col-lg-6">
          <div class="card sm mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-dark"><?=$studentFullName?></h6>
            </div>
            <center>
              <div class="card-body">
                <div class="row">
                  <?php
                  $showResult = mysqli_query($con, "SELECT * FROM result WHERE student_id='$student_id' AND exam_id='$exam_id'");
                  if(mysqli_num_rows($showResult) > 0){
                    $showResultRow = mysqli_fetch_array($showResult);
                    ?>
                  <div class="col-lg-6 mb-4">
                    <div class="card bg-gradient-primary text-white">
                      <div class="card-body">
                        Obtained Marks
                        <div class="text-white font-weight-bold"><?=$showResultRow['result']?></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 mb-4">
                    <div class="card bg-gradient-success text-white">
                      <div class="card-body">
                        Right Answered
                        <div class="text-white font-weight-bold"><?=$showResultRow['right_answered']?></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 mb-4">
                    <div class="card bg-gradient-danger text-white">
                      <div class="card-body">
                        Wrong Answered
                        <div class="text-white font-weight-bold"><?=$showResultRow['wrong_answered']?></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 mb-4">
                    <div class="card bg-gradient-info text-white">
                      <div class="card-body">
                        Not Answered
                        <div class="text-white font-weight-bold"><?=$showResultRow['not_answered']?></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12 mb-4">
                    <div class="card bg-gradient-secondary text-white">
                      <div class="card-body">
                        Merit Position
                        <div class="text-white font-weight-bold">789</div>
                      </div>
                    </div>
                  </div>
                  <?php
                  }
                  ?>

                </div>
              </div>
            </center>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-dark">Exam Information</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 mb-4">
                  <div class="card bg-light text-dark">
                    <div class="card-body">
                      <div class="text-dark font-weight-bold">Name: <?=$examName?></div>
                      <div class="text-dark font-weight-bold">Total Marks: <?=$totalMarks?></div>
                      <div class="text-dark font-weight-bold">MCQ Marks: <?=$mcq_marks?></div>
                      <div class="text-dark font-weight-bold">Written Marks: <?=$written_marks?></div>
                      <div class="text-dark font-weight-bold">Exam Date: <?=$examStart?></div>
                      <div class="text-dark font-weight-bold">Exam End: <?=$examEnd?></div>
                      <div class="text-dark font-weight-bold">Exam Duration: <?php
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
                        <a href="result.php?Solution=<?=$exam_id?>"><button class="btn btn-primary mr-2">View
                            Solution</button></a>
                        <a href="result.php?Leader-Board=<?=$exam_id?>"> <button class="btn btn-dark my-2">Leader
                            Board</button></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <!--Row-->
    </div>
    <!---Container Fluid-->
    <?php
    }elseif(isset($_GET['Solution'])){
      $examId = $_GET['Solution'];
      $select = mysqli_query($con, "SELECT * FROM exam WHERE exam_id='$examId'");
      if(mysqli_num_rows($select) > 0){
        $examName = mysqli_fetch_array($select)['exam_name'];
      }else{
        $examName = "N/A";
      }
      ?>
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?=$examName?></h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item">Exam</li>
          <li class="breadcrumb-item active" aria-current="page"><?=$examName?></li>
        </ol>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <!-- Form -->
          <form action="" method="post">
            <input type="hidden" value="<?=$examId?>" name="exam_id">
            <div class="card mb-4">
              <?php 
              $i = 1;
              $select = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$examId'");
              if(mysqli_num_rows($select) > 0)
              {
                while($row = mysqli_fetch_array($select)){
                  $questionID = $row['id'];
                  $correctAnswer = $row['answer'];
                  $matchQuestion = mysqli_query($con, "SELECT * FROM record WHERE exam_id='$examId' AND student_id='$student_id' AND question_id='$questionID'");
                  if(mysqli_num_rows($matchQuestion) > 0){
                    $answeredOption = mysqli_fetch_array($matchQuestion)['answered'];
                  }else{
                    $answeredOption = 5;
                  }
                  ?>

              <div class="card-body">
                <h6 class="mb-2 p-1 d-inline bg-gradient-primary rounded text-light font-weight-bold"
                  style="font-size:13px">Question : <?=$i?></h6>
                <b class="" style="float: right;">Mark : <?=$row['mark']?></b>
                <div class="form-group questionPart">
                  <p for="" class="font-weight-bold text-dark mt-3"><?=$row['question']?></p>

                  <!-- if user answered correct answer then -->
                  <?php
                  if($answeredOption == $correctAnswer){
                    ?>

                  <div class="inputGroup">
                    <label <?php if($answeredOption == 1){
                      ?> class="alert alert-success" <?php
                    } ?> for="radio1<?=$i?>"><?=$row['option_1']?></label>
                  </div>

                  <div class="inputGroup">
                    <label <?php if($answeredOption == 2){
                      ?> class="alert alert-success" <?php
                    } ?> for="radio2<?=$i?>"><?=$row['option_2']?></label>
                  </div>

                  <div class="inputGroup">
                    <label <?php if($answeredOption == 3){
                      ?> class="alert alert-success" <?php
                    } ?> for="radio3<?=$i?>"><?=$row['option_3']?></label>
                  </div>

                  <div class="inputGroup">
                    <label <?php if($answeredOption == 4){
                      ?> class="alert alert-success" <?php
                    } ?> for="radio4<?=$i?>"><?=$row['option_4']?></label>
                  </div>
                  <?php
                  }elseif($answeredOption == 5){
                    ?>
                  <span class="btn btn-light">Not Answered</span>
                  <div class="inputGroup">
                    <label <?php if($correctAnswer == 1){
                      ?> class="alert alert-success" <?php
                    } ?> for="radio1<?=$i?>"><?=$row['option_1']?></label>
                  </div>

                  <div class="inputGroup">
                    <label <?php if($correctAnswer == 2){
                      ?> class="alert alert-success" <?php
                    } ?> for="radio2<?=$i?>"><?=$row['option_2']?></label>
                  </div>

                  <div class="inputGroup">
                    <label <?php if($correctAnswer == 3){
                      ?> class="alert alert-success" <?php
                    } ?> for="radio3<?=$i?>"><?=$row['option_3']?></label>
                  </div>

                  <div class="inputGroup">
                    <label <?php if($correctAnswer == 4){
                      ?> class="alert alert-success" <?php
                    } ?> for="radio4<?=$i?>"><?=$row['option_4']?></label>
                  </div>
                  <?php
                  }else{
                    ?>
                  <div class="inputGroup">
                    <label <?php if($answeredOption == 1){
                        ?> class="alert alert-danger" <?php
                      } if($correctAnswer == 1){
                        ?> class="alert alert-success" <?php
                      } ?> for="radio1<?=$i?>"><?=$row['option_1']?></label>
                  </div>

                  <div class="inputGroup">
                    <label <?php if($answeredOption == 2){
                        ?> class="alert alert-danger" <?php
                      } if($correctAnswer == 2){
                        ?> class="alert alert-success" <?php
                      } ?> for="radio2<?=$i?>"><?=$row['option_2']?></label>
                  </div>

                  <div class="inputGroup">
                    <label <?php if($answeredOption == 3){
                        ?> class="alert alert-danger" <?php
                      } if($correctAnswer == 3){
                        ?> class="alert alert-success" <?php
                      } ?> for="radio3<?=$i?>"><?=$row['option_3']?></label>
                  </div>

                  <div class="inputGroup">
                    <label <?php if($answeredOption == 4){
                        ?> class="alert alert-danger" <?php
                      }if($correctAnswer == 4){
                        ?> class="alert alert-success" <?php
                      } ?> for="radio4<?=$i?>"><?=$row['option_4']?></label>
                  </div>
                  <?php
                  }
                  ?>

                  <?php
                  if($row['solution'] > 0){
                    ?>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-12 mb-4">
                        <div class="card bg-light text-dark">
                          <div class="card-body rounded" style="border:2px solid #2EAD1E">
                            <span class="font-weight-bold text-dark">Solution:</span>
                            <div class="solution">
                              <?=$row['solution']?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                  }
                  ?>
                </div>

              </div>

              <?php
              $i++;
                }
              
              }
              ?>

              <?php
                  $no = $i;
                  $writtenQuestion = mysqli_query($con, "SELECT * FROM written_questions WHERE exam_id='$examId'");
                  if(mysqli_num_rows($writtenQuestion) > 0)
                  {
                    ?>

              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-center alert alert-dark">
                <h6 class="m-0 font-weight-bold text-light h4">Written Part</h6>

              </div>
              <?php 
                    while($WrittenRow=mysqli_fetch_array($writtenQuestion)){
                      $writtenQuestion_id = $WrittenRow['id'];
                      $searchWrittenRecord = mysqli_query($con, "SELECT * FROM written_record WHERE exam_id='$examId' AND student_id='$student_id' AND question_id='$writtenQuestion_id'");
                      if(mysqli_num_rows($searchWrittenRecord) > 0){
                        $writtenRecordRow = mysqli_fetch_array($searchWrittenRecord);
                        $writtenMark = $writtenRecordRow['mark'];
                        $answeredImage = $writtenRecordRow['answered_image'];
                      }else{
                        $writtenMark = 0;
                        $answeredImage = "";
                      }
                      ?>
              <div class="card-body">
                <h6 class="mb-2 p-1 d-inline bg-gradient-primary rounded text-light font-weight-bold"
                  style="font-size:13px">Question : <?=$no?></h6>
                <b class="" style="float: right;">Mark : <?php
                if($writtenMark == 0){
                  ?>
                  <span class="text-danger"><?=$writtenMark?></span>
                  <?php
                }else{
                  ?>
                  <span class="text-success"><?=$writtenMark?></span>
                  <?php
                }
                ?>
                  /<?=$WrittenRow['mark']?></b>
                <div class="form-group questionPart">
                  <p for="" class="font-weight-bold text-dark mt-3"><?=$WrittenRow['question']?></p>

                  <?php 
                 if($answeredImage != ""){
                  ?>
                  <img src="./img/writtenAnswer/<?=$answeredImage?>" class="img-fluid" alt="Responsive image">
                  <?php
                 }else{
                  ?>
                  <b class="btn btn-light">Not Answered</b>
                  <?php
                 }
                 ?>
                  <?php
                  if($WrittenRow['solution'] > 0){
                    ?>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-12 mb-4">
                        <div class="card bg-light text-dark">
                          <div class="card-body rounded" style="border:2px solid #2EAD1E">
                            <span class="font-weight-bold text-dark">Solution:</span>
                            <div class="solution">
                              <?=$WrittenRow['solution']?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                  }
                  ?>

                </div>

              </div>

              <?php
                  $no++;
                    }
                  
                    ?>



              <?php
            }
            ?>

            </div>

          </form>
        </div>
      </div>
      <!--Row-->
    </div>
    <!---Container Fluid-->
    <?php
    }elseif(isset($_GET['Leader-Board'])){
      $no =1;
      $LeaderBoardExamId = $_GET['Leader-Board'];
      $select = mysqli_query($con, "SELECT * FROM result WHERE exam_id='$LeaderBoardExamId' ORDER BY result DESC");

      // select exam name
      $selectExamName = mysqli_query($con, "SELECT * FROM exam WHERE exam_id='$LeaderBoardExamId'");
      if(mysqli_num_rows($selectExamName) > 0){
        $NameOfExam = mysqli_fetch_array($selectExamName)['exam_name'];
      }else{
        $NameOfExam = "";
      }
      ?>
    <div class="col-xl-12 col-lg-7 mb-4">
      <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary"><?=$NameOfExam?></h6>
        </div>
        <?php
        if(mysqli_num_rows($select) > 0){
        ?>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Merit</th>
              <th scope="col">Name</th>
              <th scope="col">Institute</th>
              <th scope="col">Mark</th>
            </tr>
          </thead>
          <tbody>

            <?php
      while($row=mysqli_fetch_array($select)){
        $student_id = $row['student_id'];
        $searchStudentInfo = mysqli_query($con, "SELECT * FROM students WHERE student_id='$student_id'");
        if(mysqli_num_rows($searchStudentInfo) > 0){
          $studentRow = mysqli_fetch_array($searchStudentInfo);
          $studentFullName = $studentRow['full_name'];
          $studentCollege = $studentRow['college'];
        }
        ?>
            <tr>
              <th scope="row"><?=$no?></th>
              <td><?=$studentFullName?></td>
              <td><?=$studentCollege?></td>
              <td><?=$row['result']?></td>
            </tr>
            <?php
      $no++;
      }
      ?>
          </tbody>
        </table>
        <?php
      }else{
        echo "<p class='alert alert-danger'>No data found!</p>";
      }
      ?>
        <div class="card-footer"></div>
      </div>
    </div>
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
  </div>
  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>copyright &copy;
          <script>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="./Admin/js/sweetalert.js"></script>


</body>

</html>