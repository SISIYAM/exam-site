<?php 

session_start();
include '../Admin/includes/dbcon.php';
 
if(session_destroy()){
  ?>
<script>
location.replace("../login.php?login");
</script>
<?php 
}
?>