<?php
// Register New student
if(isset($_POST['registerBtn'])){
  $studentID = rand(10000,99999);
  $full_name = mysqli_real_escape_string($con, $_POST['full_name']) ;
  $username = mysqli_real_escape_string($con, $_POST['username']) ;
  $email = mysqli_real_escape_string($con, $_POST['email']) ;
  $password = mysqli_real_escape_string($con, $_POST['password']) ;
  $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']) ;

  $pass = password_hash($password,  PASSWORD_BCRYPT);
  $cpass = password_hash($confirm_password, PASSWORD_BCRYPT);

    $user_count = "select * from students where username= '$username' ";
    $userQuery = mysqli_query($con,$user_count);
    $userCount = mysqli_num_rows($userQuery);

    if($userCount > 0){
     $_SESSION['errorMsg'] = "This Username Already Exists, Please Use Another Username";
    }else{
      $emailQuery = " select * from students where email= '$email'";
      $query = mysqli_query($con,$emailQuery);

      $emailCount = mysqli_num_rows($query);

    if($emailCount > 0){
     $_SESSION['errorMsg'] = "This Email Already Exists, Please Use Another Email";
    }else{
      if($password === $confirm_password){

          $insertQuery = "INSERT INTO `students` ( `student_id`,`full_name`, `username`, `email`, `password`, `confirm_password`)
          VALUES ('$studentID','$full_name', '$username', '$email', '$pass', '$cpass')";

            $iQuery = mysqli_query($con, $insertQuery);

          if($iQuery){
            $_SESSION['msg'] = "Congratulations ".$username."! Your account created successfully. Now you can log in!";
          }else{
            $_SESSION['errorMsg'] = "Registration Failed";    
          }

      }else{

        $_SESSION['errorMsg'] = "Password and confirm password do not match";

          }
    }
  }
}

