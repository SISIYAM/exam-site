<?php
include './includes/login_required.php';
include './Admin/includes/dbcon.php';

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

  .label {
    padding: 12px 40px;
    width: 100%;
    display: block;
    text-align: left;
    color: #3C454C;
    cursor: pointer;
    position: relative;
    z-index: 2;
    transition: color 200ms ease-in;
    overflow: hidden;
    border: 2px solid #cacaca;
    border-radius: 8px;

    &:before {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      content: '';
      background-color: #5562eb;
      position: absolute;
      transform: translate(-50%, -50%) scale3d(1, 1, 1);
      transition: all 300ms cubic-bezier(0.4, 0.0, 0.2, 1);
      opacity: 0;
      z-index: -1;
      padding: 100%;

    }

    &:after {
      width: 22px;
      height: 22px;
      content: '';
      border: 2px solid #D1D7DC;
      background-color: #fff;
      background-position: 2px 3px;
      border-radius: 50%;
      z-index: 2;
      position: absolute;
      left: 5px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      transition: all 200ms ease-in;
    }
  }

  .input-option:checked~.label {
    color: #fff;

    &:before {
      transform: translate(-50%, -50%) scale3d(56, 56, 1);
      opacity: 1;
    }

    &:after {
      background-color: #54E0C7;
      border-color: #54E0C7;
    }
  }

  .input-option {
    width: 32px;
    height: 32px;
    order: 1;
    z-index: 2;
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    visibility: hidden;
  }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include 'includes/nav.php' ?>

    <?php 
    if(isset($_GET['Exam-ID'])){
      $examId= $_GET['Exam-ID'];
      $selectExam = mysqli_query($con,"SELECT * FROM exam WHERE exam_id = '$examId'");
      if(mysqli_num_rows($selectExam) > 0){
        $resultRow = mysqli_fetch_array($selectExam);
        $examNme = $resultRow['exam_name'];
        $duration = $resultRow['duration'];
        $mcqMarks = $resultRow['mcq_marks'];
        $writtenMarks = $resultRow['written_marks'];
        $exam_start_date = strtotime($resultRow['exam_start']);
        $new_start_date = date('d M Y', $exam_start_date);
        $exam_start_time = strtotime($resultRow['exam_start_time']);
        $new_start_time = date('h:i A',$exam_start_time);
        $exam_end_date = strtotime($resultRow['exam_end']);
        $new_end_date = date('d M Y', $exam_end_date);
        $exam_end_time = strtotime($resultRow['exam_end_time']);
        $new_end_time = date('h:i A',$exam_end_time);
        // current time
        date_default_timezone_set("Asia/Dhaka");
        $date = date('Y-m-d H:i');
        $current_time = strtotime($date);

        // convert into timestamp
        $examStartDate = $resultRow['exam_start']." ".$resultRow['exam_start_time'];
        $examEndDate = $resultRow['exam_end']." ".$resultRow['exam_end_time'];
  
        $examStartTimestamp = strtotime($examStartDate);
        $examEndTimestamp = strtotime($examEndDate);
      }
      ?>
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">

      <?php
      if($current_time >= $examStartTimestamp && $current_time < $examEndTimestamp){
        ?>
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <b style="position:fixed; z-index:999; right:1%; top:10%;opacity: 0.9;" class="alert alert-danger">
          <div id="time-status">
            <span class="hidden" id="hours-left"></span>
            <span id="min-left"></span>
            <span id="sec-left"></span>
            left
          </div>

          <span id="session-time" style="display: none;"></span>

          <span id="break-time" style="display: none;"></span>
        </b>
      </div>
      <?php
      }
      ?>

      <div class="row">
        <?php
      if($current_time < $examStartTimestamp){
        ?>
        <div class="card text-center col-lg-12">
          <div class="card-header text-dark font-weight-bold">
            <h3> <?=$examNme?></h3>
          </div>
          <div class="card-body">
            <h6 class="card-title mb-1"><button class="badge bg-warning" style="color:#000000">Exam Will Started at
                <?=$new_start_date." ".$new_start_time?></button></h6>
            <div class="">
              <p>Total marks: <?=$mcqMarks+$writtenMarks?></p>
              <p>MCQ marks: <?=$mcqMarks?></p>
              <?php
              if($writtenMarks != 0){
                ?>
              <p>Written marks: <?=$writtenMarks?></p>
              <?php
                }
              ?>
              <p>Time: <?php
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
                      ?></p>
              <p>Number of Questions: <?php 
                    $countQuestion = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$examId'");
                    $countNumbers = mysqli_num_rows($countQuestion);
                    echo $countNumbers;
                    ?></p>
            </div>
            <a href="list.php?Exams" class="btn btn-primary">Go Back</a>
          </div>
        </div>
        <?php
      }elseif($current_time >= $examStartTimestamp && $current_time < $examEndTimestamp){
        ?>
        <div class="col-lg-12">
          <!-- Form -->
          <form action="" id="examForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="<?=$examId?>" name="exam_id">
            <input type="hidden" value="<?=$duration?>" id="timeLeft">
            <div class="card mb-4">
              <?php 
              $i = 1;
              $select = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$examId'");
              if(mysqli_num_rows($select) > 0)
              {
                while($row = mysqli_fetch_array($select)){
                  ?>
              <div class="card-body">
                <h6 class="mb-2 p-1 d-inline bg-gradient-primary rounded text-light font-weight-bold"
                  style="font-size:13px">Question : <?=$i?></h6>
                <b class="" style="float: right;">Mark : <?=$row['mark']?></b>
                <div class="form-group questionPart">
                  <p for="" class="font-weight-bold text-dark mt-3"><?=$row['question']?></p>
                  <?php
                 if(isset($row['option_1'])){
                  ?>
                  <div class="inputGroup">
                    <input class="input-option" id="radio1<?=$i?>" type="radio" name="<?=$row['id']?>" value="1" />
                    <label class="label" for="radio1<?=$i?>"><?=$row['option_1']?></label>
                  </div>
                  <?php
                 }
                 ?>
                  <?php
                 if(isset($row['option_2'])){
                  ?>
                  <div class="inputGroup">
                    <input class="input-option" id="radio2<?=$i?>" type="radio" name="<?=$row['id']?>" value="2" />
                    <label class="label" for="radio2<?=$i?>"><?=$row['option_2']?></label>
                  </div>
                  <?php
                 }
                 ?>
                  <?php
                 if(isset($row['option_3'])){
                  ?>
                  <div class="inputGroup">
                    <input class="input-option" id="radio3<?=$i?>" type="radio" name="<?=$row['id']?>" value="3" />
                    <label class="label" for="radio3<?=$i?>"><?=$row['option_3']?></label>
                  </div>
                  <?php
                 }
                 ?>
                  <?php
                 if(isset($row['option_4'])){
                  ?>
                  <div class="inputGroup">
                    <input class="input-option" id="radio4<?=$i?>" type="radio" name="<?=$row['id']?>" value="4" />
                    <label class="label" for="radio4<?=$i?>"><?=$row['option_4']?></label>
                  </div>
                  <?php
                 }
                 ?>
                  <input type="radio" checked value="5" name="<?=$row['id']?>" style="display:none;">
                </div>

              </div>

              <?php
              $i++;
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
                      ?>
              <div class="card-body">
                <h6 class="mb-2 p-1 d-inline bg-gradient-primary rounded text-light font-weight-bold"
                  style="font-size:13px">Question : <?=$no?></h6>
                <b class="" style="float: right;">Mark : <?=$WrittenRow['mark']?></b>
                <div class="form-group questionPart">
                  <p for="" class="font-weight-bold text-dark mt-3"><?=$WrittenRow['question']?></p>

                  <div>
                    <input type="file" id="" class="form-control" name="<?=$WrittenRow['id']?>">
                  </div>

                </div>

              </div>

              <?php
                  $no++;
                    }
                  
                    ?>



              <?php
            }
                  ?>
              <button type="submit" id="submitBtn" class="btn btn-success" name="submitExam">Submit</button>
              <?php
              }else{
                ?>
              <p class="alert alert-danger">No questions added yet!</p>
              <?php
              }
              ?>

            </div>

          </form>
        </div>
        <?php
      }elseif($current_time >= $examEndTimestamp){
        ?>
        <div class="card text-center col-lg-12">
          <div class="card-header text-dark font-weight-bold">
            <h3> <?=$examNme?></h3>
          </div>
          <div class="card-body">
            <h6 class="card-title mb-4"><span class="alert alert-light">Opps! The exam was finished.</span></h6>

            <a href="result.php?Leader-Board=<?=$examId?>" class="btn btn-info">Leader Board</a>
          </div>
        </div>
        <?php
      }
      ?>
      </div>
      <!--Row-->
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
  <script src="./js/script.js"></script>
  <?php include './includes/code.php';?>
</body>

</html>