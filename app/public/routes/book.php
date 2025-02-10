<?php

require_once(__DIR__ . "/../controllers/BookController.php");
require_once(__DIR__ . "/../controllers/ReviewController.php");


Route::add('/book/([0-9]*)', function ($bookId) {
    $bookController = new BookController();
    $reviewController = new ReviewController();

    $book = $bookController->get($bookId);
    $reviews = $reviewController->getByBookId($bookId);
    if ($book) {
        require_once(__DIR__ . "/../views/pages/book.php");
    } else {
        echo "Book not found.";
    }
});

Route::add('/book/add', function () {
    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'Admin') {
    $bookController = new BookController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bookController->insert();
    }

     $genres = $bookController->getGenres();
     require_once(__DIR__ . "/../views/pages/addbook.php");
     
}
}, ['get', 'post']);

Route::add('/addreview', function () {
    if (isset($_SESSION['user'])) {
    $reviewController = new ReviewController();
    $reviewController->insert();
    }
}, ['post']);

Route::add('/deletebook', function () {
    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'Admin') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bookController = new BookController();
        $bookController->delete();
    }
}
}, ['post']);


Route::add('/editbook/([0-9]*)', function ($bookId) {
    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'Admin') {
    $bookController = new BookController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bookController->edit();
    }
    
    $book = $bookController->get($bookId);
    $genres = $bookController->getGenres();
    if ($book) {
        require_once(__DIR__ . "/../views/pages/editbook.php");
    } else {
        echo "Book not found.";
    }
}
}, ['get', 'post']);
