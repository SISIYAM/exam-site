$(document).ready(function () {
  // POPUP MODAL Code start from here ============================>
  // show student information
  $(".viewStudentInformationBtn").on("click", function () {
    const studentId = $(this).val();
    $.ajax({
      type: "post",
      url: "includes/ajax.php",
      data: {
        id: studentId,
        searchStudentInformation: "searchStudentInformation",
      },
      success: function (response) {
        $("#studentModalContent").html(response);
      },
    });
  });

  // show exam information code
  $(".editExamBtn").on("click", function () {
    const exam_id = $(this).val();
    $.ajax({
      type: "post",
      url: "includes/ajax.php",
      data: {
        id: exam_id,
        searchExamInformation: "searchExamInformation",
      },
      success: function (response) {
        $("#examModalContent").html(response);
      },
    });
  });

  $("#saveExamBtn").on("click", function () {
    const exam_edit_id = $("#exam_edit_id").val();
    const exam_name = $("#examName").val();
    const exam_Date = $("#examDate").val();
    const exam_Start_time = $("#examStartTime").val();
    const exam_End = $("#examEnd").val();
    const exam_End_time = $("#examEndTime").val();
    const mcq_marks = $("#mcq_marks").val();
    const written_marks = $("#written_marks").val();
    const exam_duration = $("#exam_duration").val();
    const exam_type = $("#examType").val();

    $.ajax({
      type: "post",
      url: "includes/ajax.php",
      data: {
        id: exam_edit_id,
        exam_name: exam_name,
        exam_date: exam_Date,
        exam_start_time: exam_Start_time,
        exam_end: exam_End,
        exam_end_time: exam_End_time,
        mcq_marks: mcq_marks,
        written_marks: written_marks,
        duration: exam_duration,
        updateExam: "updateExam",
      },
      success: function (response) {
        if (response == 200) {
          Swal2.fire({
            icon: "success",
            title: "Updated",
          }).then(() => {
            location.reload();
          });
        } else {
          callError();
        }
      },
    });
  });

  // Active deActive code start from here===============================>

  // deactivate teachers
  $(".teacherDeactivateBtn").on("click", function () {
    const id = $(this).val();
    Swal.fire({
      title: "Are you sure?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirm",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "includes/ajax.php",
          data: {
            id: id,
            deactivateTeacherBtn: "deactivateTeacherBtn",
          },
          success: function (response) {
            if (response == 200) {
              Swal2.fire({
                icon: "success",
                title: "Success",
              }).then(() => {
                location.reload();
              });
            } else {
              callError();
            }
          },
        });
      }
    });
  });

  // activate teachers
  $(".teacherActivateBtn").on("click", function () {
    const id = $(this).val();
    Swal.fire({
      title: "Are you sure?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirm",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "includes/ajax.php",
          data: {
            id: id,
            activateTeacherBtn: "activateTeacherBtn",
          },
          success: function (response) {
            if (response == 200) {
              Swal2.fire({
                icon: "success",
                title: "Success",
              }).then(() => {
                location.reload();
              });
            } else {
              callError();
            }
          },
        });
      }
    });
  });

  // publish exam
  $(".publishExamBtn").on("click", function () {
    const id = $(this).val();
    Swal.fire({
      title: "Are you sure want to publish it?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirm",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "includes/ajax.php",
          data: {
            id: id,
            publishExamBtn: "publishExamBtn",
          },
          success: function (response) {
            if (response == 200) {
              Swal2.fire({
                icon: "success",
                title: "Success",
              }).then(() => {
                location.reload();
              });
            } else {
              callError();
            }
          },
        });
      }
    });
  });

  // unPublish exam
  $(".unPublishExamBtn").on("click", function () {
    const id = $(this).val();
    Swal.fire({
      title: "Are you sure want to Unpublish it?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirm",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "includes/ajax.php",
          data: {
            id: id,
            UnpublishExamBtn: "UnpublishExamBtn",
          },
          success: function (response) {
            if (response == 200) {
              Swal2.fire({
                icon: "success",
                title: "Success",
              }).then(() => {
                location.reload();
              });
            } else {
              callError();
            }
          },
        });
      }
    });
  });

  // DELETE CODE START FROM HERE====================================>

  // delete teacher
  $(".deleteTeacher").on("click", function () {
    const id = $(this).val();
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "includes/delete.php",
          data: {
            id: id,
            deleteTeacherBtn: "deleteTeacherBtn",
          },
          success: function (deleteTeacherResponse) {
            if (deleteTeacherResponse == 200) {
              callDeleteSuccess();
            } else {
              callError();
            }
          },
        });
      }
    });
  });

  // delete student
  $(".deleteStudentBtn").on("click", function () {
    const studentID = $(this).val();
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "includes/delete.php",
          data: {
            id: studentID,
            deleteStudentBtn: "deleteStudentBtn",
          },
          success: function (deleteStudentsResponse) {
            if (deleteStudentsResponse == 200) {
              callDeleteSuccess();
            } else {
              callError();
            }
          },
        });
      }
    });
  });

  // delete exam
  $(".deleteExamBtn").on("click", function () {
    const examID = $(this).val();
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "includes/delete.php",
          data: {
            id: examID,
            deleteExamBtn: "deleteExamBtn",
          },
          success: function (deleteExamsResponse) {
            if (deleteExamsResponse == 200) {
              callDeleteSuccess();
            } else {
              callError();
            }
          },
        });
      }
    });
  });

  // delete question
  $(".deleteQuestionBtn").on("click", function () {
    const questionID = $(this).val();
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "includes/delete.php",
          data: {
            id: questionID,
            deleteQuestionBtn: "deleteQuestionBtn",
          },
          success: function (deleteQuestionsResponse) {
            if (deleteQuestionsResponse == 200) {
              callDeleteSuccess();
            } else {
              callError();
            }
          },
        });
      }
    });
  });

  // end function
});
