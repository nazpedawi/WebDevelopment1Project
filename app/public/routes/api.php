<?php

require_once(__DIR__ . "/../controllers/BookController.php");

Route::add('/api/books', function () {
    $bookController = new BookController();

    // Get query parameters (search query and genre)
    $searchQuery = $_GET['search'] ?? '';
    $genre = $_GET['genre'] ?? '';

    // If there are no filters, use getAllBooks, otherwise use GetFilteredBooks
    if (empty($searchQuery) && empty($genre)) {
        $books = $bookController->getAll(); 
    } else {
        $books = $bookController->getFilteredBooks($searchQuery, $genre);
    }

    echo json_encode($books);
});

Route::add('/api/genres', function () {
    $bookController = new BookController();
    $genres = $bookController->getGenres();
    echo json_encode($genres);
});