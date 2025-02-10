<?php

Route::add('/', function () {
    $bookController = new BookController();
    $books = $bookController->getAll();
    require(__DIR__ . "/../views/pages/index.php");
});
