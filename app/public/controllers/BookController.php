<?php

require_once(__DIR__ . "/../models/BookModel.php");
require_once(__DIR__ . "/../dto/BookDTO.php");

class BookController
{
    private BookModel $bookModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
    }

    public function getAll(): array
    {
        return $this->bookModel->getAllBooks();
    }

    public function getFilteredBooks($searchQuery, $genre)
    {
        return $this->bookModel->getFilteredBooks($searchQuery, $genre);
    }

    public function get(int $id): ?BookDTO
    {
        return $this->bookModel->getBookById($id);
    }

    public function getGenres()
    {
        return $this->bookModel->getGenres();
    }
    
    public function insert()
    {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize input fields
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $author = htmlspecialchars($_POST['author']);
        
        // Ensure genres are selected
        $genres = isset($_POST['genre']) ? $_POST['genre'] : [];
        $publication_year = (int) $_POST['publication_year'];

        $cover_image_path = null;

        // Handle cover image upload
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
            $uploadDir = __DIR__ . '/../assets/images/';
            $fileName = basename($_FILES['cover_image']['name']);
            $uploadFile = $uploadDir . $fileName;
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

            $allowedTypes = ['jpg', 'png', 'jpeg', 'webp'];
            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadFile)) {
                    $cover_image_path = $fileName;
                } else {
                    echo "Error uploading the cover image.";
                    return;
                }
            } else {
                echo "Invalid file type. Only JPG, JPEG, PNG, WEBP are allowed.";
                return;
            }
        }

        $book = new BookDTO(0, $title, $description, $author, [], $publication_year, $cover_image_path);

        if ($this->bookModel->insertBook(
            $book->getTitle(),
            $book->getDescription(),
            $book->getAuthor(),
            $book->getGenres(),
            $book->getPublicationYear(),
            $book->getCoverImage()
        )) {
        
            $bookId = BaseModel::getLastInsertId();

            if ($this->bookModel->insertBookGenres($bookId, $genres)) {
                header("Location: /");
                exit;
            } else {
                echo "Error adding genres.";
            }
        } else {
            echo "Error adding book.";
        }
    }
}


public function delete() {
    if (isset($_POST['book_id']) && is_numeric($_POST['book_id'])) {
        $bookId = $_POST['book_id'];

        $result = $this->bookModel->deleteBook($bookId);

        if ($result) {
            header("Location: /");
            exit();
        } else {
            echo "Error deleting the book.";
        }
    } else {
        echo "Invalid book ID.";
    }
}

public function edit()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bookId = (int) $_POST['book_id'];

        // Fetch the current book
        $currentBook = $this->get($bookId);
        if (!$currentBook) {
            echo "Book not found.";
            return;
        }

        // Sanitize and update fields
        $currentBook->setTitle(htmlspecialchars($_POST['title']));
        $currentBook->setDescription(htmlspecialchars($_POST['description']));
        $currentBook->setAuthor(htmlspecialchars($_POST['author']));
        $currentBook->setGenres(isset($_POST['genre']) ? $_POST['genre'] : []);
        $currentBook->setPublicationYear((int)$_POST['publication_year']);

        // Handle cover image upload
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
            $uploadDir = __DIR__ . '/../assets/images/';
            $fileName = basename($_FILES['cover_image']['name']);
            $uploadFile = $uploadDir . $fileName;
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

            $allowedTypes = ['jpg', 'png', 'jpeg', 'webp'];
            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $uploadFile)) {
                    $currentBook->setCoverImage($fileName); // Use setter to update cover image
                } else {
                    echo "Error uploading the cover image.";
                    return;
                }
            } else {
                echo "Invalid file type. Only JPG, JPEG, PNG, WEBP are allowed.";
                return;
            }
        }

        // Update the book in the database
        if ($this->bookModel->updateBook(
            $currentBook->getId(),
            $currentBook->getTitle(),
            $currentBook->getDescription(),
            $currentBook->getAuthor(),
            $currentBook->getPublicationYear(),
            $currentBook->getCoverImage()
        )) {
            // Update genres in the book_genres table
            if ($this->bookModel->updateBookGenres($currentBook->getId(), $currentBook->getGenres())) {
                header("Location: /");
                exit;
            } else {
                echo "Error updating genres.";
            }
        } else {
            echo "Error updating book.";
        }
    }
}


}