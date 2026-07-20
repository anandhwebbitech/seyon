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


<style>
    .img-postion{
        position:relative;
        display:inline-block;
    }
    .delete-icon{
        position:absolute;
        top:-7px;
        right:-7px;
        font-size:20px;
        
    }
     .delete-icon a{
         color:red;
     }
</style>





<div class="profile-tab">
    <div class="custom-tab-1">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab" class="nav-link active show">PRODUCT COUPON CODE</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="profile-settings" class="tab-pane fade active show">
                <div class="pt-3">
                    <div class="settings-form">
                            <form method="POST" action="{{ route('admin.product.coupon_code.update') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="coupon_id" class="form-control" value="{{ $coupon_code->id }}">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Code</label>
                                        <input type="text" name="code" class="form-control" value="{{ $coupon_code->code }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Percentage</label>
                                        <input type="text" name="percentage" class="form-control" value="{{ $coupon_code->percentage }}">
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Status</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="active" value="1" {{ $coupon_code->status == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="active">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="inactive" value="0" {{ $coupon_code->status == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inactive">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            
                                <button class="btn btn-primary" type="submit">Update</button>
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

