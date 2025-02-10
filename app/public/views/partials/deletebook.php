<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteModalLabel">Delete Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0">
                <p>Are you sure you want to delete this book?</p>
            </div>
            <div class="modal-footer border-0">
        <form id="deleteForm" action="/deletebook" method="POST">
          <input type="hidden" name="book_id" id="bookIdToDelete" value="">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger btn-delete">Delete</button>
        </form>
      </div>

        </div>
    </div>
</div>
