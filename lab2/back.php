<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab 2</title>
  <link rel="stylesheet" href="src/css/normalize.css">
  <link rel="stylesheet" href="src/css/style.css">
</head>
<body class="body">
  <div class="body__wrapper">

    <header class="header">
      <div class="wrapper header__container">
        <img src="src/img/logo.svg" alt="mospolytech logo" width="300">
        <h1 class="title">4.1 Feedback Form</h1>
        <nav class="header__menu">
          <ul class="header__menu-list list">
            <li class="header__menu-item"><a href="" class="link"></a></li>
          </ul>
        </nav>
      </div>
    </header>
    <main class="main">
        <div class="wrapper">

                <?php 
            $url = "https://fit.mospolytech.ru/";
            echo "<textarea style=\"width:100%;\" cols=\"30\" rows=\"30\">";
                print_r(get_headers($url));
            echo "</textarea>";
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