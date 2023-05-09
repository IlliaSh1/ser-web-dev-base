<?php
  include("templates/menu.php");

  require('db.php');
  $mysqli = connect();
?>

<?php 
    echo '<section class="section"><div class="wrapper section__container">';
    if(!isset($_SESSION['user_id'])) {
        if(isset($_POST['email'])) {
            $try_authorize = true;
            function getByName(&$mysqli, $table_name, $name, $col_where, $col_id) {
                $sql_get_by_name = "SELECT * FROM ".$table_name." WHERE ".$col_where."="."'".htmlspecialchars($name)."'";
                $res_get_by_name = mysqli_query($mysqli, $sql_get_by_name);
                
                if(mysqli_errno($mysqli)) echo println("Ошибка запроса: ".mysqli_error($mysqli));
                $res_arr = mysqli_fetch_assoc($res_get_by_name);
                if(!isset($res_arr)) {
                    return 'Not found';
                }
                return $res_arr;
            }

            $email = htmlspecialchars($_POST['email']);
            $get_user = getByName($mysqli, 'users', $email, 'email', 'user_id');
            
            if($get_user == 'Not found') {
                $password_equal = false;
            } else {

                $user_id = $get_user['user_id'];
                $password_equal = ($get_user['password'] === htmlspecialchars($_POST['password']));
                if(!$password_equal) {
                    print_r($get_user);
                } else {
                    echo "Welcome ".$get_user['name']."!";
                    $is_authorized = true;
                    $_SESSION['user_id'] = $get_user['user_id'];
                    $_SESSION['user_name'] = $get_user['name'];
                    $_SESSION['user_email'] = $get_user['email'];
                }
            }
        }
        
        function print_form($try_authorize, $is_authorized, $email_exists, $password_equal) {
            if(isset($is_authorized) && $is_authorized === true) {
                return;
            }

            echo '<form class="form form--theme_dark" action="login.php" method="post">
            <h1 class="txt--md">Log In</h1>
            
            <label class="label label--select txt--sm">
            <input class="input input--theme_1" type="email" name="email" placeholder="Your email" ';
            if($try_authorize) {
                echo 'value="'.htmlspecialchars($_POST['email']).'"';
            }
            echo 'required>
            <span class="label__txt txt--sm">Email</span>
            <span class="label__error-msg txt--xs">Please write correct email</span>
            </label>
            
            <label class="label label--select txt--sm">
            <input class="input input--theme_1" type="password" name="password" placeholder="Your password"';
            if($try_authorize) {
                echo 'value="'.htmlspecialchars($_POST['password']).'"';
            }
            echo '>
            <span class="label__txt txt--sm">Password</span>
            <span class="label__error-msg txt--xs">Wrong password</span>
            </label>
            ';
            if($try_authorize) {
                echo '<p class="w100pct cl-invalid">';
                if(!$email_exists) {
                    echo 'Email not found!';
                } else if(!$password_equal) {
                    echo 'Wrong password!';
                } else {
                    echo 'Unexpected error';
                }
                echo '</p>';
            }


            echo '<button type="submit" class="btn btn--theme_add_dark txt--sm txt--bolder txt--upper">Sent</button>';
        }
        if(!isset($try_authorize)) {
            $try_authorize = false;
        }
        if(!isset($get_user)) {
            $get_user = 'Not found';
        }
        if(!isset($password_equal)) {
            $password_equal = false;
        }
        print_form($try_authorize, isset($is_authorized), $get_user != 'Not found', $password_equal);
    } else {
        echo "<span class='txt--lg'>You're already authorized!</span>";
    }
    echo '</div></section>';
?>

<?php 
include('templates/footer.html');
?>