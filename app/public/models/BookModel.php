<?php
require_once 'BaseModel.php';
require_once 'dto/BookDTO.php';

class BookModel extends BaseModel {

    public function getAllBooks() {
        $query = "SELECT b.book_id, b.title, b.description, b.author, b.publication_year, b.cover_image, 
                         GROUP_CONCAT(g.name) AS genres
                  FROM Books b
                  LEFT JOIN book_genres bg ON b.book_id = bg.book_id
                  LEFT JOIN Genres g ON bg.genre_id = g.genre_id
                  GROUP BY b.book_id";
    
        $stmt = self::$pdo->prepare($query);
        $stmt->execute();
    
        $books = [];
        while ($row = $stmt->fetch()) {
            $genres = explode(',', $row['genres']);
    
            $book = new BookDTO(
                (int) $row['book_id'],
                (string) $row['title'],
                (string) $row['description'],
                (string) $row['author'],
                $genres,  // Pass the genres array
                (int) $row['publication_year'],
                (string) $row['cover_image']
            );
    
            $books[] = $book;
        }
    
        return $books;
    }

    public function getFilteredBooks($searchQuery = '', $genre = '') {
        $query = "SELECT b.book_id, b.title, b.description, b.author, b.publication_year, b.cover_image, 
                         GROUP_CONCAT(g.name) AS genres
                  FROM Books b
                  LEFT JOIN book_genres bg ON b.book_id = bg.book_id
                  LEFT JOIN Genres g ON bg.genre_id = g.genre_id";
    
        $params = [];
        $filters = [];
    
        // Add filters dynamically
        if (!empty($searchQuery)) {
            $filters[] = "b.title LIKE :searchQuery";
            $params[':searchQuery'] = '%' . $searchQuery . '%';
        }
    
        if (!empty($genre)) {
            $filters[] = "g.name = :genre";
            $params[':genre'] = $genre;
        }
    
        // Append filters to the query
        if (!empty($filters)) {
            $query .= " WHERE " . implode(" AND ", $filters);
        }
    
        $query .= " GROUP BY b.book_id";
    
        $stmt = self::$pdo->prepare($query);
    
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
    
        $stmt->execute();
    
        $books = [];
        while ($row = $stmt->fetch()) {
            $genres = explode(',', $row['genres']);
    
            $books[] = new BookDTO(
                (int) $row['book_id'],
                (string) $row['title'],
                (string) $row['description'],
                (string) $row['author'],
                $genres,
                (int) $row['publication_year'],
                (string) $row['cover_image']
            );
        }
    
        return $books;
    }
    
    public function getBookById(int $id) {
        $query = "SELECT b.book_id, b.title, b.description, b.author, b.publication_year, b.cover_image, 
                         GROUP_CONCAT(g.name) AS genres
                  FROM Books b
                  LEFT JOIN book_genres bg ON b.book_id = bg.book_id
                  LEFT JOIN Genres g ON bg.genre_id = g.genre_id
                  WHERE b.book_id = :id
                  GROUP BY b.book_id";
    
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        $row = $stmt->fetch();
        if ($row) {
            $genres = explode(',', $row['genres']);
    
            $book = new BookDTO(
                (int) $row['book_id'],
                (string) $row['title'],
                (string) $row['description'],
                (string) $row['author'],
                $genres,  // Pass the genres array
                (int) $row['publication_year'],
                (string) $row['cover_image']
            );
    
            return $book;
        }
    
        return null;
    }
    

    public function insertBook($title, $description, $author, $genres, $publication_year, $cover_image_path) {
        
        $query = "INSERT INTO Books (title, description, author, publication_year, cover_image)
                  VALUES (:title, :description, :author, :publication_year, :cover_image)";
        
        $stmt = self::$pdo->prepare($query);
    
        $book = new BookDTO(0, $title, $description, $author, $genres, $publication_year, $cover_image_path);
        
        $titleValue = $book->getTitle();
        $descriptionValue = $book->getDescription();
        $authorValue = $book->getAuthor();
        $publicationYearValue = $book->getPublicationYear();
        $coverImageValue = $book->getCoverImage();
        
        $stmt->bindParam(':title', $titleValue);
        $stmt->bindParam(':description', $descriptionValue);
        $stmt->bindParam(':author', $authorValue);
        $stmt->bindParam(':publication_year', $publicationYearValue);
        $stmt->bindParam(':cover_image', $coverImageValue);
        
        try {
            $success = $stmt->execute();
            if ($success) {
                $bookId = self::$pdo->lastInsertId();
    
                foreach ($genres as $genreId) {
                    $query = "INSERT INTO book_genres (book_id, genre_id) VALUES (:book_id, :genre_id)";
                    $stmt = self::$pdo->prepare($query);
                    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
                    $stmt->bindParam(':genre_id', $genreId, PDO::PARAM_INT);
                    $stmt->execute();
                }
    
                return $success;
            } else {
                var_dump($stmt->errorInfo());
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function insertBookGenres($bookId, $genres) {
        foreach ($genres as $genreId) {
            $query = "INSERT INTO book_genres (book_id, genre_id) VALUES (:book_id, :genre_id)";
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $stmt->bindParam(':genre_id', $genreId, PDO::PARAM_INT);
            $stmt->execute();
        }
    
        return true;
    }
    


private function getGenreIdByName($genreName)
{
    $query = "SELECT genre_id FROM Genres WHERE name = :genre_name";
    $stmt = self::$pdo->prepare($query);
    $stmt->bindParam(':genre_name', $genreName, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch();
    return $row ? $row['genre_id'] : null;
}
    
public function getGenres()
{
    $query = "SELECT genre_id, name FROM Genres";
    $stmt = self::$pdo->prepare($query);
    $stmt->execute();

    $genres = [];
    while ($row = $stmt->fetch()) {
        $genres[] = [
            'id' => $row['genre_id'],
            'name' => $row['name']
        ];
    }

    return $genres;
}


public function deleteBook($bookId) {
    $stmt = self::$pdo->prepare("DELETE FROM Books WHERE book_id = :book_id");
    $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);

    return $stmt->execute();
}
public function updateBook(int $id, string $title, string $description, string $author, int $publication_year, string $cover_image)
{
    $query = "UPDATE Books
              SET title = :title,
                  description = :description,
                  author = :author,
                  publication_year = :publication_year,
                  cover_image = :cover_image
              WHERE book_id = :id";

    $stmt = self::$pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':author', $author, PDO::PARAM_STR);
    $stmt->bindParam(':publication_year', $publication_year, PDO::PARAM_INT);
    $stmt->bindParam(':cover_image', $cover_image, PDO::PARAM_STR);

    try {
        return $stmt->execute();
    } catch (Exception $e) {
        echo "Error updating book: " . $e->getMessage();
        return false;
    }
}
public function updateBookGenres(int $bookId, array $genres)
{
    try {
        $deleteQuery = "DELETE FROM book_genres WHERE book_id = :book_id";
        $deleteStmt = self::$pdo->prepare($deleteQuery);
        $deleteStmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $deleteStmt->execute();

        return $this->insertBookGenres($bookId, $genres);
        
    } catch (Exception $e) {
        echo "Error updating book genres: " . $e->getMessage();
        return false;
    }
}
}
