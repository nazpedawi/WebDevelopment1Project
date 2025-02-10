<?php

class ReviewDTO {
    private int $id;
    private int $bookId;
    private int $userId;
    private string $reviewText;
    private int $rating;
    private DateTime $reviewDate;
    private string $userFirstName;
    private string $userLastName;

    public function __construct(
        int $id,
        int $bookId,
        int $userId,
        string $reviewText,
        int $rating,
        DateTime $reviewDate
    ) {
        $this->id = $id;
        $this->bookId = $bookId;
        $this->userId = $userId;
        $this->reviewText = $reviewText;
        $this->rating = $rating;
        $this->reviewDate = $reviewDate;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getBookId(): int {
        return $this->bookId;
    }

    public function setBookId(int $bookId): void {
        $this->bookId = $bookId;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function setUserId(int $userId): void {
        $this->userId = $userId;
    }

    public function getReviewText(): string {
        return $this->reviewText;
    }

    public function setReviewText(string $reviewText): void {
        $this->reviewText = $reviewText;
    }

    public function getRating(): int {
        return $this->rating;
    }

    public function setRating(int $rating): void {
        $this->rating = $rating;
    }

    public function getReviewDate(): DateTime {
        return $this->reviewDate;
    }

    public function setReviewDate(DateTime $reviewDate): void {
        $this->reviewDate = $reviewDate;
    }

    public function setUserName(string $firstName, string $lastName): void {
        $this->userFirstName = $firstName;
        $this->userLastName = $lastName;
    }

    public function getUserFirstName(): string { return $this->userFirstName; }
    public function getUserLastName(): string { return $this->userLastName; }
}
