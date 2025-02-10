<div class="container mt-5">
    <h2 class="mb-4 text-center text-white">Edit Book</h2>
    <form id="bookForm" action="/editbook/<?= htmlspecialchars($book->getId()) ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
    <input type="hidden" name="book_id" value="<?= htmlspecialchars($book->getId()) ?>">
    <div class="mb-3">
            <label for="title" class="form-label text-white">Book Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($book->getTitle()) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label text-white">Book Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($book->getDescription()) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label text-white">Author</label>
            <input type="text" class="form-control" id="author" name="author" value="<?= htmlspecialchars($book->getAuthor()) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label text-white">Genre(s)</label><br>
            <div class="row">
                <?php
                foreach ($genres as $genre) {
                    $checked = in_array($genre['name'], $book->getGenres()) ? 'checked' : '';
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <input type="checkbox" name="genre[]" value="<?= htmlspecialchars($genre['id']) ?>" id="<?= strtolower(str_replace(' ', '_', $genre['name'])) ?>" <?= $checked ?>>
                        <label class="text-white" for="<?= strtolower(str_replace(' ', '_', $genre['name'])) ?>"><?= htmlspecialchars($genre['name']) ?></label><br>
                    </div>
                <?php
                }
                ?>
        <div id="genre-error" style="color: red; display: none;">Please select at least one genre.</div>
        </div>

        <div class="mb-3">
            <label for="publication_year" class="form-label text-white">Publication Year</label>
            <select class="form-control" id="publication_year" name="publication_year" required>
                <?php
                $currentYear = date('Y');
                for ($year = 1900; $year <= $currentYear; $year++) {
                    $selected = ($year == $book->getPublicationYear()) ? 'selected' : '';
                    echo "<option value=\"$year\" $selected>$year</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-5">
            <label for="cover_image" class="form-label text-white">Cover Image (only jpg, png, jpeg and webp file types are allowed)</label>
            <input type="file" class="form-control" name="cover_image" accept="image/*">
            <small class="text-white">Leave blank to keep the current image.</small>
        </div>

        <div class="mb-3 d-flex justify-content-center">
            <button type="submit" class="btn btn-outline-light btn-lg w-50 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                    <path d="M12.146.854a2 2 0 0 1 2.828 2.828l-9 9a2 2 0 0 1-.707.392l-3.5 1.4a1 1 0 0 1-1.278-1.277l1.4-3.5a2 2 0 0 1 .392-.707l9-9a2 2 0 0 1 2.828 0z"/>
                </svg> Update Book
            </button>
        </div>
    </form>
</div>
