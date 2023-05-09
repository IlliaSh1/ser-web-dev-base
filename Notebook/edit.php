<?php 
    function println($str="") {
        echo $str."<br>";
    }

    include('menu.php');
    require('db.php');
    $mysqli = connect();
    if(isset($_GET['id'])) {
        if(isset($_POST['edit'])) {
            $del_sql = "UPDATE notebook SET 
            firstname='".htmlspecialchars($_POST['firstname'])."',
            name='".htmlspecialchars($_POST['name'])."',
            lastname='".htmlspecialchars($_POST['lastname'])."',
            gender='".htmlspecialchars($_POST['gender'])."',
            address='".htmlspecialchars($_POST['address'])."',
            phone='".htmlspecialchars($_POST['phone'])."',
            email='".htmlspecialchars($_POST['email'])."',
            date='".htmlspecialchars($_POST['date'])."',
            comment='".htmlspecialchars($_POST['comment'])."'
            WHERE id=".$_GET['id'];

            $del_res = mysqli_query($mysqli, $del_sql);
            if (mysqli_errno($mysqli)) 
                println("Ошибка запроса: ".mysqli_error($mysqli));
            else {
                println("Запись успешно изменена!");
                echo '<a class="btn btn-primary" href="edit.php" role="button">Назад</a>';
            }
        } else {
            $id_sql = "SELECT * FROM notebook WHERE id=".$_GET['id'];
            $id_res = mysqli_query($mysqli, $id_sql);
            
            while($arr = mysqli_fetch_assoc($id_res)) {
                echo '
                <form name="form_add" method="post" action="edit.php?id='.$_GET['id'].'">
                <div class="column">
            <div class="add">
                <label>Фамилия</label> <input type="text" name="firstname" value="'.$arr['firstname'].'" placeholder="Фамилия" >
            </div>
            <div class="add">
                <label>Имя</label> <input type="text" name="name" value="'.$arr['name'].'" placeholder="Имя" >
            </div>
            <div class="add">
                <label>Отчество</label> <input type="text" name="lastname" value="'.$arr['lastname'].'" placeholder="Отчество" >
            </div>
            <div class="add">
                <label>Пол</label> 
                <select name="gender">
                    <option value="'.$arr['gender'].'"></option>
                    <option value="мужской">мужской</option>
                    <option value="женский">женский</option>
                </select>
            </div>
            <div class="add">
                <label>Дата рождения</label> <input type="date" value="'.$arr['date'].'" name="date" >
            </div>
            <div class="add">
                <label>Телефон</label> <input type="text" name="phone" value="'.$arr['phone'].'" placeholder="Телефон" >
            </div>
            <div class="add">
                <label>Адрес</label> <input type="text" name="address" value="'.$arr['address'].'" placeholder="Адрес" > 
            </div>
            <div class="add">
                <label>Email</label> <input type="email" name="email" value="'.$arr['email'].'" placeholder="Email" >
            </div>
            <div class="add">
                <label>Комментарий</label> <textarea name="comment" value="'.$arr['comment'].'" placeholder="Краткий комментарий"></textarea>
            </div>
        
                <button type="submit" name="edit" value="1" class="form-btn">Изменить</button>
        </div>
        </form>';
            }
            
            echo '<a class="btn btn-primary" href="edit.php" role="button">Назад</a>';
        }
    } else {

        // "DELETE FROM notebook VALUE id=
        
        $sql = "SELECT `id`, `firstname`, LEFT(`name`,1) as name, LEFT(lastname,1) as lastname FROM notebook";
        $res = mysqli_query($mysqli, $sql);
        
        while( $arr = mysqli_fetch_assoc($res)) {
            echo '<a href="edit.php?p=edit&id='.$arr['id'].'">'.$arr['firstname'].' '.$arr['name'].'.'.$arr['lastname'].'.'.'</a>'.'<br>';
        }
    }
    include('footer.php')
?>