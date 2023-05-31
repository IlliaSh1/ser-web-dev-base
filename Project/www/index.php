<?php
    // use Controllers\MainController;


    // Подключение Моделей, контроллеров
    spl_autoload_register(function ($className) {
        require_once('../src/'.$className.'.php');    
    });
    
    $route = $_GET['route'] ?? "";
    $routes = require_once('../src/routes.php');
    $isRouteFound = false;
    
    foreach($routes as $pattern=>$controllerAndAction) {
        preg_match($pattern, $route, $matches);
        if(!empty($matches)) {
            $isRouteFound = true;
            break;
        }    
    }

    if(!$isRouteFound) {
        $view = new View\View(__DIR__.'/../templates');
        $view->renderHTML('errors/404.php', [], 404);
        return;
    }
    // var_dump($controllerAndAction);
    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];
    unset($matches[0]);
    $controller =  new $controllerName;
    $controller->$actionName(...$matches);



?>