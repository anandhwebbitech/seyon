@extends('frontend.layouts.app')

@section('content')
    <!-- Profile Section -->
    <div class="profile-detail">
        <div class="container">
            <h5 class="main-title">My Profile</h5>
            <div class="row gy-4 gx-2 mt-3">

                <!-- Sidebar -->
                @include('frontend.user.sidebar')

                <!-- Profile Content -->
                <div class="col-lg-9 col-md-8">
                    <div class="profile-right">

                        <!-- Profile Box -->
                        <div class="profile-box mb-5">

                            <div class="profile-box-heading">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h5 class="profile-box-title">Profile About</h5>
                                    </div>
                                    <div class="col-md-6 text-md-end text-start mt-2 mt-md-0">
                                        <a href="{{ route('user.profile.edit') }}" class="common-btn">
                                            Edit Profile <i class="bi bi-pencil ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Success Message -->
                            @if (session('success'))
                                <div id="successMessage" class="alert alert-success mt-3">
                                    {{ session('success') }}
                                </div>
                                <script>
                                    setTimeout(function() {
                                        let msg = document.getElementById('successMessage');
                                        if (msg) msg.style.display = 'none';
                                    }, 5000);
                                </script>
                            @endif

                            <!-- User Details -->
                            <dl class="row gy-3 mt-4">
                                <dt class="col-sm-3">
                                    <p class="common mb-0">Name</p>
                                </dt>
                                <dd class="col-sm-9">
                                    <p class="mb-0">{{ auth()->user()->name }}</p>
                                </dd>

                                <dt class="col-sm-3">
                                    <p class="common mb-0">Email</p>
                                </dt>
                                <dd class="col-sm-9">
                                    <p class="mb-0">{{ auth()->user()->email }}</p>
                                </dd>

                                <dt class="col-sm-3">
                                    <p class="common mb-0">Phone</p>
                                </dt>
                                <dd class="col-sm-9">
                                    <p class="mb-0">{{ auth()->user()->phone ?? 'N/A' }}</p>
                                </dd>
                            </dl>
                        </div>
                        <!-- /Profile Box -->

                    </div>
                </div>
                <!-- /Profile Content -->

            </div>
        </div>
    </div>
    <!-- /Profile Section -->
    <style>
        .profile-box {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        /* Profile Box Heading */
        .profile-box-heading {
            background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%);
            padding: 20px 25px;
            border-bottom: 3px solid #b71c1c;
        }

        .profile-box-title {
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            margin: 0;
        }

        /* Edit Profile Button */
        .profile-box-heading .common-btn {
            background: #fff;
            color: #d32f2f;
            border: 2px solid #fff;
            padding: 8px 10px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .profile-box-heading .common-btn:hover {
            background: transparent;
            color: #fff;
            border-color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
        }

        .profile-box-heading .common-btn i {
            transition: transform 0.3s ease;
        }

        .profile-box-heading .common-btn:hover i {
            transform: rotate(15deg);
        }

        /* Success Alert */
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            border-radius: 6px;
            padding: 12px 20px;
            border-left: 4px solid #28a745;
            margin: 20px 25px 0;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* User Details Section */
        dt.col-sm-3 {
            margin-bottom: 8px;
        }
        .profile-right {
            margin: 10px 0;
        }
        .profile-box dl.row {
            padding: 25px;
            margin: 0;
        }

        .profile-box dl.row dt {
            font-weight: 600;
            color: #555;
        }

        .profile-box dl.row dt .common {
            color: #555;
            font-size: 15px;
        }

        .profile-box dl.row dd {
            color: #333;
        }

        .profile-box dl.row dd p {
            font-size: 15px;
            padding: 8px 15px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 3px solid #d32f2f;
            color: black;
        }

        /* Row Spacing */
        .profile-box .gy-3>* {
            padding-top: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
        }

        .profile-box .gy-3>*:last-child {
            border-bottom: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-box-heading {
                padding: 15px 20px;
            }

            .profile-box-title {
                font-size: 18px;
            }

            .profile-box-heading .common-btn {
                width: 100%;
                justify-content: center;
                margin-top: 10px;
            }

            .profile-box dl.row {
                padding: 20px 15px;
            }

            .profile-box dl.row dt {
                margin-bottom: 5px;
            }

            .profile-box dl.row dd {
                margin-bottom: 15px;
            }
        }

        /* Hover Effect on Detail Rows */
        .profile-box .gy-3>*:hover dd p {
            background: #fff3f3;
            transform: translateX(5px);
            transition: all 0.3s ease;
        }
    </style>
@endsection
