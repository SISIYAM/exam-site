// Code for select payment method
$("#paymentMethodSelect").change(function (e) {
  let examType = $(this).val();
  if (examType == 1) {
    jQuery("#nagad_paymentModal").hide(100);
    // add disabled attribute to nagad input field
    $("#Nagad_mobile").attr("disabled", "disabled");
    $("#Nagad_Transaction").attr("disabled", "disabled");
    // remove disabled attribute from bKash input field when bkash selected
    $("#bKash_mobile").removeAttr("disabled");
    $("#bKash_Transaction").removeAttr("disabled");
    // bKash payment modal show
    jQuery("#bkash_paymentModal").show(700);
  }
  if (examType == 0) {
    jQuery("#bkash_paymentModal").hide(100);
    // add disabled attribute to bkash input field
    $("#bKash_mobile").attr("disabled", "disabled");
    $("#bKash_Transaction").attr("disabled", "disabled");
    // remove disabled attribute from nagad input field when nagad selected
    $("#Nagad_mobile").removeAttr("disabled");
    $("#Nagad_Transaction").removeAttr("disabled");
    // nagad payment modal show
    jQuery("#nagad_paymentModal").show(700);
  }
  if (examType == "COD") {
    $("#Nagad_mobile").attr("disabled", "disabled");
    $("#Nagad_Transaction").attr("disabled", "disabled");
    jQuery("#bkash_paymentModal").hide(700);
    jQuery("#nagad_paymentModal").hide(700);
  }
});
