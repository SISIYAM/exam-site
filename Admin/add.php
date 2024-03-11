<?php
   include './includes/login_required.php';
   include 'includes/dbcon.php';
   include 'includes/code.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'includes/head.php'; ?>
</head>

<body>
  <?php include 'includes/nav.php'; ?>
  <div id="main">
    <header class="mb-3">
      <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
      </a>
    </header>

    <?php
    if (isset($_GET['Exam'])) {
      ?>
    <div class="page-heading">

      <!-- Basic Vertical form layout section start -->
      <section id="basic-vertical-layouts">
        <div class="row match-height">
          <div class="">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Add Exam</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <form action="" method="post" enctype="multipart/form-data" class="form form-vertical">
                    <div class="form-body">
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            <label for="first-name-vertical">Exam Name <span>*</span></label>
                            <input type="text" id="first-name-vertical" class="form-control" name="exam_name"
                              placeholder="Exam Name" required>
                          </div>
                        </div>

                        <div class="col-12">
                          <label for="short-description-id-vertical">Duration*</label>
                          <div class="d-flex my-2">
                            <div class="col-1">
                              <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                name="duration_hour" required>
                                <option value="">Hours</option>
                                <?php
                              for ($i=0; $i <= 12; $i++) { 
                                ?>
                                <option value="<?=$i;?>"><?=$i;?></option>
                                <?php
                              }
                              ?>

                              </select> <br>
                            </div>
                            <div class="col-1 mx-2">
                              <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                name="duration_minute" required>
                                <option value="">Minutes</option>
                                <?php
                              for ($i=0; $i <= 59; $i++) { 
                                ?>
                                <option value="<?=$i;?>"><?=$i;?></option>
                                <?php
                              }
                              ?>

                              </select> <br>

                            </div>
                            <div class="col-1 mx-2">
                              <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                name="duration_seconds" required>
                                <option value="">Seconds</option>
                                <?php
                              for ($i=0; $i <= 59; $i++) { 
                                ?>
                                <option value="<?=$i;?>"><?=$i;?></option>
                                <?php
                              }
                              ?>

                              </select> <br>

                            </div>
                          </div>
                          <label for="first-name-vertical">Exam Start Date And Time <span>*</span></label>
                          <div style="display:flex" class="my-1">

                            <div class="col-2">
                              <div class="form-group">
                                <label for="first-name-vertical">Date <span>*</span></label>
                                <input type="date" id="first-name-vertical" class="form-control" name="start_date"
                                  placeholder="Exam Name" required>
                              </div>
                            </div>

                            <div class="mx-2 col-2">
                              <div class="form-group">
                                <label for="first-name-vertical">Time <span>*</span></label>
                                <input type="time" id="first-name-vertical" class="form-control" name="start_time"
                                  placeholder="Exam Name" required>
                              </div>
                            </div>



                          </div>

                          <label for="first-name-vertical">Exam End Date And Time <span>*</span></label>
                          <div style="display:flex" class="my-1">
                            <div class="col-2">
                              <div class="form-group">
                                <label for="first-name-vertical">Date <span>*</span></label>
                                <input type="date" id="first-name-vertical" class="form-control" name="end_date"
                                  placeholder="Exam Name" required>
                              </div>
                            </div>

                            <div class="mx-2 col-2">
                              <div class="form-group">
                                <label for="first-name-vertical">Time <span>*</span></label>
                                <input type="time" id="first-name-vertical" class="form-control" name="end_time"
                                  placeholder="Exam Name" required>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="first-name-vertical">MCQ Marks <span>*</span></label>
                            <input type="text" id="first-name-vertical" class="form-control" name="mcq_marks"
                              placeholder="MCQ Marks" required>
                          </div>
                          <div class="form-group">
                            <label for="first-name-vertical">Written Marks <span>*</span></label>
                            <input type="text" id="first-name-vertical" class="form-control" name="written_marks"
                              placeholder="Written Marks" required>
                          </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                          <button type="submit" name="submitExamBtn" class="btn btn-primary me-1 mb-1">Submit</button>
                          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
    </div>
    <?php
    }elseif (isset($_GET['Questions'])) {
      ?>
    <div class="page-heading">

      <!-- Basic Vertical form layout section start -->
      <section id="basic-vertical-layouts">
        <div class="row match-height">
          <div class="">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Add Questions</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <a href="add.php?Written-Question">
                    <button class="btn btn-primary btn-lg mb-3">Add Written Question</button>
                  </a>
                  <form class="form form-vertical" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-body">
                      <div class="row">

                        <div class="form-group col-12">
                          <label for="">Exam*</label>
                          <select class="form-select" aria-label=".form-select-sm example" name="exam_id">
                            <option value="">Select Exam</option>
                            <?php
                              $select = mysqli_query($con, "SELECT * FROM exam");
                              if(mysqli_num_rows($select) > 0){
                                while($row = mysqli_fetch_array($select)){
                                  ?>
                            <option value="<?=$row['exam_id']?>"><?=$row['exam_name']?></option>
                            <?php
                                }
                              }
                              ?>

                          </select>

                        </div>
                        <div class="form-group">
                          <label for="first-name-vertical">Marks <span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="marks"
                            placeholder="Ex: 1" required>
                        </div>

                        <div class="form-group">
                          <label for="first-name-vertical">Negative Marks <span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="negative_marks"
                            placeholder="Ex: 0.25" required>
                        </div>
                        <div class="col-12">
                          <div class="form-group">
                            <label for="question">Question <span>*</span></label>
                            <!-- Cke question -->
                            <textarea name="question" id="editor"></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="option_1">Option A <span>*</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_1" id="option_1"></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="editor">Option B <span>*</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_2" id="option_2"></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="editor">Option C <span>*</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_3" id="option_3"></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="editor">Option D <span>*</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_4" id="option_4"></textarea>

                          </div>
                        </div>


                        <div class="form-group col-3">
                          <label for="">Correct Answer*</label>
                          <select class="form-select" aria-label=".form-select-sm example" name="answer" required>
                            <option Value="">Select Correct Answer</option>
                            <option value="1">Option A</option>
                            <option value="2">Option B</option>
                            <option value="3">Option C</option>
                            <option value="4">Option D</option>

                          </select>

                        </div>

                        <div class="col-12">
                          <div class="form-group">
                            <label for="question">Solution <span>(Optional)</span></label>
                            <!-- Cke question -->
                            <textarea name="solution" id="solution"></textarea>

                          </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                          <button type="submit" name="addQuestion" class="btn btn-primary me-1 mb-1">Add
                            Question</button>
                          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
    </div>
    <?php
    }elseif (isset($_GET['Written-Question'])) {
      ?>
    <div class="page-heading">

      <!-- Basic Vertical form layout section start -->
      <section id="basic-vertical-layouts">
        <div class="row match-height">
          <div class="">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Add Questions</h4>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <a href="add.php?Questions">
                    <button class="btn btn-success btn-lg mb-3">Add MCQ Question</button>
                  </a>
                  <form class="form form-vertical" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-body">
                      <div class="row">

                        <div class="form-group col-12">
                          <label for="">Exam*</label>
                          <select class="form-select" aria-label=".form-select-sm example" name="exam_id">
                            <option value="">Select Exam</option>
                            <?php
                              $select = mysqli_query($con, "SELECT * FROM exam");
                              if(mysqli_num_rows($select) > 0){
                                while($row = mysqli_fetch_array($select)){
                                  ?>
                            <option value="<?=$row['exam_id']?>"><?=$row['exam_name']?></option>
                            <?php
                                }
                              }
                              ?>

                          </select>

                        </div>
                        <div class="form-group">
                          <label for="first-name-vertical">Marks <span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="marks"
                            placeholder="Ex: 1" required>
                        </div>

                        <div class="col-12">
                          <div class="form-group">
                            <label for="question">Question <span>*</span></label>
                            <!-- Cke question -->
                            <textarea name="question" id="editor"></textarea>

                          </div>
                        </div>


                        <div class="col-12">
                          <div class="form-group">
                            <label for="question">Solution <span>(Optional)</span></label>
                            <!-- Cke question -->
                            <textarea name="solution" id="solution"></textarea>

                          </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                          <button type="submit" name="addWrittenQuestion" class="btn btn-primary me-1 mb-1">Add
                            Question</button>
                          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
    </div>
    <?php
    }elseif(isset($_GET['Update-Questions'])){
      $question_id = $_GET['Update-Questions'];
      ?>
    <div class="page-heading">

      <!-- Basic Vertical form layout section start -->
      <section id="basic-vertical-layouts">
        <div class="row match-height">
          <div class="">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Update Questions</h4>
              </div>
              <?php  
              $search = mysqli_query($con,"SELECT * FROM questions WHERE id='$question_id'");
              if(mysqli_num_rows($search) > 0){
                $result=mysqli_fetch_array($search);
                $question_exam_id = $result['exam_id'];
                
                ?>
              <div class="card-content">
                <div class="card-body">
                  <form class="form form-vertical" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-body">
                      <div class="row">
                        <input type="hidden" value="<?=$question_id?>" name="questionID">
                        <div class="form-group col-12">
                          <label for="">Exam*</label>
                          <select class="form-select" aria-label=".form-select-sm example" name="exam_id">
                            <?php 
                             $searchExamName = mysqli_query($con,"SELECT * FROM exam WHERE exam_id='$question_exam_id'");
                             if(mysqli_num_rows($searchExamName) > 0){
                              $examNameResult = mysqli_fetch_array($searchExamName);
                              ?>
                            <option value="<?=$examNameResult['exam_id'];?>" selected>
                              <?=$examNameResult['exam_name'];?></option>
                            <?php
                             }
                            ?>

                            <?php
                        $select = mysqli_query($con, "SELECT * FROM exam");
                        if(mysqli_num_rows($select) > 0){
                          while($row = mysqli_fetch_array($select)){
                            ?>
                            <option value="<?=$row['exam_id']?>"><?=$row['exam_name']?></option>
                            <?php
                          }
                        }
                        ?>

                          </select>

                        </div>
                        <div class="form-group">
                          <label for="first-name-vertical">Marks <span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="marks"
                            placeholder="Ex: 1" value="<?=$result['mark']?>" required>
                        </div>

                        <div class="form-group">
                          <label for="first-name-vertical">Negative Marks <span>*</span></label>
                          <input type="text" id="first-name-vertical" class="form-control" name="negative_marks"
                            placeholder="Ex: 0.25" value="<?=$result['negative_mark']?>" required>
                        </div>
                        <div class="col-12">
                          <div class="form-group">
                            <label for="question">Question <span>*</span></label>
                            <!-- Cke question -->
                            <textarea name="question" id="editor"><?=$result['question']?></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="option_1">Option A <span>*</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_1" id="option_1"><?=$result['option_1']?></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="editor">Option B <span>*</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_2" id="option_2"><?=$result['option_2']?></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="editor">Option C <span>*</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_3" id="option_3"><?=$result['option_3']?></textarea>

                          </div>
                        </div>

                        <div class="col-11 mx-5">
                          <div class="form-group">
                            <label for="editor">Option D <span>*</span></label>
                            <!-- Cke Editor -->
                            <textarea name="option_4" id="option_4"><?=$result['option_4']?></textarea>

                          </div>
                        </div>


                        <div class="form-group col-3">
                          <label for="">Correct Answer*</label>
                          <select class="form-select" aria-label=".form-select-sm example" name="answer" required>
                            <option Value="" disabled>Select Correct Answer</option>
                            <?php
                            if($result['answer'] == 1){
                              ?>
                            <option value="1" selected>Option A</option>
                            <option value="2">Option B</option>
                            <option value="3">Option C</option>
                            <option value="4">Option D</option>
                            <?php
                            }elseif($result['answer'] == 2){
                              ?>
                            <option value="1">Option A</option>
                            <option value="2" selected>Option B</option>
                            <option value="3">Option C</option>
                            <option value="4">Option D</option>
                            <?php
                            }elseif($result['answer'] == 3){
                              ?>
                            <option value="1">Option A</option>
                            <option value="2">Option B</option>
                            <option value="3" selected>Option C</option>
                            <option value="4">Option D</option>
                            <?php
                            }elseif($result['answer'] == 4){
                              ?>
                            <option value="1">Option A</option>
                            <option value="2">Option B</option>
                            <option value="3">Option C</option>
                            <option value="4" selected>Option D</option>
                            <?php
                            }
                            ?>

                          </select>

                        </div>

                        <div class="col-12">
                          <div class="form-group">
                            <label for="question">Solution <span>(Optional)</span></label>
                            <!-- Cke question -->
                            <textarea name="solution" id="solution"><?=$result['solution']?></textarea>

                          </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                          <button type="submit" name="updateQuestion" class="btn btn-primary me-1 mb-1">Update
                            Question</button>
                          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <?php
              }
              ?>

            </div>
          </div>

        </div>
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
  <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/super-build/ckeditor.js"></script>
  <script src="js/ckeEditor.js"></script>
  <script src="js/ckeEditorOption_1.js"></script>
  <script src="js/ckeEditorOption_2.js"></script>
  <script src="js/ckeEditorOption_3.js"></script>
  <script src="js/ckeEditorOption_4.js"></script>
  <script src="js/ckeEditorSolution.js"></script>
  <script src="assets/extensions/sweetalert2/sweetalert2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="js/sweetalert.js"></script>
  <script src="js/script.js"></script>
  <script src="js/custom.js"></script>

</body>

</html>