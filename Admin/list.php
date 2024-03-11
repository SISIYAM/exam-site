<?php
include './includes/login_required.php';
include 'includes/dbcon.php';
include 'includes/code.php';
?>
<!DOCTYPE html>
<html lang="en">

<?php
include 'includes/head.php';
?>
<style>
.table tbody tr td span {
  cursor: pointer;

}
</style>


<body>
  <?php include 'includes/nav.php'; ?>
  <div id="main">
    <header class="mb-3">
      <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
      </a>
    </header>

    <?php if (isset($_GET['Exam'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Exams List
            </h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <?php
                  $no = 0;
                  $select = mysqli_query($con, "SELECT * FROM exam ORDER BY id DESC");
                  if(mysqli_num_rows($select) > 0){
                    ?>

              <table class="table" id="table1" style="font-size:14px">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Exam ID</th>
                    <th>Exam Name</th>
                    <th>Exam Date</th>
                    <th>Questions</th>
                    <th>MCQ Marks</th>
                    <th>Written Marks</th>
                    <th>Duration</th>
                    <th>Author</th>
                    <td>Status</td>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while($row = mysqli_fetch_array($select)){
                  $no ++;
                  $duration = $row['duration'];
                  $examID = $row['exam_id'];
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
                 
                  ?>
                  <tr>
                    <td><?=$no?></td>
                    <td><?=$row['exam_id'];?></td>
                    <td><?=$row['exam_name'];?></td>
                    <td>
                      <?=$new_start_date." ".$new_start_time." to ".$new_end_date." ".$new_end_time?>
                    </td>
                    <td><?php 
                    $countQuestion = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$examID'");
                    $countNumbers = mysqli_num_rows($countQuestion);
                    echo $countNumbers;
                    ?></td>
                    <td><?=$row['mcq_marks'];?></td>
                    <td><?=$row['written_marks'];?></td>
                    <td>
                      <?php
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
                      ?>

                    </td>
                    <td><?=$row['added_by'];?></td>
                    <td><?php
                    if($row['status'] == 1){
                      ?>
                      <button value="<?=$row['id'] ?>"
                        class="badge bg-success border-0 unPublishExamBtn">Published</button>
                      <?php
                    }else{
                      ?>
                      <button value="<?=$row['id'] ?>"
                        class="badge bg-danger border-0 publishExamBtn">Unpublished</button>
                      <?php
                    }
                    ?>
                    </td>
                    <td>
                      <?php 
                      $examStartDate = $row['exam_start']." ".$row['exam_start_time'];
                      $examEndDate = $row['exam_end']." ".$row['exam_end_time'];

                      $examStartTimestamp = strtotime($examStartDate);
                      $examEndTimestamp = strtotime($examEndDate);
                      
                      if($current_time < $examStartTimestamp){
                        ?>
                      <span class="badge bg-warning">Not Start</span>
                      <?php
                      }elseif($current_time >= $examStartTimestamp && $current_time < $examEndTimestamp){
                        ?>
                      <span class="badge bg-danger">Live</span>
                      <?php
                      }elseif($current_time >= $examEndTimestamp){
                        ?>
                      <span class="badge bg-light">Finished</span>
                      <?php
                      }
                      
                    ?>
                    </td>
                    <td><button value="<?=$row['id']?>" class="badge bg-primary border-0 editExamBtn"
                        data-bs-toggle="modal" data-bs-target="#examEditModal">Edit</button></td>
                    <td><button value="<?=$row['id']?>" class="badge bg-danger border-0 deleteExamBtn">Delete</button>
                    </td>
                  </tr>
                  <?php
                    }
                  }else{
                    ?>
                  <tr>

                    <p class="alert alert-danger"> No Result Found!</p>

                  </tr>
                  <?php
                  }
                  ?>
              </table>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>
    <!--scrolling content Modal -->
    <div class="modal fade" id="examEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="" method="post">
            <div class="modal-body" id="examModalContent">


            </div>
          </form>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
            <button type="button" id="saveExamBtn" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>

    <?php
    }elseif (isset($_GET['Questions'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Question List
            </h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <?php
                  $no = 0;
                  $select = mysqli_query($con, "SELECT * FROM questions ORDER BY id DESC");
                  if(mysqli_num_rows($select) > 0){
                    ?>
              <table class="table" id="table1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Exam ID</th>
                    <th>Questions</th>
                    <th>Mark</th>
                    <th>Negative Mark</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                while($row = mysqli_fetch_array($select)){
                  $no ++;
                  ?>
                  <tr>
                    <td><?=$no;?></td>
                    <td><?=$row['exam_id'];?></td>
                    <td><?=$row['question']?></td>
                    <td><?=$row['mark']?></td>
                    <td><?=$row['negative_mark']?></td>
                    <td><a href="add.php?Update-Questions=<?=$row['id']?>"><span
                          class="badge bg-primary">Edit</span></a></td>
                    <td><button class="badge bg-danger border-0 deleteQuestionBtn"
                        value="<?=$row['id']?>">Delete</button></td>
                  </tr>
                  <?php
                    }
                  }else{
                    ?>
                  <tr>

                    <p class="alert alert-danger"> No Result Found!</p>

                  </tr>
                  <?php
                  }
                  ?>
              </table>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>
    <?php
    } elseif (isset($_GET['Students'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Students List
            </h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <?php
                  $no = 1;
                  $select = mysqli_query($con, "SELECT * FROM students ORDER BY id DESC");
                  if(mysqli_num_rows($select) > 0){
                    ?>
              <table class="table" id="table1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while($row=mysqli_fetch_array($select)){
                    ?>
                  <tr>
                    <td><?=$no?></td>
                    <td><?=$row['student_id']?></td>
                    <td><?=$row['username']?></td>
                    <td><?=$row['full_name']?></td>
                    <td>
                      <button type="button" value="<?=$row['id']?>"
                        class="badge bg-primary border-0 viewStudentInformationBtn" data-bs-toggle="modal"
                        data-bs-target="#studentInformationModal">
                        View
                      </button>
                    </td>
                    <td>
                      <button value="<?=$row['id']?>" class="badge bg-danger border-0 deleteStudentBtn">Delete</button>
                    </td>
                  </tr>
                  <?php
                  $no++;
                  }
                  ?>


              </table>
              <?php
                }else{
                ?>
              <tr>

                <p class="alert alert-danger"> No Result Found!</p>

              </tr>
              <?php
                }
                ?>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>

    <!--scrolling content Modal -->
    <div class="modal fade" id="studentInformationModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-body" id="studentModalContent">


          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Close</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <?php
    }elseif (isset($_GET['Teachers'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Teachers List
            </h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <?php
                  $no = 1;
                  $select = mysqli_query($con, "SELECT * FROM admin WHERE post='0' ORDER BY id DESC");
                  if(mysqli_num_rows($select) > 0){
                    ?>
              <table class="table" id="table1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <?php
                    if($_SESSION['post'] == 1){
                      ?>
                    <th></th>
                    <th></th>
                    <?php
                    }
                    ?>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  while($row = mysqli_fetch_array($select)){
                    ?>
                  <tr>
                    <td><?=$no?></td>
                    <td><?=$row['id']?></td>
                    <td><?=$row['full_name']?></td>
                    <td><?=$row['username']?></td>
                    <td><?=$row['email']?></td>
                    <td><?=$row['mobile']?></td>
                    <?php
                    if($_SESSION['post'] == 1){
                      ?>


                    <td>
                      <?php
                      if($row['status'] == 0){
                        ?>
                      <button value="<?=$row['id']?>"
                        class="badge bg-warning border-0 teacherActivateBtn">Deactivate</button>
                      <?php
                      }else{
                        ?>
                      <button value="<?=$row['id']?>"
                        class="badge bg-success border-0 teacherDeactivateBtn">Active</button>
                      <?php
                      }
                      ?>
                    </td>

                    <td>

                      <button value="<?=$row['id']?>" class="badge bg-danger border-0 deleteTeacher">Delete</button>
                    </td>

                    <?php
                    }
                    ?>
                  </tr>
                  <?php
                   $no++;
                  }
                  ?>
              </table>
              <?php
                  }else{
                   ?>
              <tr>

                <p class="alert alert-danger"> No Result Found!</p>

              </tr>
              <?php 
                  }
                  ?>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>
    <?php
    }elseif (isset($_GET['Admins'])) {
      ?>
    <div class="page-heading">
      <!-- Basic Tables start -->
      <section class="section">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
              Admins List
            </h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <?php
                  $no = 1;
                  $select = mysqli_query($con, "SELECT * FROM admin WHERE post='1' ORDER BY id DESC");
                  if(mysqli_num_rows($select) > 0){
                    ?>
              <table class="table" id="table1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while($row = mysqli_fetch_array($select)){
                    ?>
                  <tr>
                    <td><?=$no?></td>
                    <td><?=$row['id']?></td>
                    <td><?=$row['full_name']?></td>
                    <td><?=$row['username']?></td>
                    <td><?=$row['email']?></td>
                    <td><?=$row['mobile']?></td>
                    <td><button class="badge bg-danger border-0 deleteAdminBtn" value="<?=$row['id']?>">Delete</button>
                    </td>
                  </tr>
                  <?php
                   $no++;
                  }
                  ?>
              </table>
              <?php
                  }else{
                   ?>
              <tr>

                <p class="alert alert-danger"> No Result Found!</p>

              </tr>
              <?php 
                  }
                  ?>
            </div>
          </div>
        </div>

      </section>
      <!-- Basic Tables end -->
    </div>


    <?php
    }else {
      ?>
    <div id="error">
      <div class="error-page container">
        <div class="col-md-6 col-12 offset-md-2">
          <div class="text-center">
            <img class="img-error" src="./assets/compiled/svg/error-404.svg" alt="Not Found">
            <h1 class="error-title">NOT FOUND</h1>
            <p class='fs-5 text-gray-600'>The page you are looking not found.</p>
            <button onclick="history.back()" class="btn btn-lg btn-outline-primary mt-3">Go Home</button>
          </div>
        </div>
      </div>
    </div>
    <?php
    } ?>

    <?php include 'includes/footer.php'; ?>
  </div>
  </div>
  <script src="assets/static/js/components/dark.js"></script>
  <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="assets/compiled/js/app.js"></script>
  <script src="assets/extensions/jquery/jquery.min.js"></script>
  <script src="assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/static/js/pages/datatables.js"></script>
  <script src="assets/extensions/sweetalert2/sweetalert2.min.js"></script>
  <script src="js/sweetalert.js"></script>
  <?php
  if (isset($_SESSION['message'])) {
    ?>
  <script>
  callSuccess();
  </script>
  <?php
  unset($_SESSION['message']);
  }

  if (isset($_SESSION['error'])) {
    ?>
  <script>
  Swal2.fire({
    icon: "error",
    title: "Failed",
  }).then(() => {
    location.replace("<?=$_SESSION['replace_url']?>");
  });
  </script>
  <?php
  unset($_SESSION['error']);
  }

  if (isset($_SESSION['warning'])) {
    ?>
  <script>
  Swal2.fire({
    icon: "warning",
    title: "<?=$_SESSION['warning'];?>",
  }).then(() => {
    location.replace("<?=$_SESSION['replace_url']?>");
  });
  </script>
  <?php
  unset($_SESSION['warning']);
  unset($_SESSION['replace_url']);
  }
  
  // mcq question 
  if (isset($_SESSION['mcq_message'])) {
    ?>
  <script>
  Swal2.fire({
    icon: "success",
    title: "Added Successfully!",
  }).then(() => {
    location.replace("add.php?Questions");
  });
  </script>
  <?php
  unset($_SESSION['mcq_message']);
  }

  // written question
  if (isset($_SESSION['written_message'])) {
    ?>
  <script>
  Swal2.fire({
    icon: "success",
    title: "Added Successfully!",
  }).then(() => {
    location.replace("add.php?Written-Question");
  });
  </script>
  <?php
  unset($_SESSION['written_message']);
  }

  ?>
  <script src="js/script.js"></script>
</body>

</html>