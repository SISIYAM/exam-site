<?php
// Register New Admin
if(isset($_POST['registerAdminBtn'])){
  $full_name = mysqli_real_escape_string($con, $_POST['full_name']) ;
  $username = mysqli_real_escape_string($con, $_POST['username']) ;
  $email = mysqli_real_escape_string($con, $_POST['email']) ;
  $password = mysqli_real_escape_string($con, $_POST['password']) ;
  $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']) ;

  $pass = password_hash($password,  PASSWORD_BCRYPT);
  $cpass = password_hash($confirm_password, PASSWORD_BCRYPT);

    $user_count = "select * from admin where username= '$username' ";
    $userQuery = mysqli_query($con,$user_count);
    $userCount = mysqli_num_rows($userQuery);

    if($userCount > 0){
     $_SESSION['errorMsg'] = "This Username Already Exists, Please Use Another Username";
    }else{
      $emailQuery = " select * from admin where email= '$email'";
      $query = mysqli_query($con,$emailQuery);

      $emailCount = mysqli_num_rows($query);

    if($emailCount > 0){
     $_SESSION['errorMsg'] = "This Email Already Exists, Please Use Another Email";
    }else{
      if($password === $confirm_password){

          $insertQuery = "INSERT INTO `admin` ( `full_name`, `username`, `email`, `password`, `confirm_password`)
          VALUES ( '$full_name', '$username', '$email', '$pass', '$cpass')";

            $iQuery = mysqli_query($con, $insertQuery);

          if($iQuery){
            $_SESSION['msg'] = "Congratulations ".$username."! Your account created successfully";
          }else{
            $_SESSION['errorMsg'] = "Registration Failed";    
          }

      }else{

        $_SESSION['errorMsg'] = "Password and confirm password do not match";

          }
    }
  }
}

// admin login
if(isset($_POST['adminLoginBtn'])){
  $username = $_POST['username'];
  $password = $_POST['password'];

    $username_search = " select * from admin where username='$username'";
    $query = mysqli_query($con,$username_search);

    $username_count = mysqli_num_rows($query);

    if($username_count){
        $username_pass = mysqli_fetch_assoc($query);

        $db_pass = $username_pass['password'];

        $_SESSION['username'] = $username_pass['username'];
        $_SESSION['email'] = $username_pass['email'];
        $_SESSION['id'] = $username_pass['id'];
        $_SESSION['post'] = $username_pass['post'];
        
        $pass_decode = password_verify($password, $db_pass);

        if($pass_decode){
          ?>
<script>
location.replace("index.php");
</script>
<?php
         }else{
          $_SESSION['errorMsg'] = "Incorrect Password";
         }

     }else{
      $_SESSION['errorMsg'] = "Invalid Username";
     }

}

// add exam
if (isset($_POST['submitExamBtn'])) {
  $ChangeExam_name = $_POST['exam_name'];
  $exam_name = str_replace("'","\'", $ChangeExam_name);
  $exam_id = uniqid();
  $duration = (($_POST['duration_hour'] * 3600) + ($_POST['duration_minute'] * 60) + ($_POST['duration_seconds']));
  $exam_start = $_POST['start_date'];
  $exam_start_time = $_POST['start_time'];
  $exam_end = $_POST['end_date'];
  $exam_end_time = $_POST['end_time'];
  $mcq_marks = $_POST['mcq_marks'];
  $written_marks = $_POST['written_marks'];
  $added_by = $_SESSION['username'];
  
    $sql = "INSERT INTO `exam`(`exam_name`, `exam_id`, `duration`, `exam_start`, `exam_start_time`, `exam_end`,`exam_end_time`,`mcq_marks`, `written_marks`,`added_by`) 
    VALUES ('$exam_name','$exam_id','$duration','$exam_start','$exam_start_time','$exam_end','$exam_end_time','$mcq_marks','$written_marks','$added_by')";
    $query = mysqli_query($con, $sql);
  
    if ($query) {
      $_SESSION['message'] = "Success";
      ?>
<script>
location.replace("list.php?Exam");
</script>
<?php
    } else {
      $_SESSION['error'] = "Failed";
      ?>
<script>
location.replace("list.php?Exam");
</script>
<?php
  
    }
}

// Add MCQ Question
if (isset($_POST['addQuestion'])) {
  $exam_id = $_POST['exam_id'];
  $marks = $_POST['marks'];
  $question_type= 1;
  $negative_marks = $_POST['negative_marks'];
  $changeQuestion = $_POST['question'];
  $question = str_replace("'","\'", $changeQuestion);
  $changeOption_1 = $_POST['option_1'];
  $option_1 = str_replace("'","\'", $changeOption_1);
  $changeOption_2 = $_POST['option_2'];
  $option_2 = str_replace("'","\'", $changeOption_2);
  $changeOption_3 = $_POST['option_3'];
  $option_3 = str_replace("'","\'", $changeOption_3);
  $changeOption_4 = $_POST['option_4'];
  $option_4 = str_replace("'","\'", $changeOption_4);
  $changeSolution = $_POST['solution'];
  $solution = str_replace("'","\'", $changeSolution);
  $answer = $_POST['answer'];
  $added_by = $_SESSION['username'];
  
    $sql = "INSERT INTO `questions`(`exam_id`, `question_type`,`question`, `option_1`, `option_2`, `option_3`, `option_4`, `answer`, `mark`, `negative_mark`,`solution`,`added_by`)
    VALUES ('$exam_id','$question_type','$question','$option_1','$option_2','$option_3','$option_4','$answer','$marks','$negative_marks','$solution','$added_by')";
    $query = mysqli_query($con, $sql);
  
    if ($query) {
      $_SESSION['mcq_message'] = "Success";
      ?>
<script>
location.replace("list.php?Questions");
</script>
<?php
    } else {
      $_SESSION['error'] = "Failed";
      $_SESSION['replace_url'] = "add.php?Questions";
      ?>
<script>
location.replace("list.php?Questions");
</script>
<?php
  
    }
}

