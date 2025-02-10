<?php

require_once(__DIR__ . "/../controllers/UserController.php");

Route::add('/signup', function () {
    if (!isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController = new UserController();
        $userController->create();
        header("Location: /");
        exit;
    }
    require_once(__DIR__ . "/../views/pages/signup.php");
}

}, ['get', 'post']);

Route::add('/login', function () {
    if (!isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController = new UserController();
        $userController->login();
        header("Location: /");
        exit;
    }

    require_once(__DIR__ . "/../views/pages/login.php");
}
}, ['get', 'post']);

Route::add('/logout', function () {
if (isset($_SESSION['user'])) {
    $userController = new UserController();
    $userController->logout();
}
}, ['get']);