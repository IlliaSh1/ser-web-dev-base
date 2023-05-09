<?php
    // page 2
    session_start();
    if(isset($_SESSION['country'])) {
        echo "Введённая страна:".$_SESSION['country'];
    } else {
        echo "Вы ешё не ввели страну";
    }

?>