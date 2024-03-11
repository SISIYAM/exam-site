<?php 

session_start();
include './dbcon.php';
 
if(session_destroy()){
  ?>
<script>
location.replace("../login.php?login");
</script>
<?php 
}
?>