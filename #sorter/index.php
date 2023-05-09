<?php
  include("templates/menu.php");

  require('db.php');
  $mysqli = connect();
?>

<?php


// GET SMSS
  $sql_get_smss = "SELECT * FROM smss WHERE flag_save=0 OR (flag_save=1 AND user_id ='".htmlspecialchars($_SESSION['user_id'])."')";

  if(isset($_GET['knowledge_id'])) {
    $sql_get_smss="SELECT * FROM smss 
                   JOIN hashtag_knowledges hk ON smss.hashtag_id=hk.hashtag_id AND hk.knowledge_id=".htmlspecialchars($_GET['knowledge_id'])." 
                   WHERE flag_save=0 OR (flag_save=1 AND user_id ='".htmlspecialchars($_SESSION['user_id'])."')";
  } else if(isset($_GET['hashtag_id'])) {
    $sql_get_smss="SELECT * FROM smss 
                   WHERE (flag_save=0 OR (flag_save=1 AND user_id ='".htmlspecialchars($_SESSION['user_id'])."'))
                   AND hashtag_id=".htmlspecialchars($_GET['hashtag_id']);
  
  }


  
  $res_get_smss = mysqli_query($mysqli, $sql_get_smss);
  $arr_get_smss = [];
  while($arr = mysqli_fetch_assoc($res_get_smss)) 
    $arr_get_smss[] = $arr;
  // GET PAGES
  if(!isset($_GET['page']) || $_GET['page']<1) {
    $_GET['page'] = 1;
  }

  
  if(!isset($_GET['sms_lim'])) {
    $_GET['sms_lim'] = 3;
  }
  
  $last_page = ceil(count($arr_get_smss) / $_GET['sms_lim']);
  if($_GET['page'] > $last_page) {
    $_GET['page'] = $last_page;
  }
  // get functions 
  function getNameById(&$mysqli, $table_name, $id, $col_where, $col_name) {
    $sql_get_by_id = "SELECT ".$col_name." FROM ".$table_name." WHERE ".$col_where."="."'".htmlspecialchars($id)."'";
    $res_get_by_id = mysqli_query($mysqli, $sql_get_by_id);
    
    if(mysqli_errno($mysqli)) echo println("Ошибка запроса: ".mysqli_error($mysqli));
    $res_arr = mysqli_fetch_assoc($res_get_by_id);
    if(!isset($res_arr)) {
      return 'Not found';
    }
    return $res_arr[$col_name];
  }

  function getSmsKnowledges(&$mysqli, $hashtag_id) {
    $sql_get = "SELECT knowledge_id FROM hashtag_knowledges WHERE hashtag_id=".$hashtag_id;
    $res_get = mysqli_query($mysqli, $sql_get);
    $arr_get = [];
    
    while ($arr = mysqli_fetch_assoc($res_get)) {
      $knowledge = getNameById($mysqli, 'knowledges', $arr['knowledge_id'], 'knowledge_id', 'name');
      $arr_get[] = $knowledge;
    } 
    return $arr_get;
  }
  
  function getAllTableRows(&$mysqli, $table_name) {
    $sql_get = "SELECT * FROM ".$table_name;
    $res_get = mysqli_query($mysqli, $sql_get);
    $arr_get = [];
    
    while ($arr = mysqli_fetch_assoc($res_get)) {
      $arr_get[] = $arr;
    } 
    return $arr_get;
  }

  $arr_knowledges = getAllTableRows($mysqli, 'knowledges');
  $arr_hashtags = getAllTableRows($mysqli, 'hashtags');

  for($i=0;$i<count($arr_get_smss); $i++) {
    
    
    $hashtag_id = $arr_get_smss[$i]['hashtag_id'];
    $user_id = $arr_get_smss[$i]['user_id'];
    $channel_id = $arr_get_smss[$i]['channel_id'];
    
    

    $hashtag = getNameById($mysqli, 'hashtags', $hashtag_id, 'hashtag_id', 'name');
    $channel = getNameById($mysqli, 'channels', $channel_id, 'channel_id', 'name');
    $channel_liked = getNameById($mysqli, 'channels', $channel_id, 'channel_id', 'flag_like');
    $user = getNameById($mysqli, 'users', $user_id, 'user_id', 'name');
    
    $arr_get_smss[$i]['hashtag'] = $hashtag;
    $arr_get_smss[$i]['channel'] = $channel;
    $arr_get_smss[$i]['flag_like'] = $channel_liked;
    $arr_get_smss[$i]['user'] = $user;

    $knowledges = getSmsKnowledges($mysqli, $hashtag_id);
    $arr_get_smss[$i]['knowledges'] = $knowledges;

  }
  
  function printSmsCard($cur) {
    echo '<li class="sms-card txt--sm">';
    echo '<div class="sms-card__header">';
      echo '<div class="sms-card__channel-tags">';
      echo '<div class="sms-card__channel">';
        echo 'Channel: '.$cur['channel'];
        if($cur['flag_like']) {
          echo '✓';
        }
      echo '</div>';
        echo '<div class="sms-card__tag">';
          echo '#'.$cur['hashtag'];
        echo '</div>';
      echo '</div>';
      echo '<div class="sms-card__knowledges">';
        foreach($cur['knowledges'] as &$val) {
          
          echo '<div class="sms-card__knowledge">'.$val.'</div>';
        }
      echo '</div>';
      echo '<div class="sms-card__head-row">';
        echo '<div class="sms-card__user">'.$cur['user'].'</div>';
        echo '<div class="sms-card__date">'.$cur['data'].'</div>';
      echo '</div>';
    echo '</div>';
    echo '<div class="sms-card__body">';
      echo '<p class="txt--sm">';
      echo $cur['description'];
      echo '</p>';
      if($cur['flag_save']) {

        echo '<div class="sms-card__hidden">Saved</div>';
      }
    echo '</div>';
    echo '</li>';
  }

  function addUrlParameters() {
    if(isset($_GET['knowledge_id'])) {
      echo '&knowledge_id='.$_GET['knowledge_id'];
    } else if(isset($_GET['hashtag_id'])) {
      echo '&hashtag_id='.$_GET['hashtag_id'];
    }
  }  

  echo '<section class="section">';
    echo '<div class="section__container wrapper">';
      echo '<div class="parameters">';
        echo '<div class="parameters__row">';
          echo '<div class="parameters__list-name txt--sm">';
            echo 'Field of knowledge:';
          echo '</div>';
          echo '<ul class="parameters__list">';
            for($i=0;$i<count($arr_knowledges);$i++) {
              echo '<li class="parameters__list-item txt--sm ';
              
              if(isset($_GET['knowledge_id']) && $_GET['knowledge_id'] == $arr_knowledges[$i]['knowledge_id']) {
                echo ' active ';
              }
              echo '">';
                echo '<a href=index.php?knowledge_id='.$arr_knowledges[$i]['knowledge_id'].' class="link link--hover_off">';
                  echo $arr_knowledges[$i]['name'];
                echo '</a>';
              echo '</li>';
            }
          echo '</ul>';
        echo '</div>';
        echo '<div class="parameters__row">';
          echo '<div class="parameters__list-name txt--sm">';
            echo '#Hashtags:';
          echo '</div>';
          echo '<ul class="parameters__list">';
            for($i=0;$i<count($arr_hashtags);$i++) {
              echo '<li class="parameters__list-item txt--sm';
              if(isset($_GET['hashtag_id']) && $_GET['hashtag_id'] == $arr_hashtags[$i]['hashtag_id']) {
                echo ' active ';
                echo $_GET['hashtag_id'];
              }
              echo '">';
                echo '<a href=index.php?hashtag_id='.$arr_hashtags[$i]['hashtag_id'].' class="link link--hover_off">';
                  echo '#'.$arr_hashtags[$i]['name'];
                echo '</a>';
              echo '</li>';
            }
          echo '</ul>';
        echo '</div>';
      echo '</div>';

      echo '<ul class="list sms-list">';
      

      if(count($arr_get_smss) > 0) {
        for($i=($_GET['page'] - 1) * $_GET['sms_lim'];$i<min(count($arr_get_smss), ($_GET['page']) * $_GET['sms_lim']);$i++) {
          printSmsCard($arr_get_smss[$i]);
        }

        
        echo '<ul class="pagination txt--sm"';
          if($_GET['page'] != 1) {
            echo '<li class="pagination__item">';
              echo '<a href="index.php?page=1';
              addUrlParameters();
              echo '" class="link link--theme_btn_add_1">';
                echo 'First';
              echo '</a>';
            echo '</li>';
            echo '<li class="pagination__item">';
              echo '<a href="index.php?page='.($_GET['page']-1);
              addUrlParameters();
              echo '" class="link link--theme_btn_add_1">';
                echo 'Prev';
              echo '</a>';
            echo '</li>';
          }

          $pagination_radius = 2;
          if($_GET['page'] == 1 || $_GET['page'] == $last_page) 
            $pagination_radius = 4;
          
          if($_GET['page'] == 2 || $_GET['page'] == $last_page - 1) 
            $pagination_radius = 3;


          for($i=max($_GET['page'] - $pagination_radius,1); $i <= min($_GET['page'] + $pagination_radius,$last_page);$i++) {
            echo '<li class="pagination__item">';
            
            echo '<a href="index.php?page='.($i);
            addUrlParameters();
            echo '" class="link link--theme_btn_add_1 ';
            if($i == $_GET['page']) 
              echo 'active';
            echo '">';
                echo $i;
              echo '</a>';
            echo '</li>';
          }
          // Pagination Next, Last
          if($_GET['page'] < $last_page) {
            echo '<li class="pagination__item">';
              echo '<a href="index.php?page='.($_GET['page']+1);
              addUrlParameters();
              echo '" class="link link--theme_btn_add_1">';
                echo 'Next';
              echo '</a>';
            echo '</li>';
            echo '<li class="pagination__item">';
              echo '<a href="index.php?page='.$last_page;
              addUrlParameters();
              echo '" class="link link--theme_btn_add_1">';
                echo 'Last';
              echo '</a>';
            echo '</li>';
          }
        echo '</ul>';
      
      } else {
        echo 'No messages';
      }

      echo '</ul>';
    echo '</div>';
  echo '</section>';
