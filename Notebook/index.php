<?php
  function println($str="") {
    echo $str."<br>";
  }

  // что-то
  
  require('menu.php');
  require('db.php');
  $mysqli = connect();
  // if(isset($_GET['p']) && $_GET['p'] == 'view') {
    echo '<div id = "submenu" class="submenu">';
      echo '<a class="select"
      href = "index.php?sort=byid">По умолчанию</a>';
      echo '<a class="select"
      href = "index.php?sort=byfirstname">По фамилии</a>';
      echo "</div>";
  // }
  if(isset($_POST['firstname'])) {
    // echo $_POST['date'];
    $sql_insert = "INSERT INTO `notebook` (`firstname`, `name`, `lastname`, `gender`, `address`, `phone`, `email`, `date`, `comment`) 
    VALUES 
    ('".htmlspecialchars($_POST['firstname'])."',
    '".htmlspecialchars($_POST['name'])."',
    '".htmlspecialchars($_POST['lastname'])."',
    '".htmlspecialchars($_POST['gender'])."',
    '".htmlspecialchars($_POST['address'])."',
    '".htmlspecialchars($_POST['phone'])."',
    '".htmlspecialchars($_POST['email'])."',
    '".htmlspecialchars($_POST['date'])."',
    '".htmlspecialchars($_POST['comment'])."')";
    echo mysqli_query($mysqli, $sql_insert);
    if(mysqli_errno($mysqli)) echo println("Ошибка запроса: ".mysqli_error($mysqli));
  }

  $sql_count = "SELECT COUNT(*) FROM notebook";
  $res_count = mysqli_query($mysqli, $sql_count);
  $count_rows = mysqli_fetch_row($res_count)[0];
  $rows_per_page = 4;
  $count_pages = $count_rows/$rows_per_page;

  if(!isset($_GET['page'])) {
    $_GET['page']=0;
  }

  $first_p = $_GET['page'] * $rows_per_page;
  // sort
  if(isset($_GET['sort'])) {
    if($_GET['sort'] == 'byid') {
      $sql = "SELECT * FROM `notebook` ORDER BY id LIMIT ".$first_p.", ".$rows_per_page;
    } else
    if($_GET['sort'] == 'byfirstname') {
      $sql = "SELECT * FROM `notebook` ORDER BY firstname LIMIT ".$first_p.", ".$rows_per_page;
    } else {
      $sql = "SELECT * FROM `notebook` LIMIT ".$first_p.", ".$rows_per_page;  
    }
  } else {
    $sql = "SELECT * FROM `notebook` LIMIT ".$first_p.", ".$rows_per_page;
  } 
  // echo $sql;
  $res = mysqli_query($mysqli, $sql);
  if (mysqli_errno($mysqli)) 
    println("Ошибка запроса: ".mysqli_error($mysqli));
  
    // println('Всего записей:');
    // print_r(mysqli_num_rows($res));
    // println();
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
      <tbody>
      ';
  while($arr = mysqli_fetch_assoc($res)) {
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
  println($table);
  // print_r(mysqli_num_rows($res));
  // println();
  // // Массив с ключами - числами
  // // print_r(mysqli_fetch_row($res));
  // // println();
  // // Массив с ключами - именами полей: id, name, firstname, address, phone, 
  // print_r(mysqli_fetch_assoc($res));
  for($i=0;$i<$count_pages;$i++) {
    if(!isset($_GET['sort']))
    echo '<a href=index.php?page='.$i.'>'.($i+1).' </a>';
    else echo '<a href=index.php?sort='.$_GET['sort'].'&page='.$i.'>'.($i+1).' </a>';
  }
  include('footer.php');
?>