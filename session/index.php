<?php 
    session_start();
    if(isset($_POST['country'])) {
        $_SESSION['country']=$_POST['country'];
    }
?>
<form action="index.php">
  <input type="text" name="country" placeholder="Ваша страна">
</form>