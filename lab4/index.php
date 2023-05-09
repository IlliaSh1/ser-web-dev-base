<?php 
  session_start();
  if( !isset($_SESSION['history']) ) {
    $_SESSION['iteration']=0;
    $_SESSION['history']=array();
  }
  $_SESSION['iteration']+=1;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab 4</title>
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
    <main class="main main--theme-dark">
      <section class="calc-sect">
        
        <div class="wrapper wrapper--vert calc-sect__container">
          <!-- .calc>.calc__container>.calc__screen+.calc__btns>.calc__btn -->
          
          <form action="" method="post" class="calc calc--theme-gradient">
            
            <div class="calc__container">
              <div class="calc__screen calc__screen--theme-gradient">
                <!-- <div class="calc__head">4+_+adsfsadfsadfasdfasdfadsf</div> -->
                <input class="input calc__res" type="text" name="val" id="" placeholder="0">
              </div>

              <button type="reset" class="btn calc__btn calc__btn--theme-gradient" value="AC">AC</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="(">(</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value=")">)</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="/">÷</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="7">7</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="8">8</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="9">9</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="*">×</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="4">4</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="5">5</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="6">6</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient calc__btn--big" value="-">-</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="1"> 1</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="2"> 2</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="3"> 3</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient calc__btn--span-2" value="+">+</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient" value="0">0</button>
              <button type="button" class="btn calc__btn calc__btn--theme-gradient calc__btn--big" value=".">•</button>
              <button type="submit" class="btn calc__btn calc__btn--theme-gradient calc__btn--big" value="">=</button>
              
              <input type="hidden" name="iteration" value="<?php echo $_SESSION['iteration']; ?>">
            </div>
          </form>

          <!-- CALC -->
          <?php
            function isnum($x) {
              $x = strval($x);
              if(strlen($x)==0)
                return false;

              if($x == "-")
                return false;
              if($x[0] == '.' || $x[strlen($x)-1]=='.') 
                return false;
                
                $flag_minus = ($x[0]=='-');
                $flag_point = false;
                for($i=0+$flag_minus;$i<strlen($x); $i++) {
                  
                  if(!(($x[$i]>='0' && $x[$i]<='9') || $x[$i]=='.')) 
                  return false;

                  if($x[$i]=='.') 
                  if($flag_point)
                  return false;
                  else $flag_point = true;  
                  
                }
                return true;
            }
            
            function bktValid( $val) {
              $bal = 0;
              for($i=0;$i<strlen($val);$i++) {
                if($val[$i]=='(')
                  $bal++;
                else if ($val[$i]==')') {
                  $bal--;
                  if($bal<0) 
                    return false;
                }
              }
              if($bal!=0) 
                return false;
              return true;
            }

            function explodeMinus($s) { // Исключаем случаи, когда '-' 
              $s = strval($s); //стоит внутри умножаемых/делимых значений
              $flag_exception = false;
              $res = [];
              $sub_s = "";
              for($i=0;$i<strlen($s);$i++) {
                
                if($s[$i] == '-' && !$flag_exception) {
                  $res[] = $sub_s;
                  $sub_s = "";
                  
                } else {
                  $flag_exception = false;
                  $sub_s.=$s[$i];
                  if($s[$i] == '*' || $s[$i] == '/') {
                    $flag_exception = true;
                  }

                }
              }
              $res[] = $sub_s;
              return $res;
            }

            function addZero($s) {
              if($s[0]!='-') 
                return "0+".$s;
              else 
                return "0".$s;
            }
            
            function formatCalc($s) { // форматирование входной строки
              $s = strval($s);
              $new_s = "";
              for($i=0;$i<strlen($s); $i++) {
                switch($s[$i]) {
                  case(' ');
                  break;

                  case(':'); 
                  $new_s .= $s[$i];
                  break;
                  
                  default: 
                    $new_s .= $s[$i];
                }  
              }
              //  Замена num(num2) на num*(num2)
              for($i='0';$i<='9';$i++) {
                $new_s=str_replace($i."(", $i.'*(',$new_s);
              }
              return $new_s;
              
            }

            function calc($val) {
              // echo "|".$val."| "; 
              $val = strval($val);
              if(strlen($val)==0) 
                return "Выражение не задано!";

              if( $val[0]=='-' && substr_count($val, '-') == 1
                && substr_count($val, '*') == 0 && substr_count($val, '/') == 0
                && substr_count($val, '+') == 0 && isnum($val)
                ) {
                  return $val;
                }

              $res=0;
              $args = explode('+',$val);

              if(count($args)>1) {
                
                $res = 0;
                for($i=0;$i<count($args);$i++) {
                  $res_i = calc($args[$i]); 
                  if(isnum($res_i)) 
                    $res += $res_i;
                  else
                    return $res_i;
                }

                return $res;
                
              }
              /// Исключение для -num/num1*num2 при вычислении
              if($val[0]=='-' && $val!='-' && substr_count($val, '-') == 1) {
                $res_i = calc(substr($val, 1, strlen($val)-1));
                if(isnum($res_i))
                  $res -= $res_i;
                else 
                  return $res_i;
                
                  return $res;
              }

              
              $args = explodeMinus($val);
              if(count($args)>1) {
                  $res = 0;
                  

                  for($i=0;$i<count($args);$i++) {
                    $res_i = calc($args[$i]);
                    if(isnum($res_i)) 
                      if($i==0)
                        $res = $res_i;
                      else
                        $res -= $res_i;
                    else
                      return $res_i;
                  }


                  return $res;
              } 


              $args = explode('*',$val);
              if(count($args)>1) {
                
                $res = 1;
                
                for($i=0;$i<count($args);$i++) {
                  $res_i = calc($args[$i]); 
                  
                  if(isnum($res_i)) 
                    $res *= $res_i;
                  else
                    return $res_i;
                }

                return $res;
              }

              $args = explode('/',$val);
              if(count($args)>1) {
                
                $res = calc($args[0]);
                if(!isnum($res)) 
                  return $res;

                for($i=1;$i<count($args);$i++) {
                  $res_i = calc($args[$i]); 
                  // echo "a".$res_i;
                  if($res_i==0) {
                    return "Деление на ноль";
                  }
                  if(isnum($res_i)) 
                    $res /= $res_i;
                  else
                    return $res_i;
                }
                return $res;
              }

              if(isnum($val)) 
                return $val;
              else 
                return 'Неправильный формат числа';
            }

            function calcBkt($val) {
              if(!$val) 
                return "Выражение не задано!";
              $val = strval($val);
              if(!bktValid($val)) {
                return "Неправильный формат скобок";
              }
              $beg = strpos($val, "(");
              if($val[0]!='(')
              if (!$beg) {
                return calc($val);
              } 
              $en = 0;
              $bal = 1;
              
              for($i=$beg+1;$bal!=0;$i++) {
                if($val[$i]=='(')
                  $bal++;
                else if ($val[$i]==')')
                  $bal--;
                  if($bal==0)
                    $en=$i;
              }
              
              // echo "|adsf ".addZero(substr($val, $beg+1, $en-$beg-1));
              $new_val = calcBkt(addZero(substr($val, $beg+1, $en-$beg-1)));
              // echo "new =".$new_val."<br>";
              $new_val = strval($new_val);
              if(!isnum($new_val))
                return $new_val;

              if($new_val[0]=='-' ) {
                if($val[$beg-1]=='-') {
                  $val = calcBkt(substr($val, 0, $beg-1)."+".
                  substr($new_val, 1, strlen($new_val)-1).
                  substr($val, $en+1, strlen($val)-$en));   
                } else {
                  // echo "<br>P ".substr($val, 0, $beg-1).$new_val.substr($val, $en+1, strlen($val)-$en);
                  $val = calcBkt(substr($val, 0, $beg-1).$new_val.substr($val, $en+1, strlen($val)-$en)); 
              
                }
              } else {
                // echo "<br>P ".substr($val, 0, $beg).$new_val.substr($val, $en+1, strlen($val)-$en);
                $val = calcBkt(substr($val, 0, $beg).$new_val.substr($val, $en+1, strlen($val)-$en)); 
        
                }
              // echo "<br>a ".$val;
              return $val;
            }

            
          ?>
          <!-- HISTORY -->
          <div class="calc-history">
            <div class="calc-history__container">

                <?php
              if(isset($_POST['val'])) {
                
                if($_POST['val'][0]=='-') 
                  $res = calcBkt(formatCalc("0".$_POST['val']));
                  else
                  $res = calcBkt(formatCalc("0+".$_POST['val']));
                  if(isnum($res)) 
                  echo "Результат вычисления: ".$res."<br>";
                  else 
                  echo 'Ошибка вычисления: '.$res."<br>";
                }

              if(isset($_POST['iteration']))
              if($_POST['val'] && $_POST['iteration']+1==$_SESSION['iteration']) 
                $_SESSION['history'][] = $_POST['val'].' = '.$res;
              
                for($i=count($_SESSION['history'])-2;$i>=0; $i--) 
                echo strval($i+1).". ".$_SESSION['history'][$i].'<br>';
                ?>
            </div>
          </div>
        </div>
      </section>
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