let imageSource = $("#imgSRC").val();
const canvas = new fabric.Canvas("canvas", {
  isDrawingMode: false,
});

canvas.setBackgroundImage(imageSource, function () {
  let img = canvas.backgroundImage;
  img.originX = "left";
  img.originY = "top";
  img.scaleX = canvas.getWidth() / img.width;
  img.scaleY = canvas.getHeight() / img.height;
  canvas.renderAll();
});

canvas.freeDrawingBrush.color = "red";
canvas.freeDrawingBrush.width = 2;

$("#draw").on("click", function () {
  canvas.isDrawingMode = !canvas.isDrawingMode;
});

$("#remove").on("click", function () {
  canvas.isDrawingMode = false;
  canvas.remove(canvas.getActiveObject());
  location.reload();
});

$("#tosvg").on("click", function () {
  //  $("#svg").html("<h1>SVG:</h1><br>" + canvas.toSVG());
  const link = canvas.toDataURL("image/png");
  $("#saveImage").val(link);
  $("#submitEvaluationBtn").click();
  console.log(link);
});
