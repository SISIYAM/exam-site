<?php
session_start();
session_regenerate_id();
if(!isset($_SESSION['student_id'])){
?>
<script>
location.replace("login.php?login");
</script>
<?php
}

?>