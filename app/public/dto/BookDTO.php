<?php

class BookDTO implements \JsonSerializable {
    private int $id;
    private string $title;
    private string $description;
    private string $author;
    private array $genres;
    private int $publication_year;
    private string $cover_image;

    public function __construct(
        int $id,
        string $title,
        string $description,
        string $author,
        array $genres, 
        int $publication_year,
        string $cover_image
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->author = $author;
        $this->genres = $genres;  
        $this->publication_year = $publication_year;
        $this->cover_image = $cover_image;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function setAuthor(string $author): void {
        $this->author = $author;
    }

    public function getGenres(): array {
        return $this->genres; 
    }

    public function setGenres(array $genres): void {
        $this->genres = $genres; 
    }

    public function getPublicationYear(): int {
        return $this->publication_year;
    }

    public function setPublicationYear(int $publication_year): void {
        $this->publication_year = $publication_year;
    }

    public function getCoverImage(): string {
        return $this->cover_image;
    }

    public function setCoverImage(string $cover_image): void {
        $this->cover_image = $cover_image;
    }

    public function jsonSerialize() : mixed{
        $vars = get_object_vars($this);
        return $vars;
    }
}
