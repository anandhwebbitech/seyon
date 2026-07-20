<style>
    .img-container {
        width: 300px;
        height: 300px;
        margin: 0 auto;
    }

    .img-container img {
        width: 100%;
        height: 100%;
        aspect-ratio: 3/2
    }


    /* Sidebar Container */
    .mt-44 {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin: 10px 0;
    }

    /* User Info Section */
    .user-name {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }

    .user-email {
        font-size: 14px;
        color: #666;
        margin-bottom: 0;
    }

    /* Navigation Pills */
    .nav-pills {
        gap: 8px;
    }

    .nav-pills .nav-link {
        color: #555;
        padding: 12px 16px;
        border-radius: 6px;
        font-size: 15px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .nav-pills .nav-link i {
        font-size: 18px;
    }

    /* Hover State */
    .nav-pills .nav-link:hover {
        background-color: #f8f9fa;
        color: #d32f2f;
        border-color: #f0f0f0;
        transform: translateX(5px);
    }

    /* Active State - Red Theme */
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%);
        color: #fff;
        box-shadow: 0 4px 12px rgba(211, 47, 47, 0.3);
    }

    .nav-pills .nav-link.active i {
        color: #fff;
    }

    /* Logout Link - Special Styling */
    .nav-pills .nav-link:last-child {
        color: #d32f2f;
        margin-top: 10px;
        border-top: 1px solid #eee;
        padding-top: 20px;
    }

    .nav-pills .nav-link:last-child:hover {
        background-color: #ffebee;
        color: #b71c1c;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .nav-pills .nav-link {
            font-size: 14px;
            padding: 10px 14px;
        }
    }
</style>


<div class="col-lg-3 col-md-4">
    <div class="profile-left">
        {{-- <div class="profile-cover"></div>
        <link href="https://fengyuanchen.github.io/cropperjs/css/cropper.css" rel="stylesheet" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <form method="post" action="{{ route('update.profile.image') }}" enctype="multipart/form-data">
            @csrf
            <div class="preview">
                @if (!empty(auth()->user()->image_name))
                    <img id="profile-img" src="{{ url('public/profile_images/' . auth()->user()->image_name) }}" />
                @else
                    <img id="profile-img"
                        src="https://st3.depositphotos.com/11433294/i/600/depositphotos_142980917-stock-photo-stylish-handsome-man.jpg" />
                @endif
                <label for="file-input"><i class="bi bi-pencil"></i></label>
                <input type="file" class="d-none" id="file-input" name="image" accept="image/*" />


            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-success">Update</button>
            </div> --}}
        </form>








        <!-- <img class="rounded" id="profile-img" src="https://avatars0.githubusercontent.com/u/3456749?s=160" alt="avatar">
            
              <label class="label custom-file-upload btn btn-primary ml-3" data-toggle="tooltip" title="Change your avatar">
                <input type="file" class="d-none" id="file-input" name="image" accept="image/*">
                Upload Avatar
              </label>-->


        {{-- <div class="modal fade" id="cropAvatarmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Crop the image</h5>
                    <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="img-container">
                      <img id="uploadedAvatar" src="https://avatars0.githubusercontent.com/u/3456749">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
                  </div>
                </div>
              </div>
            </div> --}}






        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/jquery@3/dist/jquery.min.js"></script>
        <script src="https://fengyuanchen.github.io/cropperjs/js/cropper.js"></script>
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                var avatar = document.getElementById('profile-img');
                var image = document.getElementById('uploadedAvatar');
                var input = document.getElementById('file-input');
                var cropBtn = document.getElementById('crop');

                var $modal = $('#cropAvatarmodal');
                var cropper;

                $('[data-toggle="tooltip"]').tooltip();

                input.addEventListener('change', function(e) {
                    var files = e.target.files;
                    var done = function(url) {

                        console.log(input.value)
                        image.src = url;
                        $modal.modal('show');
                    };

                    if (files && files.length > 0) {
                        let file = files[0];

                        reader = new FileReader();
                        reader.onload = function(e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);

                    }
                });




                $modal.on('shown.bs.modal', function() {
                    cropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 1,
                    });
                }).on('hidden.bs.modal', function() {
                    cropper.destroy();
                    cropper = null;
                });

                cropBtn.addEventListener('click', function() {
                    // var initialAvatarURL;
                    var canvas;

                    $modal.modal('hide');

                    if (cropper) {
                        canvas = cropper.getCroppedCanvas({
                            width: 300,
                            height: 300,
                        });
                        avatar.src = canvas.toDataURL();
                    }
                });

            });
        </script>

        <div class="mt-44">
            <h5 class="user-name">{{ auth()->user()->name }}</h5>
            <p class="user-email">{{ auth()->user()->email }}</p>
        </div>
        <div class="align-items-start mt-44">
            <div class="nav flex-column nav-pills ">
                <a href="{{ route('user.dashboard') }}" class="nav-link @if(request()->is('user/dashboard')) active @endif"><i class="bi bi-person"></i>My
                    Profile</a>
                <a href="{{ route('user.order.history') }}" class="nav-link @if(request()->is('user/order-history')) active @endif"><i class="bi bi-cart2"></i>Order
                    History</a>
                <a href="{{ route('user.address') }}" class="nav-link @if(request()->is('user/my-address')) active @endif"><i class="bi bi-geo-alt"></i>My Address</a>
                <a href="{{ route('change.password') }}" class="nav-link @if(request()->is('user/change-password')) active @endif"><i class="bi bi-key"></i>Change Password</a>
                <a class="nav-link" href="{{ route('user.logout') }}"><i class="bi bi-box-arrow-in-right"></i>Logout</a>
            </div>

        </div>
    </div>
</div>
