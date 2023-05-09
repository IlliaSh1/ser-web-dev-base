

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab 6</title>
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
      <div class="wrapper wrapper--vert">
        <!-- <?php
          $str = "aae xxz 33a";
          $mas = [];
          echo $str."<br>";
          echo preg_replace("/(.)\1/", "!", $str);
          
        ?> -->
        <?php
          // Задание 1
          $str = 'waaa baaa';
          echo $str."<br>";
          echo preg_replace("/(?<!b)a{3}/", "!", $str)."<br><br>";
          // Задание 2
          $str = 'a1b2c3';
          echo $str."<br>";
          $mas=[];
          preg_match("/([a-z])([0-9])([a-z])([0-9])([a-z])([0-9])/", $str, $mas);
          $ans = "";
          for($i=1;$i<count($mas);$i++) {
          $ans.=$mas[$i];
          if($i%2-1) {
            $ans.=$mas[$i];
          }
          }
          echo $ans."<br><br>";
          // Задание 3
          $str = 'aa aba abba abbba abbbba abbbbba';
          echo $str."<br>";
          $mas=[];
          preg_match_all("/ab{0,3}a/", $str, $mas)."<br>";
          echo var_dump($mas)."<br><br>";
          // Задание 4
          $str = 'aba aca aea abba adca abea aa';
          $mas = [];
          echo $str."<br>";
          preg_match_all("/a..a/", $str, $mas)."<br>";
          echo var_dump($mas);
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
  <script src="src/js/calc.js"></script>
  
</body>
</html>