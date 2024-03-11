<?php
include 'dbcon.php';

// delete teachers
if(isset($_POST['deleteTeacherBtn'])){
  $id = $_POST['id'];

  $delete = mysqli_query($con, "DELETE FROM admin WHERE id='$id'");
  if($delete){
    echo 200;
  }else{
    echo 500;
  }
}

// delete student
if(isset($_POST['deleteStudentBtn'])){
  $id = $_POST['id'];

  $delete = mysqli_query($con, "DELETE FROM students WHERE id='$id'");
  if($delete){
    echo 200;
  }else{
    echo 500;
  }
}

// delete exam
if(isset($_POST['deleteExamBtn'])){
  $id = $_POST['id'];

  $delete = mysqli_query($con, "DELETE FROM exam WHERE id='$id'");
  if($delete){
    echo 200;
  }else{
    echo 500;
  }
}

// delete question
if(isset($_POST['deleteQuestionBtn'])){
  $id = $_POST['id'];
  
  $delete = mysqli_query($con, "DELETE FROM questions WHERE id='$id'");
  if($delete){
    echo 200;
  }else{
    echo 500;
  }
}
?>