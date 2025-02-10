<?php

require_once(__DIR__ . "/../models/ReviewModel.php");
require_once(__DIR__ . "/../dto/ReviewDTO.php");

class ReviewController
{
    private ReviewModel $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
    }

    public function getByBookId(int $bookId): array
    {
        return $this->reviewModel->getReviewsByBookId($bookId);
    }

    public function insert()
    {
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
                $bookId = (int) htmlspecialchars($_POST['book_id']);
                $reviewText = htmlspecialchars($_POST['review_text']);
                $rating = (int) htmlspecialchars($_POST['rating']);

                
                $review = new ReviewDTO(0, $bookId, $userId, $reviewText, $rating, new DateTime());

            
                if ($this->reviewModel->insertReview(
                    $review->getBookId(),
                    $review->getUserId(),
                    $review->getReviewText(),
                    $review->getRating()
                )) {
                    header("Location: /book/{$bookId}");
                    exit;
                } else {
                    echo "Error adding review.";
                }
            }
        } else {
            echo "User is not logged in.";
        }
    }
}
