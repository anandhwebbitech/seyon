<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editsubcategoryModalLabel">Edit Blog Sub Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="editSubCategoryForm">
                <input type="hidden" name="id" value="{{ $category->id }}"> 
                
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="default-select form-control wide" id="category" name="category_id">
                        @php $categories = App\Models\BlogCategory::get(); @endphp
                        @if($categories)
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @if($cat->id == $category->category_id) selected @endif>{{ $cat->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="editName" class="form-label">Sub Category</label>
                    <input type="text" class="form-control" id="editName" name="name" value="{{ $category->name }}">
                </div>
                @csrf
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="saveEditedSubCategory">Save</button>
        </div>
    </div>
</div>