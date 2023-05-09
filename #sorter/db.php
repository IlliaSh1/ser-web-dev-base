<?php
    function connect() {
        $mysqli = mysqli_connect("localhost", 'root', '', 'hashtag_sorter');
        // Проверка оединения 0 - успшешно
        if(mysqli_errno($mysqli)) 
            println("Ошибка запроса".mysqli_error($mysqli));
            
        return $mysqli;
    }
?>