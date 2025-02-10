document.addEventListener("DOMContentLoaded", function () {
  // Star Rating functionality
  const stars = document.querySelectorAll(".star-rating .star");
  const ratingInput = document.getElementById("rating");
  const ratingError = document.getElementById("rating-error");

  stars.forEach(function (star) {
    star.addEventListener("mouseover", function () {
      const value = star.getAttribute("data-value");
      highlightStars(value);
    });

    star.addEventListener("mouseout", function () {
      const value = ratingInput.value;
      highlightStars(value);
    });

    star.addEventListener("click", function () {
      const value = star.getAttribute("data-value");
      ratingInput.value = value;
      highlightStars(value);
      ratingError.style.display = "none";
    });
  });

  function highlightStars(value) {
    stars.forEach(function (star) {
      if (star.getAttribute("data-value") <= value) {
        star.classList.add("filled");
      } else {
        star.classList.remove("filled");
      }
    });
  }

  // Delete Book functionality
  const deleteButtons = document.querySelectorAll(
    '[data-bs-toggle="modal"][data-bs-target="#deleteModal"]'
  );

  deleteButtons.forEach(function (deleteButton) {
    deleteButton.addEventListener("click", function () {
      const bookId = this.getAttribute("data-book-id");
      document.getElementById("bookIdToDelete").value = bookId;
    });
  });

  const deleteForm = document.getElementById("deleteForm");
  if (deleteForm) {
    deleteForm.addEventListener("submit", function (event) {
      const bookId = document.getElementById("bookIdToDelete").value;
      if (!bookId) {
        console.error("Invalid book ID");
        event.preventDefault();
      } else {
        console.log("Deleting book with ID:", bookId);
        deleteForm.submit();
      }
    });
  }

  // Function to validate genres (for the book form)
  function validateGenres() {
    const genres = document.querySelectorAll('input[name="genre[]"]');
    const genreError = document.getElementById("genre-error");
    let genreSelected = false;

    // Check if any genre is selected
    genres.forEach(function (genre) {
      if (genre.checked) {
        genreSelected = true;
      }
    });

    if (!genreSelected) {
      genreError.style.display = "inline"; // Show genre error
      return false; // Prevent form submission
    } else {
      genreError.style.display = "none"; // Hide genre error if a genre is selected
    }

    return true; // Allow form submission
  }

  // Function to validate rating (for the review form)
  function validateRating() {
    const ratingInput = document.getElementById("rating");
    const ratingError = document.getElementById("rating-error");

    // Check if rating is selected
    if (!ratingInput.value) {
      ratingError.style.display = "inline"; // Show rating error
      return false; // Prevent form submission
    } else {
      ratingError.style.display = "none"; // Hide rating error if rating is selected
    }

    return true; // Allow form submission
  }

  // Validate the book form
  const bookForm = document.getElementById("bookForm");
  if (bookForm) {
    bookForm.addEventListener("submit", function (event) {
      if (!validateGenres()) {
        event.preventDefault(); // Prevent form submission if genre validation fails
      }
    });
  }

  // Validate the review form
  const reviewForm = document.getElementById("reviewForm");
  if (reviewForm) {
    reviewForm.addEventListener("submit", function (event) {
      if (!validateRating()) {
        event.preventDefault(); // Prevent form submission if rating validation fails
      }
    });
  }
});
