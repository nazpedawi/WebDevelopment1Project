<?php $basePath = '/assets/images/'; ?>
<div class="container my-5">
    <div class="card mb-3 book-card">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="<?= $book->getCoverImage() ? htmlspecialchars($basePath . $book->getCoverImage()) : '/assets/images/default-book.jpg'; ?>" 
                     alt="<?= htmlspecialchars($book->getTitle()); ?>" 
                     class="img-fluid cover-image">
            </div>
            <div class="col-md-8">
                <div class="card-body d-flex flex-column" style="height: 100%;">
                    <div>
                        <h3 class="card-title"><?= htmlspecialchars($book->getTitle()); ?></h3>
                        <p class="card-text"><?= nl2br(htmlspecialchars($book->getDescription())); ?></p>
                        <p class="card-text"><strong>Author:</strong> <?= htmlspecialchars($book->getAuthor()); ?></p>
                        <p class="card-text"><strong>Genre(s):</strong> <?= htmlspecialchars(implode(', ', $book->getGenres())); ?></p>
                        <p class="card-text"><strong>Publication Year:</strong> <?= htmlspecialchars($book->getPublicationYear()); ?></p>
                    </div>

                    <div class="mt-auto">
                        <!-- Show Edit and Delete Buttons Only to Admin -->
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'Admin'): ?>
                            <div class="card-footer d-flex flex-column flex-md-row justify-content-between">
                                <a href="/editbook/<?= $book->getId(); ?>" class="btn btn-outline-light btn-lg mb-2 mb-md-0 w-100 w-md-50 me-md-2">
                                    Edit
                                </a>
            
                                <button type="button" class="btn btn-outline-danger btn-lg w-100" data-bs-toggle="modal" data-bs-target="#deleteModal" data-book-id="<?= $book->getId(); ?>">
                                  Delete
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add a Review Form -->
    <div class="add-review-form mt-5 text-white p-4">
        <h3>Write a Review</h3>
        <?php if (isset($_SESSION['user'])): ?>
        <form id="reviewForm" method="POST" action="/addreview" onsubmit="return validateRating()">
            <input type="hidden" name="book_id" value="<?= $book->getId(); ?>">

            <div class="form-group">
                <label for="rating">Rating</label>
                <div class="star-rating">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                    <input type="hidden" name="rating" id="rating" value="">
                </div>
                <div id="rating-error" style="color: red; display: none;">Please select a rating from 1 to 5.</div>
            </div>

    
            <div class="form-group">
                <label for="review_text"></label>
                <textarea class="form-control" name="review_text" id="review_text" rows="4" placeholder="Write your thoughts here..." required></textarea>
            </div>

        
            <button type="submit" class="btn btn-outline-light btn-lg w-100 mt-3">Submit Review</button>
        </form>
        <?php else: ?>
            <p class="text-center font-weight-bold">Login first to write a review.</p>
        <?php endif; ?>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section mt-5 text-white">
        <h3>Reviews</h3>
        <?php if (!empty($reviews)): ?>
            <ul class="list-group">
                <?php foreach ($reviews as $review): ?>
                    <li class="list-group-item review-card">
                        <div class="d-flex justify-content-between align-items-center review-header">
                        
                            <div class="d-flex align-items-center">
                                <strong><?= htmlspecialchars($review->getUserFirstName()) . ' ' . htmlspecialchars($review->getUserLastName()); ?></strong>
                            </div>
                            
                            <small class="review-date">
                                <?= $review->getReviewDate()->format('d/m/Y H:i'); ?>
                            </small>
                        </div>
                        <div class="stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star <?= $i <= $review->getRating() ? 'filled' : ''; ?>">&#9733;</span>
                            <?php endfor; ?>
                        </div>
                        <p class="card-text"><?= nl2br(htmlspecialchars($review->getReviewText())); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-center mt-3">No reviews yet. Be the first to review this book!</p>
        <?php endif; ?>
    </div>
</div>
