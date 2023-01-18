<?php
    require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

    use App\Nig\Controller\ControllerVoiture;
    use \App\Nig\Model\HTTP\Session;


$loader = new App\Nig\Lib\Psr4AutoloaderClass();
    $loader->addNamespace('App\Nig', __DIR__ . '/../src');
    $loader->register();

    $action = isset($_GET['action']) ? $_GET['action'] : "home";
    $controller = isset($_GET['controller']) ? $_GET['controller'] : 'question';

    $session=Session::getInstance();
    $utilisateur = $session->lire('login');
    // var_dump($utilisateur);  //pour afficher l'utilisateur en cours
    //$session->detruire();

    //var_dump($session->lire('avatarUrl'));






    $controllerClassName = "App\Nig\Controller\Controller" . ucfirst($controller);




   if (!class_exists($controllerClassName))
       return require ControllerVoiture::error("No controller found for " . $controllerClassName);

    $controllerClassName::$action();
?>