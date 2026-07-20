@extends('admin.index')
@section('admin')
<link href="vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

<style>
     thead th{
         font-family: 'Open Sans', sans-serif !important; 
    }
</style>



<div class="card-header">
    <h4 class="card-title">All Category</h4>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
  Add Category
</button>

</div>

<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="categoryModalLabel">Add Blog Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="categoryForm">
          <div class="mb-3">
            <label for="name" class="form-label">Category</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          @csrf
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveCategory">Save</button>
      </div>
    </div>
  </div>
</div>



@if(session('danger'))
    <div id="successAlert" class="alert alert-danger">
        {{ session('danger') }}
    </div>

    <script>
        setTimeout(function() {
            $('#successAlert').fadeOut('fast');
        }, 3000); 
    </script>
@endif



<div class="card-body">
    <div class="table-responsive" style="overflow-x:inherit;">
        <table id="example4" class="display table table-bordered verticle-middle table-striped table-responsive-sm" style="min-width: 845px">
            <thead class="thead-success">
                <tr>
                    <th>S.No</th>
                    <th>NAME</th>
                    <th style="width:20%">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach($category as $key => $item)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $item->name }}</td>
                    
                    <td>
						<div class="d-flex">
                            <a href="{{ route('blog.category.delete',$item->id) }}" class="btn btn-danger shadow btn-xs sharp me-2"><i class="fa fa-trash"></i></a>
                            <button class="btn btn-primary shadow btn-xs sharp editCategory" data-id="{{ $item->id }}"><i class="fas fa-pencil-alt"></i></button>
						</div>
					</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <!-- Modal content for editing category -->
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="vendor/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="js/plugins-init/sweetalert.init.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<script>
  $(document).ready(function() {
    function saveCategory() {
      var formData = $('#categoryForm').serialize();

      $.ajax({
        url: '{{ route("admin.blog.category.add") }}',
        type: 'POST',
        data: formData,
        success: function(response) {
          console.log(response);
          $('#categoryModal').modal('hide');
          window.location.reload();
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    }

    $('#saveCategory').click(function() {
      saveCategory();
    });
  });
</script>


<script>
$(document).ready(function() {
  $('a.btn-danger').click(function(event) {
    event.preventDefault(); 
    
    var deleteUrl = $(this).attr('href'); 
    
    Swal.fire({
      title: 'Are you sure?',
      text: "It will be permanently deleted!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = deleteUrl; 
      } else {
        
      }
    });
  });
});
</script>


<script>
$(document).ready(function() {
$('.editCategory').click(function() {
    var categoryId = $(this).data('id');
    console.log('Category ID:', categoryId); 
    $.ajax({
        url: '{{ url("/blog-category-edit/") }}/' + categoryId,
        type: 'GET',
        success: function(response) {
            $('#editCategoryModal').html(response);
            $('#editCategoryModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

$(document).on('click', '#saveEditedCategory', function() {
        console.log('Save button clicked'); 
        var formData = $('#editCategoryForm').serialize();
        console.log('Form data:', formData); 
        $.ajax({
            url: '{{ route("admin.blog.category.update") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
                $('#editCategoryModal').modal('hide');
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    
    
});
</script>


@endsection