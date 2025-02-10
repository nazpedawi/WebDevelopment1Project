<div class="container mt-5">
    <h2 class="mb-4 text-center text-white">Add New Book</h2>
    <form id="bookForm" action="/book/add" method="POST" enctype="multipart/form-data" onsubmit="return validateGenres()">
        <div class="mb-3">
            <label for="title" class="form-label text-white">Book Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label text-white">Book Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label text-white">Author</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>

        <div class="mb-3">
            <label class="form-label text-white">Genre(s)</label><br>
            <div class="row">
                <?php foreach ($genres as $genre): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <input type="checkbox" name="genre[]" value="<?= htmlspecialchars($genre['id']) ?>" id="<?= strtolower(str_replace(' ', '_', $genre['name'])) ?>">
                        <label class="text-white" for="<?= strtolower(str_replace(' ', '_', $genre['name'])) ?>"><?= htmlspecialchars($genre['name']) ?></label><br>
                    </div>
                <?php endforeach; ?>
            </div>
            <div id="genre-error" style="color: red; display: none;">Please select at least one genre.</div>
        </div>

        <div class="mb-3">
            <label for="publication_year" class="form-label text-white">Publication Year</label>
            <select class="form-control" id="publication_year" name="publication_year" required>
                <?php
                $currentYear = date('Y');
                for ($year = 1900; $year <= $currentYear; $year++) {
                    echo "<option value=\"$year\">$year</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-5">
            <label for="cover_image" class="form-label text-white">Cover Image (only jpg, png, jpeg and webp file types are allowed)</label>
            <input type="file" class="form-control" name="cover_image" accept="image/*" required>
        </div>
        <div class="mb-3 d-flex justify-content-center">
            <button type="submit" class="btn btn-outline-light btn-lg w-50 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 0 8 8A8 8 0 0 0 8 0zm1 4v3h3v1H9v3H8V8H5V7h3V4h1z"/>
                </svg> Add Book
            </button>
        </div>
    </form>
</div>
