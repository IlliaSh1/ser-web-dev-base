<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab 3</title>
  <link rel="stylesheet" href="src/css/normalize.css">
  <link rel="stylesheet" href="src/css/style.css">
</head>
<body class="body">
  <div class="body__wrapper">

    <header class="header">
      <div class="wrapper header__container">
        <img src="src/img/logo.svg" alt="mospolytech logo" width="300">
        <h1 class="title">1.2 Solve the equation</h1>
        <nav class="header__menu">
          <ul class="header__menu-list list">
            <li class="header__menu-item"><a href="" class="link"></a></li>
          </ul>
        </nav>
      </div>
    </header>
    <main class="main">
      <div class="wrapper">
        <form class="form form--theme-black" action="" method="get">
          <label class="label" for="">
            Введите уравнение: 
            <input class="input input--wd-100" class="" type="text" name="equation" id="" placeholder="7 + x = 21;">
          </label>
          <button type="submit">Отправить</button>
        </form>
        


        <?php 
          function println($str) {
            echo '<p>'.$str.'</p>';
          };
          
          function solve_equation() {
            $s = $_GET['equation'].';';
            $operator = "";
            $posX = "";
            $a = "";
            $b = "";
            for($i=0;$i<strlen($s);$i++) {
              if($s[$i] == ' ') continue;
              if($s[$i] == 'x' || $s[$i] == 'X') 
                if(!$operator) {
                  $posX = 'l';
                } else {
                  $posX = 'r';
                }
              if($a === "") {
                while($s[$i]>='0' && $s[$i]<='9') {
                  $a.=$s[$i];
                  $i++;
                }
              } else {
                while($s[$i]>='0' && $s[$i]<='9') {
                  $b.=$s[$i];
                  $i++;
                } 
              }

              if($s[$i] == '+' || $s[$i] == '-' || $s[$i] == '*' || $s[$i] == '/') 
                $operator = $s[$i];
              
            }
            
            if($operator == '+') {
              $ans = $b-$a;
            }
            if($operator == '*') {
              $ans = $b/$a;
            }

            if($posX=='l') {
              switch($operator) {
                case('-'):
                  $ans = $b+$a;
                  break;
                
                case('/'):
                  $ans = $b*$a;
                  break;
              }
            } else if($posX=='r') {
              switch($operator) {
                case('-'):
                  $ans = $a-$b;
                  break;
                
                case('/'):
                  $ans = $a/$b;
                  break;
              }
            }
            
            
            println('Ввод: '.$_GET['equation'].'</p>');
            println('Результат: x = '.$ans);
            
          };

          if(isset($_GET['equation'])) {
            solve_equation();
          }
        ?>
      
      </div>

    </main>
    <footer class="footer">
        <div class="wrapper footer__container">
            <p>
                Шамаров Илья Глебович, 221-321
            </p>
        </div>
        
    </footer>
  
  </div>
</body>
</html>