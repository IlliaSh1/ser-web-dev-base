<?php
session_start();

function println($str="") {
  echo $str."<br>";
}
?>

<!doctype html>
<html lang="en">
<head>
  <title>#Сортер</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- CSS -->
  <link rel="stylesheet" href="src/css/normalize.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="body__wrapper">
  <div class="body__wrapper">
  <header class="header header--theme_accentdark">
    <div class="wrapper header__container">
      <div class="header__logo"><a href="mospolytech.ru" class="header__logo" aria-label="Перейти на сайт Московского Политеха"><img src="src/img/logo.svg" alt="Mospolytech" class="header__logo-img"></a></div>
      <button id="=header-menu" class="header__menu-toggle menu-toggle btn btn--theme_off hidden--after_md" aria-label="Menu toggle button">
        <svg class="burger-menu header__toggle-img wauto" viewBox="0 0 33 26" fill="none" width="32" height="25"
          xmlns="http://www.w3.org/2000/svg">
            <g>
                <path class="burger-menu__top-line" d="M2 2 L31 2" stroke="currentColor" stroke-width="3.7" stroke-linecap="round"/>
                <path class="burger-menu__middle-line" d="M10 13 L31 13" stroke="currentColor" stroke-width="3.7" stroke-linecap="round"/>
                <path class="burger-menu__bottom-line" d="M2 24 L31 24" stroke="currentColor" stroke-width="3.7" stroke-linecap="round"/>
            </g>
        </svg>
      </button>
      <nav id="header-menu" class="header__menu">
        <div class="header__menu-container">
          <ul class="header__menu-list txt--sm">
            <li class="header__menu-item"><a href="index.php" class="link">View Messages</a></li>
            <li class="header__menu-item"><a href="add.php" class="link">Add Message</a></li>
            <?php
            if(!isset($_SESSION['user_id'])) {
              echo '<li class="header__menu-item"><a href="login.php" class="link">Login</a></li>';
              echo '<li class="header__menu-item"><a href="login.php" class="link">Sign Up</a></li>';
            }
            else {
              echo '<li class="header__menu-item"><a href="profile.php" class="link">'.$_SESSION['user_name'].'</a></li>';
            }
            ?>
          </ul>
        </div>
      </nav>
    </div>
  </header>

  <main>
  