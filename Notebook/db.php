<?php
    function connect() {
        $mysqli = mysqli_connect("localhost", 'root', '', 'friends');
        // Проверка оединения 0 - успшешно
        if(mysqli_errno($mysqli)) 
            println("Ошибка запроса".mysqli_error($mysqli));
            
        return $mysqli;
    }
?>