<?php 
session_start();
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
  <link href="img/logo/logo.png" rel="icon">
  <title>Admin - Login</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">

                <?php
              if(isset($_GET['login'])){
                ?>
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Admin Login</h1>
                    <?php
                    if(isset($_SESSION['errorMsg'])){
                      ?>
                    <p class="alert alert-danger"><?=$_SESSION['errorMsg']?></p>
                    <?php
                    unset($_SESSION['errorMsg']);
                    }
                    ?>
                  </div>
                  <form action="" class="user" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Enter username" name="username">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>

                    <div class="form-group">
                      <button type="submit" name="adminLoginBtn" class="btn btn-primary btn-block">Login</button>
                    </div>

                    <div class="text-center">
                    </div>
                </div>
                <?php
              }elseif (isset($_GET['register'])) {
                ?>
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Register</h1>
                    <?php 
                    if(isset($_SESSION['msg'])){
                      ?>
                    <p class="alert alert-success"><?=$_SESSION['msg']?></p>
                    <?php
                    unset($_SESSION['msg']);
                    }

                    if(isset($_SESSION['errorMsg'])){
                      ?>
                    <p class="alert alert-danger"><?=$_SESSION['errorMsg']?></p>
                    <?php
                    unset($_SESSION['errorMsg']);
                    }
                    
                    ?>

                  </div>
                  <form action="" method="post">
                    <div class="form-group">
                      <label>Full Name</label>
                      <input type="text" class="form-control" id="exampleInputFirstName" name="full_name"
                        placeholder="Enter Full Name" required>
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" name="username" id="exampleInputLastName"
                        placeholder="Enter Unique Username" required>
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email" id="exampleInputEmail"
                        aria-describedby="emailHelp" placeholder="Enter Email Address" required>
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control" name="password" id="exampleInputPassword"
                        placeholder="Password" required>
                    </div>
                    <div class="form-group">
                      <label>Confirm Password</label>
                      <input type="password" class="form-control" name="confirm_password"
                        id="exampleInputPasswordConfirm" placeholder="Confirm Password" required>
                    </div>
                    <div class="form-group">
                      <button type="submit" name="registerAdminBtn" class="btn btn-primary btn-block">Register</button>
                    </div>
                  </form>
                </div>
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
  <!-- Login Content -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
</body>

</html>