?>

<?php 
include('templates/footer.html');
?>


<?php
  // require('db.php');
  // $mysqli = connect();
  // // if(isset($_GET['p']) && $_GET['p'] == 'view') {
  //   echo '<div id = "submenu" class="submenu">';
  //     echo '<a class="select"
  //     href = "index.php?sort=byid">По умолчанию</a>';
  //     echo '<a class="select"
  //     href = "index.php?sort=byfirstname">По фамилии</a>';
  //     echo "</div>";
  // // }
  // if(isset($_POST['firstname'])) {
  //   // echo $_POST['date'];
  //   $sql_insert = "INSERT INTO `notebook` (`firstname`, `name`, `lastname`, `gender`, `address`, `phone`, `email`, `date`, `comment`) 
  //   VALUES 
  //   ('".htmlspecialchars($_POST['firstname'])."',
  //   '".htmlspecialchars($_POST['name'])."',
  //   '".htmlspecialchars($_POST['lastname'])."',
  //   '".htmlspecialchars($_POST['gender'])."',
  //   '".htmlspecialchars($_POST['address'])."',
  //   '".htmlspecialchars($_POST['phone'])."',
  //   '".htmlspecialchars($_POST['email'])."',
  //   '".htmlspecialchars($_POST['date'])."',
  //   '".htmlspecialchars($_POST['comment'])."')";
  //   echo mysqli_query($mysqli, $sql_insert);
  //   if(mysqli_errno($mysqli)) echo println("Ошибка запроса: ".mysqli_error($mysqli));
  // }

  // $sql_count = "SELECT COUNT(*) FROM notebook";
  // $res_count = mysqli_query($mysqli, $sql_count);
  // $count_rows = mysqli_fetch_row($res_count)[0];
  // $rows_per_page = 4;
  // $count_pages = $count_rows/$rows_per_page;

  // if(!isset($_GET['page'])) {
  //   $_GET['page']=0;
  // }

  // $first_p = $_GET['page'] * $rows_per_page;
  // // sort
  // if(isset($_GET['sort'])) {
  //   if($_GET['sort'] == 'byid') {
  //     $sql = "SELECT * FROM `notebook` ORDER BY id LIMIT ".$first_p.", ".$rows_per_page;
  //   } else
  //   if($_GET['sort'] == 'byfirstname') {
  //     $sql = "SELECT * FROM `notebook` ORDER BY firstname LIMIT ".$first_p.", ".$rows_per_page;
  //   } else {
  //     $sql = "SELECT * FROM `notebook` LIMIT ".$first_p.", ".$rows_per_page;  
  //   }
  // } else {
  //   $sql = "SELECT * FROM `notebook` LIMIT ".$first_p.", ".$rows_per_page;
  // } 
  // // echo $sql;
  // $res = mysqli_query($mysqli, $sql);
  // if (mysqli_errno($mysqli)) 
  //   println("Ошибка запроса: ".mysqli_error($mysqli));
  
  //   // println('Всего записей:');
  //   // print_r(mysqli_num_rows($res));
  //   // println();
  // $table = '
  //   <table class="table">
  //     <thead>
  //       <tr>
  //         <th scope="col">ID</th>
  //         <th scope="col">Firstname</th>
  //         <th scope="col">Name</th>
  //         <th scope="col">Lastname</th>
  //         <th scope="col">Gender</th>
  //         <th scope="col">Address</th>
  //         <th scope="col">Phone</th>
  //         <th scope="col">email</th>
  //         <th scope="col">date</th>
  //         <th scope="col">comment</th>
  //       </tr>
  //     </thead>
  //     <tbody>
  //     ';
  // while($arr = mysqli_fetch_assoc($res)) {
  //   $table .= '<tr>
  //   <th scope="row">'.$arr['id'].'</th>
  //   <td>'.$arr['firstname'].'</td>
  //   <td>'.$arr['name'].'</td>
  //   <td>'.$arr['lastname'].'</td>
  //   <td>'.$arr['gender'].'</td>
  //   <td>'.$arr['address'].'</td>
  //   <td>'.$arr['phone'].'</td>
  //   <td>'.$arr['email'].'</td>
  //   <td>'.$arr['date'].'</td>
  //   <td>'.$arr['comment'].'</td>
  //   </tr>'; 
  // }
  
  // $table.='</tbody>
  // </table>';
  // println($table);
  // // print_r(mysqli_num_rows($res));
  // // println();
  // // // Массив с ключами - числами
  // // // print_r(mysqli_fetch_row($res));
  // // // println();
  // // // Массив с ключами - именами полей: id, name, firstname, address, phone, 
  // // print_r(mysqli_fetch_assoc($res));
  // for($i=0;$i<$count_pages;$i++) {
  //   if(!isset($_GET['sort']))
  //   echo '<a href=index.php?page='.$i.'>'.($i+1).' </a>';
  //   else echo '<a href=index.php?sort='.$_GET['sort'].'&page='.$i.'>'.($i+1).' </a>';
  // }
  ?>