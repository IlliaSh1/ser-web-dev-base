<?php
  include("templates/menu.php");

  require('db.php');
  $mysqli = connect();
?>

<?php 
  echo '<section class="section"><div class="section__container">';
  if(isset($_POST['logout'])) {      
    $_SESSION['user_id'] = null;
    $_SESSION['user_name'] = null;
    $_SESSION['user_email'] = null;
    echo "<p class='txt--md'>You successfully logged out".$_SESSION['user_name']."!</p>";
  } else {
    if(isset($_SESSION['user_id'])) {
        echo "<p class='txt--md'> Welcome ".$_SESSION['user_name']."!</p>";
        echo '<form action="profile.php" method="post">';
        echo '<input class="hidden" name="logout" value="true" hidden>';
        echo '<button class="btn btn--theme_add_dark">Log Out</button>';
        echo '</form>';
    } else {
        echo "<p class='txt--md'>You need to login first"."!</p>";
    }
  }
  echo '</div></section>';
?>

<?php 
  include("templates/footer.html");
?>

<!--  -->
