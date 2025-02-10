<?php
require_once 'BaseModel.php';
require_once 'dto/ReviewDTO.php';

class ReviewModel extends BaseModel {

    public function getReviewsByBookId(int $bookId) {
        $query = "SELECT r.review_id AS review_id, r.book_id ,r.user_id, r.rating, r.review_text, r.review_date, u.firstName, u.lastName
            FROM Reviews r
            JOIN Users u ON r.user_id = u.user_id
            WHERE r.book_id = :book_id
            ORDER BY r.review_date DESC";
            
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $stmt->execute();

        $reviews = [];
        while ($row = $stmt->fetch()) {
            $review = new ReviewDTO(
                (int) $row['review_id'],
                (int) $row['book_id'],
                (int) $row['user_id'],
                (string) $row['review_text'],
                (int) $row['rating'],
                new DateTime($row['review_date'])
            );

            $review->setUserName((string) $row['firstName'], (string) $row['lastName']);
            

            $reviews[] = $review;
        }

        return $reviews;
    }

    public function insertReview(int $bookId, int $userId, string $reviewText, int $rating) {
        $query = "INSERT INTO Reviews (book_id, user_id, review_text, rating, review_date)
                  VALUES (:bookId, :userId, :reviewText, :rating, NOW())";

        $stmt = self::$pdo->prepare($query);

        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':reviewText', $reviewText, PDO::PARAM_STR);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);

        try {
            $success = $stmt->execute();
            if ($success) {
                return $success;
            } else {
                var_dump($stmt->errorInfo());
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

}