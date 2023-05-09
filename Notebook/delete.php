<?php 
    function println($str="") {
        echo $str."<br>";
    }

    include('menu.php');
    require('db.php');
    $mysqli = connect();
    if(isset($_GET['id'])) {
        if(isset($_GET['del']) && $_GET['del']==1) {
            $del_sql = "DELETE FROM notebook WHERE id=".$_GET['id'];
            $del_res = mysqli_query($mysqli, $del_sql);
            if (mysqli_errno($mysqli)) 
                println("Ошибка запроса: ".mysqli_error($mysqli));
            else {
                println("Запись успешно удалена!");
                echo '<a class="btn btn-primary" href="delete.php" role="button">Назад</a>';
            }
        } else {
            $id_sql = "SELECT * FROM notebook WHERE id=".$_GET['id'];
            $id_res = mysqli_query($mysqli, $id_sql);
            $table = '
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Firstname</th>
                  <th scope="col">Name</th>
                  <th scope="col">Lastname</th>
                  <th scope="col">Gender</th>
                  <th scope="col">Address</th>
                  <th scope="col">Phone</th>
                  <th scope="col">email</th>
                  <th scope="col">date</th>
                  <th scope="col">comment</th>
                </tr>
              </thead>
              <tbody>';
            while($arr = mysqli_fetch_assoc($id_res)) {
                $table .= '<tr>
                <th scope="row">'.$arr['id'].'</th>
                <td>'.$arr['firstname'].'</td>
                <td>'.$arr['name'].'</td>
                <td>'.$arr['lastname'].'</td>
                <td>'.$arr['gender'].'</td>
                <td>'.$arr['address'].'</td>
                <td>'.$arr['phone'].'</td>
                <td>'.$arr['email'].'</td>
                <td>'.$arr['date'].'</td>
                <td>'.$arr['comment'].'</td>
                </tr>'; 
            }
            $table.='</tbody>
            </table>';
            echo $table;
            
            echo '<a class="btn btn-primary" href="delete.php?id='.$_GET['id'].'&del=1" role="button">Удалить</a>';
            echo '<a class="btn btn-primary" href="delete.php" role="button">Назад</a>';
            

        }
    } else {

        // "DELETE FROM notebook VALUE id=
        
        $sql = "SELECT `id`, `firstname`, LEFT(`name`,1) as name, LEFT(lastname,1) as lastname FROM notebook";
        $res = mysqli_query($mysqli, $sql);
        
        while( $arr = mysqli_fetch_assoc($res)) {
            echo '<a href="delete.php?p=delete&id='.$arr['id'].'">'.$arr['firstname'].' '.$arr['name'].'.'.$arr['lastname'].'.'.'</a>'.'<br>';
        }
    }
        include('footer.php')
?>