const basePath = "/assets/images/";

// Fetch and display books based on the search query and selected genre
async function fetchAndDisplayBooks(searchQuery = "", genre = "") {
  try {
    const queryParams = new URLSearchParams();
    if (searchQuery) queryParams.append("search", searchQuery);
    if (genre) queryParams.append("genre", genre);

    // Fetch books with query parameters
    const response = await fetch(`/api/books?${queryParams.toString()}`);

    const books = await response.json();
    const booksContainer = document.getElementById("books-container");
    booksContainer.innerHTML = "";

    if (books.length === 0) {
      booksContainer.innerHTML = `
        <div class="text-center text-white fw-bold display-6 p-4"> No Books Found With Title "${searchQuery}" and Genre "${genre}"</div>
      `;
      return;
    }

    // Display books
    books.forEach((book) => {
      const bookCard = document.createElement("div");
      bookCard.className =
        "col-lg-3 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch";

      bookCard.innerHTML = `
        <a href="/book/${
          book.id
        }" class="card-link text-decoration-none w-100" title="View details for ${
        book.title
      }">
          <div class="card custom-card border-primary">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title text-center book-title">${book.title}</h5>
              <div class="image-container d-block mx-auto">
                <div class="image-wrapper">
                  <img src="${basePath + book.cover_image}" alt="${
        book.title
      }" class="card-img-top img-fluid book-cover">
                </div>
              </div>
              <p class="card-text">${book.description.replace(
                /\n/g,
                "<br>"
              )}</p>
              <div class="mt-auto">
                <p class="card-text"><strong>Author</strong>: ${book.author}</p>
                <p class="card-text"><strong>Genre(s)</strong>: ${book.genres.join(
                  ", "
                )}</p>
                <p class="card-text"><strong>Publication Year</strong>: ${
                  book.publication_year
                }</p>
              </div>
            </div>
          </div>
        </a>
      `;
      booksContainer.appendChild(bookCard);
    });
  } catch (error) {
    console.error("Error fetching books:", error);
    const booksContainer = document.getElementById("books-container");
    booksContainer.innerHTML =
      '<div class="alert alert-danger">Failed to load books. Please try again later.</div>';
  }
}

// Populate genres dropdown dynamically
async function populateGenresDropdown() {
  const genreSelect = document.getElementById("genreSelect");

  try {
    const response = await fetch("/api/genres");
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const genres = await response.json();

    // Populate the genre dropdown
    genreSelect.innerHTML = `<option value="">All Genres</option>`;
    genres.forEach((genre) => {
      const option = document.createElement("option");
      option.value = genre.name;
      option.textContent = genre.name;
      genreSelect.appendChild(option);
    });
  } catch (error) {
    console.error("Error fetching genres:", error);
    genreSelect.innerHTML = `<option value="">Error loading genres</option>`;
  }
}

// Event listener for the search input field
document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("searchInput");
  const genreSelect = document.getElementById("genreSelect");

  // Populate genres dropdown on page load
  populateGenresDropdown();

  // Debounced function to handle search input
  let debounceTimeout;
  searchInput.addEventListener("input", function (event) {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
      const searchQuery = event.target.value.trim();
      const genre = genreSelect.value.trim();
      fetchAndDisplayBooks(searchQuery, genre);
    }, 200);
  });

  // Event listener for genre change
  genreSelect.addEventListener("change", function (event) {
    const genre = event.target.value.trim();
    const searchQuery = searchInput.value.trim();
    fetchAndDisplayBooks(searchQuery, genre);
  });

  fetchAndDisplayBooks();
});
