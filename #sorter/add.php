<?php 
include("templates/menu.php");

require('db.php');
$mysqli = connect();
$ab = 'фыва';
echo strlen($ab);
?>

<?php
if(!isset($_SESSION['user_id'])) {
    echo "<section class='section'><div class='wrapper section__wrapper'>";
    echo "<h1 class='txt--lg'>You need to authorize before adding messages</h1>";
    echo "</div></section>";
} else {
    if(isset($_POST['hashtag'])) {
        function addSMS(&$mysqli, $sms_id, $hashtag_id, $user_id, $channel_id, $description, $data, $flag_save) {
            $sql_insert = "INSERT INTO `smss` (`sms_id`, `hashtag_id`, `user_id`, `channel_id`, `description`, `data`, `flag_save`) 
            VALUES 
            ('".htmlspecialchars($sms_id)."',
            '".htmlspecialchars($hashtag_id)."',
            '".htmlspecialchars($user_id)."',
            '".htmlspecialchars($channel_id)."',
            '".htmlspecialchars($description)."',
            '".htmlspecialchars($data)."',
            '".htmlspecialchars($flag_save)."')";
            
            $res = mysqli_query($mysqli, $sql_insert);
            if($res == true) {
                echo '<section class="section">';
                echo '<div class="section__container wrapper">';
                echo '<h1 class="txt--md">Success</h1>';
                echo '</div></section>';
            }
            
            if(mysqli_errno($mysqli)) {
                echo println("Ошибка запроса: ".mysqli_error($mysqli));
                return false;
            }
            return true;
        }

        function getIdByName(&$mysqli, $table_name, $name, $col_where, $col_id) {
            $sql_get_by_name = "SELECT * FROM ".$table_name." WHERE ".$col_where."="."'".htmlspecialchars($name)."'";
            $res_get_by_name = mysqli_query($mysqli, $sql_get_by_name);
            
            if(mysqli_errno($mysqli)) echo println("Ошибка запроса: ".mysqli_error($mysqli));
            $res_arr = mysqli_fetch_assoc($res_get_by_name);
            if(!isset($res_arr)) {
                return false;
            }
            return $res_arr[$col_id];
        }
        $hashtag_id = getIdByName($mysqli, 'hashtags', $_POST['hashtag'], 'name', 'hashtag_id');
        $channel_id = getIdByName($mysqli, 'channels', $_POST['channel'], 'name', 'channel_id');
        
        $form_msg_err = '';
        if (!isset($_SESSION['user_id'])) {
            $form_msg_err .= 'You need to authorize!<br>';
        }
        if ($hashtag_id == false) {
            $form_msg_err .= 'Wrong hashtag!<br>';
        }
        if ($channel_id == false) {
            $form_msg_err .= 'Wrong channel!<br>';
        }
        if(empty($_POST['m_description'])) {
            $form_msg_err .= 'Empty description!<br>';
        }

        if(empty($form_msg_err)) {
            $cur_datetime = date('Y/m/d H:i:s', time());
            
            addSMS($mysqli, '0', $hashtag_id, $_SESSION['user_id'], $channel_id, $_POST['m_description'], $cur_datetime, isset($_POST['flag_save']));
            $sended = true;
        }
    }

    if(!isset($sended)) {
        // get data from DB cols
        function selectAllCol($table_name, &$mysqli, $col_name) {
            $sql_get_req = "SELECT * FROM ".$table_name;
            $res_get_req = mysqli_query($mysqli, $sql_get_req);
            if(mysqli_errno($mysqli)) echo println("Ошибка запроса: ".mysqli_error($mysqli));
            
            $arr_res = [];
            while($arr = mysqli_fetch_assoc($res_get_req))
                $arr_res[] = $arr[$col_name];
            return $arr_res;
        }

        $arr_hashtags = selectAllCol('hashtags', $mysqli, 'name');
        $arr_channels = selectAllCol('channels', $mysqli, 'name');
        
        // Form START
        echo '
        <section class="section">
            <div class="wrapper section__container">
            <form class="form form--theme_dark" name="form_add" method="post" action="add.php">
            <h1 class="txt--md">Add new message</h1>
        ';
        // Template functions for inputs with choice
        function addDatalistInput($input_name, &$options, $input_title, $input_placeholder, $input_err_msg) {
            $datalist_name = $input_name.'_option_list';
            echo '<label class="label label--select txt--sm">
            <input class="input input--theme_1" type="text" list="'.$datalist_name.'" name="'.$input_name.'" placeholder="'.$input_placeholder.'"';
            if(isset($_POST[$input_name])) {
                echo 'value="'.$_POST[$input_name].'"';
            }
            'pattern="^(';
            if($options[0]) 
                echo $options[0];
            for($i=1;$i<count($options);$i++) 
                echo '|'.$options[$i];   
            echo ')$">';
            echo '<datalist id="'.$datalist_name.'">';
            for($i=0;$i<count($options);$i++) {
                echo '<option value="'.$options[$i].'"></option>';
            }
            echo '</datalist>';
            echo '<span class="label__txt txt--sm">'.$input_title.'</span>
            <span class="label__error-msg txt--xs">'.$input_err_msg.'</span>
            </label>';
        }
        // Hashtags
        addDatalistInput('hashtag', $arr_hashtags, '#Hashtag', 'Choose #Hashtag', 'Please choose correct option');
        // Channel
        addDatalistInput('channel', $arr_channels, 'Channel', 'Choose Channel', 'Please choose correct option');
        // Message
        echo '<label class="label label--select txt--sm">
        <textarea type="text" name="m_description" class="textarea textarea--theme_1" placeholder="Insert message description"
            required>';
            if(isset($_POST['m_description'])) {
                echo htmlspecialchars($_POST['m_description']);
            }
            echo '</textarea>
        <span class="label__txt txt--sm">Description</span>
        <span class="label__error-msg txt--xs"></span>
        </label>';
        // Flag save 
        echo '<label class="label label--checkbox txt--sm">
        <input class="input" type="checkbox" name="flag_save">
        <span class="label__txt txt--sm">Hide from other users</span>
        </label>';
        if(isset($form_msg_err) && !empty($form_msg_err)) {
            echo '<p class="w100pct cl-invalid">';
            echo $form_msg_err;
            echo '</p>';
        }
        // Submit BTN
        echo '<button type="submit" class="btn btn--theme_add_dark txt--sm txt--bolder txt--upper">Submit</button>';

        // Form END
        echo '</form>';
        echo '</div>
        </section>';
    }
}
?>

<?php
include("templates/footer.html");
?>