// student login
if(isset($_POST['LoginBtn'])){
  $username = $_POST['username'];
  $password = $_POST['password'];

    $username_search = " select * from students where username='$username'";
    $query = mysqli_query($con,$username_search);

    $username_count = mysqli_num_rows($query);

    if($username_count){
        $username_pass = mysqli_fetch_assoc($query);

        $db_pass = $username_pass['password'];
        
        $_SESSION['student_id'] = $username_pass['student_id'];
        
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

// submit and calculate result
if(isset($_POST['submitExam'])){
  $exam_id = $_POST['exam_id'];
  $insertStudentID = $_SESSION['student_id'];
  $right = 0;
  $wrong = 0;
  $noAns = 0;

  $searchExamType = mysqli_query($con,"SELECT * FROM exam WHERE exam_id='$exam_id' AND type=1");
  if(mysqli_num_rows($searchExamType) > 0){

  // check is student submit result before or not
  $checkStudent = mysqli_query($con, "SELECT * FROM result WHERE student_id='$insertStudentID' && exam_id='$exam_id'");
  if(mysqli_num_rows($checkStudent) > 0){

   ?>
<script>
Swal2.fire({
  icon: "error",
  title: "Exam Already Taken!",
}).then(() => {
  location.replace("result.php?Exam-History=<?=$exam_id?>");
});
</script>
<?php
  }else{

    $select = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$exam_id' AND question_type=1");
    if(mysqli_num_rows($select) > 0){
     while($res = mysqli_fetch_array($select)){
      $mark = $res['mark'];
      $negative_mark = $res['negative_mark'];
       if($_POST[$res['id']] == $res['answer']){
         $right++;
       }elseif ($_POST[$res['id']] == 5) {
         $noAns ++;
       }else{
         $wrong++;
       }
       $question_id = $res['id'];
       $answered = $_POST[$res['id']];
       
       $query = mysqli_query($con, "INSERT INTO record (student_id,exam_id,question_id,answered) VALUES ('$insertStudentID','$exam_id','$question_id', '$answered')");
     }
   
          // insert written answer
    $writtenQuestion = mysqli_query($con, "SELECT * FROM written_questions WHERE exam_id='$exam_id'");
    if(mysqli_num_rows($writtenQuestion) > 0){
      while($fetch = mysqli_fetch_array($writtenQuestion)){
        $writtenQuestionId = $fetch['id'];
        $answerImage = $_FILES[$fetch['id']]['name'];
        $extension = pathinfo($answerImage, PATHINFO_EXTENSION);
        $supported_extension = array("jpg","jpeg","png","gif","webp");

        if($answerImage != ""){      
        if(in_array($extension, $supported_extension)){
          $new_name = rand().".".$extension; 
          $image_path = "img/writtenAnswer/" .$new_name;
      
          $sql = mysqli_query($con, "INSERT INTO written_record (`student_id`, `exam_id`, `question_id`, `answered_image`) VALUES ('$insertStudentID','$exam_id','$writtenQuestionId','$new_name')");
          
          if($sql){
            move_uploaded_file($_FILES[$fetch['id']]['tmp_name'],$image_path);
              }
            }else{
              ?>
<script>
Swal2.fire({
  icon: "warning",
  title: "Invalid Extension!",
});
</script>
<?php
            } 
          }
            //
      }
    }
    // insert written end

     $totalAnswered = $wrong + $right;
     $result = ($right * $mark)-($wrong * $negative_mark);
    
     $insertResult = mysqli_query($con, "INSERT INTO result (`student_id`, `exam_id`, `result`, `answered`, `wrong_answered`, `right_answered`, `not_answered`) 
     VALUES ('$insertStudentID','$exam_id','$result','$totalAnswered','$wrong','$right','$noAns')");
    if($insertResult){ 
     ?>
<script>
Swal2.fire({
  icon: "success",
  title: "Submit Successfully!",
}).then(() => {
  location.replace("result.php?Exam-History=<?=$exam_id?>");
});
</script>
<?php
    }else{
     ?>
<script>
alert("Failed to insert Result");
</script>
<?php
    }
   
    }

  }
  
}else{

    $select = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$exam_id'");
    if(mysqli_num_rows($select) > 0){
     while($res = mysqli_fetch_array($select)){
      $mark = $res['mark'];
      $negative_mark = $res['negative_mark'];
       if($_POST[$res['id']] == $res['answer']){
         $right++;
       }elseif ($_POST[$res['id']] == 5) {
         $noAns ++;
       }else{
         $wrong++;
       }
       $question_id = $res['id'];
       $answered = $_POST[$res['id']];
       
       $query = mysqli_query($con, "UPDATE record SET answered='$answered' WHERE student_id='$insertStudentID' AND exam_id='$exam_id' AND question_id='$question_id'");
     }
     
      // insert written answer
    $writtenQuestion = mysqli_query($con, "SELECT * FROM written_questions WHERE exam_id='$exam_id'");
    if(mysqli_num_rows($writtenQuestion) > 0){
      while($fetch = mysqli_fetch_array($writtenQuestion)){
        $writtenQuestionId = $fetch['id'];
        $answerImage = $_FILES[$fetch['id']]['name'];
        $extension = pathinfo($answerImage, PATHINFO_EXTENSION);
        $supported_extension = array("jpg","jpeg","png","gif","webp");

        if($answerImage != ""){    
        if(in_array($extension, $supported_extension)){
          $new_name = rand().".".$extension; 
          $image_path = "img/writtenAnswer/" .$new_name;
      
          $sql = mysqli_query($con, "INSERT INTO written_record (`student_id`, `exam_id`, `question_id`, `answered_image`) VALUES ('$insertStudentID','$exam_id','$writtenQuestionId','$new_name')");
          
          if($sql){
            move_uploaded_file($_FILES[$fetch['id']]['tmp_name'],$image_path);
              }
            }else{
              ?>
<script>
Swal2.fire({
  icon: "warning",
  title: "Invalid Extension!",
});
</script>
<?php
            }
          }
      }
    }
    // insert written end
   
     $totalAnswered = $wrong + $right;
     $result = ($right * $mark)-($wrong * $negative_mark);
    
     
     $insertResult = mysqli_query($con, "UPDATE result SET result='$result',answered='$totalAnswered',wrong_answered='$wrong',right_answered='$right',not_answered='$noAns' WHERE student_id='$insertStudentID' AND exam_id='$exam_id'");

    if($insertResult){ 
     ?>
<script>
Swal2.fire({
  icon: "success",
  title: "Submit Successfully!",
}).then(() => {
  location.replace("result.php?Exam-History=<?=$exam_id?>");
});
</script>
<?php
    }else{
     ?>
<script>
alert("Failed to insert Result");
</script>
<?php
    }
   
    }

  
}


}

// update user information
if(isset($_POST['updateStudentsInformation'])){
  $full_name = mysqli_real_escape_string($con, $_POST['full_name']) ;
  $username = mysqli_real_escape_string($con, $_POST['username']) ;
  $email = mysqli_real_escape_string($con, $_POST['email']) ;
  $mobile = mysqli_real_escape_string($con, $_POST['mobile']) ;
  $institute = mysqli_real_escape_string($con, $_POST['college']) ;
  $hsc = mysqli_real_escape_string($con, $_POST['hsc']) ;

  $sql = mysqli_query($con,"UPDATE students SET full_name='$full_name',email='$email',username='$username',mobile='$mobile',
  college='$institute',hsc='$hsc' WHERE student_id='$student_id'");
  
  if($sql){
    ?>
<script>
Swal2.fire({
  icon: "success",
  title: "Updated!",
}).then(() => {
  location.replace("details.php?Profile");
});
</script>
<?php
  }else{
    ?>
<script>
Swal2.fire({
  icon: "error",
  title: "Failed!",
}).then(() => {
  location.replace("details.php?Profile");
});
</script>
<?php
  }
}

// change password
if(isset($_POST['changePassword'])){
  $old_password = mysqli_real_escape_string($con, $_POST['old_password']);
  $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
  $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

    $new_pass = password_hash($new_password,  PASSWORD_BCRYPT);
    $c_pass = password_hash($confirm_password, PASSWORD_BCRYPT);
    $password_search = "SELECT * FROM students WHERE student_id='$student_id' AND status='1'";
    $query = mysqli_query($con,$password_search);

    $password_count = mysqli_num_rows($query);

  if($new_password != $confirm_password){
    ?>
<script>
Swal2.fire({
  icon: "error",
  title: "Password And Confirm Password didn't matched!",
}).then(() => {
  $("#passwordModal").modal("show");
});
</script>
<?php
  }else{
        $password_pass = mysqli_fetch_assoc($query);
        $db_pass = $password_pass['password'];
        $pass_decode = password_verify($old_password, $db_pass);
        if($pass_decode){
          $change =mysqli_query($con,"UPDATE students SET password = '{$new_pass}',confirm_password = '{$c_pass}' WHERE student_id = {$student_id}");

          if($change){
            ?>
<script>
Swal2.fire({
  icon: "success",
  title: "Password changed Successfully!",
}).then(() => {
  location.replace("details.php?Profile");
});
</script>
<?php
          }else{
            ?>
<script>
Swal2.fire({
  icon: "error",
  title: "Failed!",
}).then(() => {
  $("#passwordModal").modal("show");
});
</script>
<?php
          }
        }else{
          ?>
<script>
Swal2.fire({
  icon: "warning",
  title: "Old Password didn't matched!",
}).then(() => {
  $("#passwordModal").modal("show");
});
</script>
<?php
        }
  }
  
 }
?>