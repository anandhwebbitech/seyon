<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editCategoryModalLabel">Edit Blog Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="editCategoryForm">
                <input type="hidden" name="id" value="{{ $category->id }}"> <!-- Hidden input to store category ID -->
                <div class="mb-3">
                    <label for="editName" class="form-label">Category</label>
                    <input type="text" class="form-control" id="editName" name="name" value="{{ $category->name }}">
                </div>
                @csrf
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="saveEditedCategory">Save</button>
        </div>
    </div>
</div>