const Swal2 = Swal.mixin({
  customClass: {
    input: "form-control",
  },
});

const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Swal.stopTimer);
    toast.addEventListener("mouseleave", Swal.resumeTimer);
  },
});

// use
function callSuccess() {
  Swal2.fire({
    icon: "success",
    title: "Success",
  });
}

function callError() {
  Swal2.fire({
    icon: "error",
    title: "Failed",
  });
}

// delete success
function callDeleteSuccess() {
  Swal2.fire({
    icon: "error",
    title: "Deleted",
  }).then(() => {
    location.reload();
  });
}
