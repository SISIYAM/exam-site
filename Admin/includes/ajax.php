<?php
include 'dbcon.php';

// search student information
if(isset($_POST['searchStudentInformation'])){
  $id = $_POST['id'];
  $output = "";
  $search = mysqli_query($con,"SELECT * FROM students WHERE id ='$id'");
  if(mysqli_num_rows($search) > 0){
     $row = mysqli_fetch_array($search);
     $output = ' 
   <label for="email">Student ID: </label>
     <div class="form-group">
       <input type="text" value="'.$row['student_id'].'" class="form-control" readonly>
     </div>
     <label for="name">Name: </label>
     <div class="form-group">
       <input type="text" value="'.$row['full_name'].'" class="form-control" readonly>
     </div>
     <label for="email">Username: </label>
     <div class="form-group">
       <input type="text" value="'.$row['username'].'" class="form-control" readonly>
     </div>
   <label for="email">Email: </label>
     <div class="form-group">
       <input type="text" value="'.$row['email'].'" class="form-control" readonly>
     </div>
     <label for="email">Mobile: </label>
     <div class="form-group">
       <input type="text" value="'.$row['mobile'].'" class="form-control" readonly>
     </div>
     <label for="email">College: </label>
     <div class="form-group">
       <input type="text" value="'.$row['college'].'" class="form-control" readonly>
     </div>
     <label for="email">HSC: </label>
     <div class="form-group">
       <input type="text" value="'.$row['hsc'].'" class="form-control" readonly>
     </div>
     ';
     echo $output;
  }
  else{
     $output = '<div class="alert alert-danger">No data found.</div>';
     echo $output;
  }
}

// search exam information
if(isset($_POST['searchExamInformation'])){
  $id = $_POST['id'];
  $output = "";
  $search = mysqli_query($con,"SELECT * FROM exam WHERE id ='$id'");
  if(mysqli_num_rows($search) > 0){
     $row = mysqli_fetch_array($search);
     $output = ' 
     <input type="hidden" value="'.$row['id'].'" id="exam_edit_id">
   <label for="email">Exam Name: </label>
     <div class="form-group">
       <input type="text" value="'.$row['exam_name'].'" id="examName" class="form-control">
     </div>
     <label for="name">Exam Start Date: </label>
     <div class="form-group">
       <input type="date" value="'.$row['exam_start'].'" id="examDate" class="form-control">
     </div>
     <label for="name">Exam Start Time: </label>
     <div class="form-group">
       <input type="time" value="'.$row['exam_start_time'].'" id="examStartTime" class="form-control">
     </div>
     <label for="email">Exam End Date: </label>
     <div class="form-group">
       <input type="date" value="'.$row['exam_end'].'" id="examEnd" class="form-control">
     </div>
     <label for="email">Exam End Time: </label>
     <div class="form-group">
       <input type="time" value="'.$row['exam_end_time'].'" id="examEndTime" class="form-control">
     </div>
   <label for="email">MCQ Marks: </label>
     <div class="form-group">
       <input type="text" value="'.$row['mcq_marks'].'" id="mcq_marks" class="form-control">
     </div>
     <label for="email">Written Marks: </label>
     <div class="form-group">
       <input type="text" value="'.$row['written_marks'].'" id="written_marks" class="form-control">
     </div>
     <label for="email">Exam Duration(In Second): </label>
     <div class="form-group">
       <input type="text" value="'.$row['duration'].'" id="exam_duration" class="form-control">
     </div>
     ';
     echo $output;
  }
  else{
     $output = '<div class="alert alert-danger">No data found.</div>';
     echo $output;
  }
}



// active and inactive teachers account code
if(isset($_POST['deactivateTeacherBtn'])){
  $id = $_POST['id'];
  $sql = mysqli_query($con, "UPDATE admin SET status = 0 WHERE id='$id'");
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
}

if(isset($_POST['activateTeacherBtn'])){
  $id = $_POST['id'];
  $sql = mysqli_query($con, "UPDATE admin SET status = 1 WHERE id='$id'");
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
}

// unpublish  and publish exam

if(isset($_POST['UnpublishExamBtn'])){
  $id= $_POST['id'];
  $sql = mysqli_query($con,"UPDATE exam SET status = 0 WHERE id= '$id'");
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
}

if(isset($_POST['publishExamBtn'])){
  $id = $_POST['id'];
  $sql = mysqli_query($con, "UPDATE exam SET status = 1 WHERE id='$id'");
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
}

// update exam 
if(isset($_POST['updateExam'])){
  $exam_id = $_POST['id'];
  $exam_name = $_POST['exam_name'];
  $exam_date = $_POST['exam_date'];
  $exam_start_time = $_POST['exam_start_time'];
  $exam_end = $_POST['exam_end'];
  $exam_end_time = $_POST['exam_end_time'];
  $mcq_marks = $_POST['mcq_marks'];
  $written_marks = $_POST['written_marks'];
  $duration = $_POST['duration'];
  
  $sql = mysqli_query($con, "UPDATE exam SET exam_name='$exam_name', duration='$duration', exam_start='$exam_date', exam_start_time='$exam_start_time', exam_end='$exam_end', exam_end_time='$exam_end_time', mcq_marks='$mcq_marks',written_marks='$written_marks' WHERE id='$exam_id'");
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
}


?>