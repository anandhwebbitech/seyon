@extends('frontend.layouts.app')
@section('content')
    <style>
        /* Profile Detail Section */
        .profile-detail {
            background-color: #f8f9fa;
            padding: 40px 0;
            min-height: calc(100vh - 200px);
        }

        .main-title {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 0;
        }

        /* Profile Box */
        .profile-box {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        /* Profile Box Heading */
        .profile-box-heading {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            padding: 25px 30px;
        }

        .profile-box-title {
            color: white;
            font-size: 22px;
            font-weight: 600;
            margin: 0;
        }

        /* Edit Profile Button */
        .edit-profile-btn {
            background: white;
            color: #dc3545;
            border: 2px solid white;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .edit-profile-btn:hover {
            background: transparent;
            color: white;
            border-color: white;
        }

        /* Form Styling */
        .edit-profile form {
            padding: 35px 30px;
        }

        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            border-left: 3px solid #dc3545;
        }

        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
            outline: none;
        }

        .form-control::placeholder {
            color: #999;
            font-size: 14px;
        }

        /* Readonly Fields */
        .form-control[readonly] {
            background-color: #f5f5f5;
            cursor: not-allowed;
            border-left-color: #999;
        }

        /* Common Button */
        .common-btn {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border: none;
            padding: 12px 35px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        .common-btn:hover {
            background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
            box-shadow: 0 6px 16px rgba(220, 53, 69, 0.4);
            transform: translateY(-2px);
            color: white;
        }

        .common-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-detail {
                padding: 20px 0;
            }

            .main-title {
                font-size: 24px;
            }

            .profile-box-heading {
                padding: 20px 20px;
            }

            .profile-box-title {
                font-size: 18px;
            }

            .edit-profile form {
                padding: 25px 20px;
            }

            .common-btn {
                width: 100%;
                padding: 12px 20px;
            }
        }

        /* Additional Spacing */
        .row.gy-4 {
            row-gap: 1.5rem;
        }

        .row.gx-3 {
            column-gap: 1rem;
        }

        .row.gx-4 {
            column-gap: 1.5rem;
        }

        /* Profile Right Container */
        .profile-right {
            width: 100%;
        }

        /* Text Alignment */
        .text-end {
            text-align: right;
        }

        @media (max-width: 576px) {
            .text-end {
                text-align: center;
            }
        }
    </style>


    <div class="profile-detail">
        <div class="container">
            <h5 class="main-title">My Profile</h5>
            <div class="row gy-4 gx-2 mt-3">
                @include('frontend.user.sidebar')
                <div class="col-lg-9 col-md-8">
                    <div class="profile-right">

                        <div class="profile-box edit-profile">
                            <div class="profile-box-heading">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <h5 class="profile-box-title">Edit Profile </h5>
                                    </div>

                                </div>
                            </div>
                            <form class="row gx-3 gy-4" action="{{ route('user.profile.update') }}" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <div class="col-md-6">
                                    <label for="inputEmail4" class="form-label">Name</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}"
                                        name="name" placeholder="First Name...">
                                </div>

                                <div class="col-md-6">
                                    <label for="inputEmail4" class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ auth()->user()->email }}"
                                        name="email" placeholder="Your Email..." style="background:#8080802e;" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputPassword4" class="form-label">Phone</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->phone }}"
                                        name="phone" placeholder="Phone Number..." style="background:#8080802e;" readonly>
                                </div>
                                <div class="col-12">
                                    <p class="text-end"> <button type="submit" class="common-btn">Save Changes</button>
                                    </p>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
