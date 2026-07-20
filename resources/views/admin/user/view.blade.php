@extends('admin.index')
@section('admin')


<style>
 .rigt-img {
        width:400px;
        height:250px;
        max-width:100%;
    }
    .rigt-img img {
        width:100%;
        height:100%;
        object-fit:cover;
    }
    
    .small-img
    {
        width :100px;
        height :100px;
        margin-right:10px;
    }
    .small-img img
    {
        width :100%;
        height :100%;
        object-fit : cover;
    }
    .img-max-200{
        max-width:200px;
    }
    
</style>

<div class="card-body">
    <div class="profile-tab">
        <div class="custom-tab-1">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a href="#about-me" data-bs-toggle="tab" class="nav-link active show">View user</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="about-me" class="tab-pane fade active show">
                    <br>
                    <div class="profile-personal-info">
                      
                        
                           
                               
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                            <div class="row mb-2">
                                 <div class="mb-4">
                                  @if($user->image_name)
                                <a href="<?php echo url('public/profile_images/' . ($user->image_name ?? '')); ?>" data-fancyBox="gallery1"><img class="rounded-circle img-max-200" src="<?php echo url('public/profile_images/' . ($user->image_name ?? '')); ?>" alt=""></a>
                                @else
                                <img class="rounded-circle img-max-200" src="<?php echo url('public/profile_images/dummy.jpg'); ?>" alt="">
                                @endif
                               </div>
                                
                                <div class="col-sm-3 col-5">
                                    <h5 class="f-w-500">NAME <span class="pull-end">:</span>
                                    </h5>
                                </div>
                                <div class="col-sm-9 col-7"><span>{{ $user->name }}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-3 col-5">
                                    <h5 class="f-w-500">Email <span class="pull-end">:</span>
                                    </h5>
                                </div>
                                <div class="col-sm-9 col-7"><span>{{ $user->email }}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-3 col-5">
                                    <h5 class="f-w-500">MOBILE NO <span class="pull-end">:</span></h5>
                                </div>
                                <div class="col-sm-9 col-7"><span>{{ $user->phone }}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-3 col-5">
                                    <h5 class="f-w-500">STATUS <span class="pull-end">:</span></h5>
                                </div>
                                <div class="col-sm-9 col-7">
                                    @if($user->user_status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            
                            
                            <div class="row mb-2">
                                <div class="col-sm-3 col-5">
                                    <h5 class="f-w-500">CREATED DATE <span class="pull-end">:</span></h5>
                                </div>
                                <div class="col-sm-9 col-7"><span>{{ $user->created_at }}</span>
                                </div>
                            </div>
                            
                        </div>  
                    
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>

    </div>
</div>




@endsection