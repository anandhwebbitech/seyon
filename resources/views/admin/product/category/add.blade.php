@extends('admin.index')
@section('admin')

@if(session('success'))
    <div id="successAlert" class="alert alert-success">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(function() {
            $('#successAlert').fadeOut('fast');
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>
@endif


<div id="uploadimageModal" class="modal" role="dialog">
<div class="modal-dialog cropimg">
<div class="modal-content">
<div class="modal-body">
    <a href="Javascript:void" class="btn-cropclose" onclick="modalclose();"><img src="https://icones.pro/wp-content/uploads/2022/05/icone-fermer-et-x-rouge.png" width="25px"></a>

<div class="row">
<div class="col-md-12 text-center">
<div id="image_demo" style="width:100%;"></div>
</div>
<input type="hidden" id="idval">
<div class="col-md-12 text-center mb-1">
<button type="button" class="btn btn-success crop_image">Upload</button>
</div>
</div>
</div>
</div>
</div>
</div>


<div class="profile-tab">
    <div class="custom-tab-1">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab" class="nav-link active show">PRODUCT CATEGORY</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="profile-settings" class="tab-pane fade active show">
                <div class="pt-3">
                    <div class="settings-form">
                            <form method="POST" action="{{ route('admin.product.category.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Category</label>
                                        <input type="text" name="name" class="form-control" required placeholder="Enter Category Name">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">
                                            Category Thumbnail Image 
                                            <span class="text-muted">(Size: 300 × 300 px, Max file size: 1 MB)</span>
                                        </label>

                                        <input type="file" name="category_image" class="form-control" id="file2" required />
                                        <div id="uploaded_image2"></div><br>
                                    </div>
                                </div>
                                <!--<div class="row align-items-center">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Icon Image</label>
                                        <input type="file" name="file1" class="form-control image_input" onchange="preview(1)" id="file1" />
                                        <input type="hidden" name="filetext1"  class="form-control" id="profile_images1" placeholder="Image" >
                                        <div id="uploaded_image1"></div><br>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Category Image</label>
                                        <input type="file" name="file2" class="form-control image_input" onchange="preview(2)" id="file2" />
                                        <input type="hidden" name="filetext2"  class="form-control" id="profile_images2" placeholder="Image" >
                                        <div id="uploaded_image2"></div><br>
                                    </div>
                                </div>-->
                                <div class="row align-items-center">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Status</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="active" value="1">
                                            <label class="form-check-label" for="active">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="inactive" value="0">
                                            <label class="form-check-label" for="inactive">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            
                                <button class="btn btn-primary" type="submit">Add category</button>
                            </form>

                    </div>
                </div>
            </div> <br><br><br>
        </div>
    </div>

</div>

@endsection


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>  
$(document).ready(function(){

    $image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:500,
      height:500,
      type:'square' //circle
    },
    boundary:{
      width:550,
      height:530
    }
  });


  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){

    var ID =$("#idval").val();

    $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('crop-image-upload-ajax') }}",
            data: {'_token': $('meta[name="csrf-token"]').attr('content'), 'image': response },
            success: function(data){
                $('#uploadimageModal').modal('hide');
                $('#uploaded_image'+ID).html('<img src="'+data.image_url+'" class="img-thumbnail" width="80px"/>');
                $('#profile_images'+ID).val(data.image_name);
            }
    });
    



    
     
    })
  });

});  


function preview(id)
{
var dc = document.getElementById("file"+id).files;
$("#idval").val(id);
var reader = new FileReader();
reader.onload = function (event) {
$image_crop.croppie('bind', {
url: event.target.result
}).then(function(){
console.log('jQuery bind complete');
});
}
reader.readAsDataURL(dc[0]);
$('#uploadimageModal').modal('show');
}
function modalclose(){
    $('#uploadimageModal').modal('hide');

}
function imagedelete(id,value) {

if(confirm('Are you sure want to delete this image?')) {
$.ajax({
url: "ajax-image-delete.php", 
type: "POST",
data: "product_id="+id+"&imagetype="+value,
success: function(result){

$("#output"+value).html(result);
}}); 
}
}
</script>


<script type="text/javascript">
    
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });

</script>