// add Written Question
if(isset($_POST['addWrittenQuestion'])){
  $exam_id = $_POST['exam_id'];
  $marks = $_POST['marks'];
  $changeQuestion = $_POST['question'];
  $question = str_replace("'","\'", $changeQuestion);
  $changeSolution = $_POST['solution'];
  $solution = str_replace("'","\'", $changeSolution);
  $added_by = $_SESSION['username'];
  
    $sql = "INSERT INTO `written_questions`(`exam_id`,`question`, `mark`,`solution`,`added_by`)
    VALUES ('$exam_id','$question','$marks','$solution','$added_by')";
    $query = mysqli_query($con, $sql);
  
    if ($query) {
      $_SESSION['written_message'] = "Success";
      ?>
<script>
location.replace("list.php?Questions");
</script>
<?php
    } else {
      $_SESSION['error'] = "Failed";
      $_SESSION['replace_url'] = "add.php?Written-Question";
      ?>
<script>
location.replace("list.php?Questions");
</script>
<?php
  
    }
}
// deactivate teachers
if(isset($_POST['teacherDeactivateBtn'])){
  $id = $_POST['id'];

  $query = mysqli_query($con, "UPDATE admin SET status='1' WHERE id='$id'");
  if($query){
    ?>
<script>
location.replace("list.php?Teachers");
</script>
<?php
  }else{
    ?>
<script>
alert("Failed");
</script>
<?php
  }
}

// activate teacher
if(isset($_POST['teacherActivateBtn'])){
  $id = $_POST['id'];

  $query = mysqli_query($con, "UPDATE admin SET status='0' WHERE id='$id'");
  if($query){
    ?>
<script>
location.replace("list.php?Teachers");
</script>
<?php
  }else{
    ?>
<script>
alert("Failed");
</script>
<?php
  }
}


// update question
// Add Question
if (isset($_POST['updateQuestion'])) {
  $questionID = $_POST['questionID'];
  $exam_id = $_POST['exam_id'];
  $marks = $_POST['marks'];
  $negative_marks = $_POST['negative_marks'];
  $changeQuestion = $_POST['question'];
  $question = str_replace("'","\'", $changeQuestion);
  $changeOption_1 = $_POST['option_1'];
  $option_1 = str_replace("'","\'", $changeOption_1);
  $changeOption_2 = $_POST['option_2'];
  $option_2 = str_replace("'","\'", $changeOption_2);
  $changeOption_3 = $_POST['option_3'];
  $option_3 = str_replace("'","\'", $changeOption_3);
  $changeOption_4 = $_POST['option_4'];
  $option_4 = str_replace("'","\'", $changeOption_4);
  $changeSolution = $_POST['solution'];
  $solution = str_replace("'","\'", $changeSolution);
  $answer = $_POST['answer'];
  
    $sql = "UPDATE questions SET `exam_id`='$exam_id', `question`='$question', `option_1`='$option_1', `option_2`='$option_2', `option_3`='$option_3', `option_4`='$option_4', `answer`='$answer', `mark`='$marks', `negative_mark`='$negative_marks',`solution`='$solution' WHERE id='$questionID'";
    $query = mysqli_query($con, $sql);
  
    if ($query) {
      $_SESSION['message'] = "Success";
      ?>
<script>
location.replace("list.php?Questions");
</script>
<?php
    } else {
      $_SESSION['error'] = "Failed";
      ?>
<script>
location.replace("list.php?Questions");
</script>
<?php
  
    }
}

// submit evaluated image
if(isset($_POST['submitBtn'])){
  $upload_dir = "../img/writtenAnswer/";
  $img = $_POST['saveImage'];
  $studentID = $_POST['studentID'];
  $examID = $_POST['examID'];
  $record_id = $_POST['record_id'];
  $mark = $_POST['mark'];
  $question_id = $_POST['questionID'];
  $result = "";

  $userId= $_SESSION['id'];

  $searchRecord = mysqli_query($con,"SELECT * FROM written_record WHERE id='$record_id'");
  if(mysqli_num_rows($searchRecord) > 0){
    $defaultPath = mysqli_fetch_array($searchRecord)['answered_image'];
  }

  $img = str_replace('data:image/png;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $data = base64_decode($img);
  $file = $upload_dir . $defaultPath;
  $success = file_put_contents($file, $data);
  if($success){
    $oldResult = mysqli_query($con, "SELECT * FROM result WHERE student_id='$studentID' AND exam_id='$examID'");
    if(mysqli_num_rows($oldResult) > 0){
      $oldRow = mysqli_fetch_array($oldResult);
      $result = $oldRow['result'] + $mark;
    }
    $updateResult = mysqli_query($con,"UPDATE result SET result='$result' WHERE student_id='$studentID' AND exam_id='$examID'");
    if($updateResult){
      $updateEvaluationStatus= mysqli_query($con, "UPDATE written_record SET mark='$mark', evaluation_status=1, evaluated_by='$userId' WHERE id='$record_id'");
      ?>
<script>
Swal.fire({
  title: "Submit Successfully",
  icon: "success"
}).then(() => {
  location.replace("scripts.php?Exam-ID=<?=$examID?>");
});
</script>
<?php
    }else{
      ?>
<script>
Swal.fire({
  title: "Failed",
  icon: "error"
}).then(() => {
  location.replace("evaluate.php?Evaluate=<?=$record_id?>");
});
</script>
<?php
    }
  }
  }

?>