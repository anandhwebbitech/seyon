@extends('frontend.layouts.app')
@section('content')
    {{-- <div class="page-banner">
        <div class="container">
            <ul class="navigation-list">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>My Address</li>
            </ul>
        </div>
       </div> --}}

    <style>
        /* ==================== MY ADDRESS PAGE STYLES ==================== */

        /* Profile Detail Section */
        dd p {
            color: black;
        }

        .profile-detail {
            padding: 60px 0;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .main-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            padding-bottom: 15px;
        }

        .main-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: #dc3545;
            border-radius: 2px;
        }

        /* Profile Right Section */
        .profile-right {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #EDEDED;
        }

        .profile-box-title {
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            background: #dc3545;
            padding: 20px 30px;
            margin: -30px -30px 20px -30px;
            border-radius: 10px 10px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Alert Messages */
        .alert {
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
            font-weight: 500;
            animation: slideDown 0.3s ease;
            border-left: 4px solid;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #28a745;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }

        /* Add Address Button */
        .profile-right .text-end {
            margin-top: 20px;
        }

        .profile-right .text-end .btn-primary {
            background: #dc3545;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }

        .profile-right .text-end .btn-primary:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        /* Address Card */
        .address-card {
            background: white;
            border: 2px solid #EDEDED;
            border-radius: 10px;
            padding: 25px;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
        }

        .address-card:hover {
            border-color: #dc3545;
            box-shadow: 0 5px 20px rgba(220, 53, 69, 0.15);
            transform: translateY(-3px);
        }

        /* Form Check (Radio Button) */
        .form-check-input {
            width: 20px;
            height: 20px;
            border: 2px solid #dee2e6;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .form-check-label {
            font-weight: 600;
            color: #333;
            font-size: 16px;
            margin-left: 8px;
            cursor: pointer;
        }

        /* Edit Badge */
        .edit-badge {
            display: inline-block;
            background: #dc3545;
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Address Details */
        .address-card dl {
            margin-bottom: 0;
        }

        .address-card dt,
        .address-card dd {
            font-size: 14px;
            line-height: 1.8;
        }

        .address-card dt {
            font-weight: 600;
            color: #666;
        }

        .address-card dd {
            color: #333;
            font-weight: 500;
        }

        .address-card dd p {
            margin-bottom: 5px;
        }

        /* Buttons */
        .common-btn1 {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #dc3545;
            color: white;
        }
        .common-btn2 {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #ffffff;
            color: rgb(31, 219, 22);
            border: solid 1px rgb(31, 219, 22);
        }
        .common-btn2:hover {
            background: rgb(31, 219, 22);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(32, 219, 22, 0.19);
            color: white;
        }
        .common-btn1:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
            color: white;
        }

        .common-btn1 i {
            font-size: 14px;
        }

        /* Modal Styling */
        .form-modal .modal-content {
            border-radius: 10px;
            border: 1px solid #EDEDED;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .form-modal .modal-header {
            background: #dc3545;
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 20px 30px;
            border-bottom: none;
        }

        .form-modal .modal-title {
            font-weight: 700;
            font-size: 22px;
        }

        .form-modal .btn-close {
            filter: brightness(0) invert(1);
            opacity: 1;
        }

        .form-modal .modal-body {
            padding: 30px;
        }

        .form-modal .modal-footer {
            padding: 20px 30px;
            background-color: #f8f9fa;
            border-radius: 0 0 10px 10px;
            border-top: 1px solid #EDEDED;
        }

        /* Form Elements */
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            border: 2px solid #EDEDED;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .form-check-inline {
            margin-right: 20px;
        }

        .form-check-inline .form-check-input {
            margin-top: 0.15rem;
        }

        .form-check-inline .form-check-label {
            font-size: 14px;
            font-weight: 500;
        }

        /* Text Danger for Validation */
        .text-danger {
            font-size: 12px;
            margin-top: 5px;
            font-weight: 500;
        }

        .text-muted {
            color: #6c757d !important;
            font-size: 13px;
        }

        /* Button Styling for Modal */
        .btn-success {
            background: #28a745;
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .btn-danger {
            background: #dc3545;
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 991px) {
            .profile-detail {
                padding: 40px 0;
            }

            .main-title {
                font-size: 24px;
            }

            .profile-box-title {
                font-size: 22px;
                padding: 15px 20px;
                margin: -30px -30px 20px -30px;
            }

            .profile-right {
                padding: 20px;
                margin-top: 20px;
            }
        }

        @media (max-width: 767px) {
            .address-card {
                padding: 20px;
            }

            .main-title {
                font-size: 20px;
            }

            .profile-box-title {
                font-size: 18px;
                padding: 15px 20px;
                margin: -20px -20px 15px -20px;
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .edit-badge {
                font-size: 11px;
                padding: 5px 12px;
            }

            .common-btn1 {
                padding: 8px 15px;
                font-size: 13px;
            }

            .form-modal .modal-body {
                padding: 20px;
            }
        }

        @media (max-width: 575px) {
            .profile-right {
                padding: 15px;
            }

            .address-card {
                padding: 15px;
            }

            .common-btn1 {
                font-size: 12px;
                padding: 8px 12px;
            }

            .form-modal .modal-header,
            .form-modal .modal-footer {
                padding: 15px 20px;
            }

            .form-modal .modal-title {
                font-size: 18px;
            }

            .profile-box-title {
                font-size: 16px;
                padding: 12px 15px;
                margin: -15px -15px 15px -15px;
            }
        }

        /* Edit Button Icon in Address Card */
        .address-card .d-flex {
            gap: 10px;
        }

        .address-card .btn {
            flex: 1;
        }

        /* Empty State (if no addresses) */
        .no-address-state {
            text-align: center;
            padding: 60px 20px;
        }

        .no-address-state i {
            font-size: 80px;
            color: #dee2e6;
            margin-bottom: 20px;
        }

        .no-address-state h4 {
            color: #666;
            margin-bottom: 10px;
        }

        .no-address-state p {
            color: #999;
        }

        .badge-default {
            display: inline-block;
            background: #ffffff;
            border: #dc3545 solid 1px;
            color: rgb(166, 0, 0);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>

    <div class="profile-detail">
        <div class="container">
            <h5 class="main-title">My Address</h5>
            <div class="row gy-4 gx-2 mt-3">
                @include('frontend.user.sidebar')
                <div class="col-lg-9 col-md-8">
                    <div class="profile-right">
                        <h5 class="profile-box-title">My Address</h5>
                        @if (session('addsuccess'))
                            <div id="successMessage" class="alert alert-success">
                                {{ session('addsuccess') }}
                            </div>

                            <script>
                                setTimeout(function() {
                                    document.getElementById('successMessage').style.display = 'none';
                                }, 5000);
                            </script>
                        @endif

                        @if (session('error'))
                            <div id="errorMessage" class="alert alert-danger">
                                {{ session('error') }}
                            </div>

                            <script>
                                setTimeout(function() {
                                    document.getElementById('errorMessage').style.display = 'none';
                                }, 5000);
                            </script>
                        @endif
                        <p class="mt-3 text-end"><a data-bs-toggle="modal" data-bs-target="#exampleModal"
                                class="btn-sm btn-primary">Add Address <i class="bi bi-plus ms-2"></i></a></p>
                        <div class="row gy-4 mt-3">

                            @foreach ($userAddress as $address)
                                <div class="col-lg-6 col-md-12">
                                    <div class="address-card">
                                        <div class="row gy-4 align-items-center">
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="address"
                                                        id="address_{{ $address->id }}" value="{{ $address->id }}">
                                                    <label class="form-check-label" for="address_{{ $address->id }}">
                                                        {{ $address->shipping_name }}
                                                    </label>
                                                    @if($address->is_default == 1)
                                                        <span class="badge-default">
                                                            default
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-end">
                                                    <p class="edit-badge">{{ $address->address_type }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <dl class="row mt-4 gy-2">
                                            <dd class="col-sm-3">
                                                <p>Address</p>
                                            </dd>
                                            <dd class="col-sm-9">
                                                <p>{{ $address->shipping_address }}</p>
                                                @php
                                                    $country = App\Models\Country::where(
                                                        'id',
                                                        $address->country,
                                                    )->first();
                                                    $state = App\Models\State::where('id', $address->state)->first();
                                                    $city = App\Models\City::where('id', $address->city)->first();
                                                @endphp
                                                <br>
                                                <p>{{ $city->name ?? '' }},&nbsp;{{ $state->name ?? '' }},&nbsp;{{ $country->name ?? '' }}.
                                                </p>
                                            </dd>
                                            <dd class="col-sm-3">
                                                <p>Pin Code</p>
                                            </dd>
                                            <dd class="col-sm-9">
                                                <p>{{ $address->pincode }}</p>
                                            </dd>
                                            <dd class="col-sm-3">
                                                <p>Phone</p>
                                            </dd>
                                            <dd class="col-sm-9">
                                                <p>{{ $address->shipping_phone }}</p>
                                            </dd>
                                        </dl>
                                        <p class="text-center d-flex justify-content-evenly">
                                            <a href="javascript:void(0);" class="common edit-address-link btn common-btn2 w-50 me-1"
                                                data-url="{{ route('user.getAddress',$address->id) }}"
                                                data-address-id="{{ $address->id }}"><i class="bi bi-pencil"></i> Edit</a>
                                            <a href="{{ route('user.address.delete', $address->id) }}"
                                                class="btn common-btn1 w-50 ms-1"><i class="bi bi-trash"></i> Delete</a>
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal form-modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Address</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.addNewAddress') }}" method="post" id="myForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row gy-3">
                            <small id="emailHelp" class="form-text text-muted">Your information is safe with us.</small>
                            <div class="col-lg-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="address_type" id="inlineRadio1"
                                        value="Home">
                                    <label class="form-check-label" for="inlineRadio1">Home</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="address_type" id="inlineRadio2"
                                        value="Office">
                                    <label class="form-check-label" for="inlineRadio2">Office</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="address_type" id="inlineRadio3"
                                        value="Others">
                                    <label class="form-check-label" for="inlineRadio3">Others</label>
                                </div>
                            </div>
                            <div class="col-lg-4 ">
                                <label class="form-label" for="name">Full Name</label>
                                <input type="text" class="form-control" id="shipping_name" aria-describedby="emailHelp"
                                    name="shipping_name" placeholder="Enter Your Full Name">
                                <div id="shipping_name_error" class="text-danger"></div>
                            </div>
                            <div class="col-lg-4 ">
                                <label class="form-label" for="email1">Email address</label>
                                <input type="email" class="form-control" id="shipping_email" name="shipping_email"
                                    aria-describedby="emailHelp" placeholder="Enter email">
                                <div id="shipping_email_error" class="text-danger"></div>
                            </div>
                            <div class="col-lg-4 ">
                                <label class="form-label" for="phone1">Phone</label>
                                <input type="phone" class="form-control" id="shipping_phone" name="shipping_phone"
                                    placeholder="+918765***">
                                <div id="shipping_phone_error" class="text-danger"></div>
                            </div>
                            <div class="col-lg-4 ">
                                <label class="form-label" for="address1">Address</label>
                                <input type="address" class="form-control" id="shipping_address" name="shipping_address"
                                    placeholder="Add Address...">
                                <div id="shipping_address_error" class="text-danger"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label" for="country">Country</label>
                                <select class="form-control" id="country" name="country">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div id="country_error" class="text-danger"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label" for="state">State</label>
                                <select class="form-control" id="state" name="state">
                                    <option value="">Select State</option>
                                </select>
                                <div id="state_error" class="text-danger"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label" for="city">City</label>
                                <select class="form-control" id="city" name="city">
                                    <option value="">Select City</option>
                                </select>
                                <div id="city_error" class="text-danger"></div>
                            </div>
                            <div class="col-lg-4 ">
                                <label class="form-label" for="pincode1">Pincode</label>
                                <input type="number" class="form-control" id="pincode" name="pincode"
                                    placeholder=" pincode">
                                <div id="pincode_error" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="row align-items-center mt-2">
                            <div class="col-auto">
                                <input type="checkbox" id="is_default" name="is_default" class="form-check-input">
                            </div>
                            <div class="col">
                                <label for="is_default" class="form-check-label">Check this as default address</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="text-light btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="text-light btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Address Modal -->
    <div class="modal form-modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editAddressModalLabel">Edit Address</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="edit-content">
                    <form action="{{ route('user.updateAddress') }}" method="post" id="editForm">
                        @csrf
                        <input type="hidden" id="edit_address_id" name="edit_address_id">
                        <div class="modal-body">
                            <div class="row gy-3">
                                <small id="emailHelp" class="form-text text-muted">Your information is safe with us.</small>
                                <div class="col-lg-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="address_type"
                                            id="editRadioHome" value="Home">
                                        <label class="form-check-label" for="editRadioHome">Home</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="address_type"
                                            id="editRadioOffice" value="Office">
                                        <label class="form-check-label" for="editRadioOffice">Office</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="address_type"
                                            id="editRadioOthers" value="Others">
                                        <label class="form-check-label" for="editRadioOthers">Others</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label" for="edit_shipping_name">Full Name</label>
                                    <input type="text" class="form-control" id="edit_shipping_name" name="shipping_name"
                                        placeholder="Enter Your Full Name">
                                    <div id="edit_shipping_name_error" class="text-danger"></div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label" for="edit_shipping_email">Email address</label>
                                    <input type="email" class="form-control" id="edit_shipping_email"
                                        name="shipping_email" placeholder="Enter email">
                                    <div id="edit_shipping_email_error" class="text-danger"></div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label" for="edit_shipping_phone">Phone</label>
                                    <input type="phone" class="form-control" id="edit_shipping_phone"
                                        name="shipping_phone" placeholder="+9187654321">
                                    <div id="edit_shipping_phone_error" class="text-danger"></div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label" for="edit_shipping_address">Address</label>
                                    <input type="address" class="form-control" id="edit_shipping_address"
                                        name="shipping_address" placeholder="Add Address...">
                                    <div id="edit_shipping_address_error" class="text-danger"></div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label" for="country">Country</label>
                                    <select class="form-control" id="edit_shipping_country" name="country">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <div id="edit_shipping_country_error" class="text-danger"></div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label" for="state">State</label>
                                    <select class="form-control" id="edit_shipping_state" name="state">
                                        <option value="">Select State</option>
                                    </select>
                                    <div id="edit_shipping_state_error" class="text-danger"></div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label" for="city">City</label>
                                    <select class="form-control" id="edit_shipping_city" name="city">
                                        <option value="">Select City</option>
                                    </select>
                                    <div id="edit_shipping_city_error" class="text-danger"></div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label" for="edit_pincode">Pincode</label>
                                    <input type="number" class="form-control" id="edit_pincode" name="pincode"
                                        placeholder="pincode">
                                    <div id="edit_pincode_error" class="text-danger"></div>
                                </div>
                            </div>
                            <div class="row align-items-center mt-2">
                                <div class="col-auto">
                                    <input type="checkbox" id="is_default" name="is_default" class="form-check-input">
                                </div>
                                <div class="col">
                                    <label for="is_default" class="form-check-label">Check this as default address</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="text-light btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="text-light btn-success">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#editForm').submit(function(event) {
            console.log("Form submitted");

            var shippingnameInput = $('#edit_shipping_name');
            var shippingnameError = $('#edit_shipping_name_error');

            // Check if the input field is empty
            if (!shippingnameInput.val().trim()) {
                shippingnameError.text('Please enter your full name.');
                event.preventDefault(); // Prevent form submission
            } else {
                shippingnameError.text(''); // Clear any previous error messages
            }


            var shippingemailInput = $('#edit_shipping_email');
            var shippingemailError = $('#edit_shipping_email_error');

            // Check if the input field is empty
            if (!shippingemailInput.val().trim()) {
                shippingemailError.text('Please enter your email.');
                event.preventDefault(); // Prevent form submission
            } else {
                shippingemailError.text(''); // Clear any previous error messages
            }



            var shippingphoneInput = $('#edit_shipping_phone');
            var shippingphoneError = $('#edit_shipping_phone_error');

            // Check if the input field is empty
            if (!shippingphoneInput.val().trim()) {
                shippingphoneError.text('Please enter your phone number.');
                event.preventDefault(); // Prevent form submission
            } else {
                shippingphoneError.text(''); // Clear any previous error messages
            }




            var shippingaddressInput = $('#edit_shipping_address');
            var shippingaddressError = $('#edit_shipping_address_error');

            // Check if the input field is empty
            if (!shippingaddressInput.val().trim()) {
                shippingaddressError.text('Please enter your address.');
                event.preventDefault(); // Prevent form submission
            } else {
                shippingaddressError.text(''); // Clear any previous error messages
            }



            var countryInput = $('#edit_shipping_country');
            var stateInput = $('#edit_shipping_state');
            var cityInput = $('#edit_shipping_city');
            var countryError = $('#edit_shipping_country_error');
            var stateError = $('#edit_shipping_state_error');
            var cityError = $('#edit_shipping_city_error');

            var isValid = true;

            // Check if the country is selected
            if (!countryInput.val()) {
                countryError.text('Please select your country.');
                isValid = false;
            } else {
                countryError.text('');
            }

            // Check if the state is selected
            if (!stateInput.val()) {
                stateError.text('Please select your state.');
                isValid = false;
            } else {
                stateError.text('');
            }

            // Check if the city is selected
            if (!cityInput.val()) {
                cityError.text('Please select your city.');
                isValid = false;
            } else {
                cityError.text('');
            }

            // Allow form submission only if there are no errors
            if (!isValid) {
                event.preventDefault(); // Prevent form submission
            }
        });

        $('#edit_shipping_name').on('input', function() {
            $('#edit_shipping_name_error').text('');
        });
        $('#edit_shipping_email').on('input', function() {
            $('#edit_shipping_email_error').text('');
        });
        $('#edit_shipping_phone').on('input', function() {
            $('#edit_shipping_phone_error').text('');
        });
        $('#edit_shipping_address').on('input', function() {
            $('#edit_shipping_address_error').text('');
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#myForm').submit(function(event) {
            var shippingnameInput = $('#shipping_name');
            var shippingnameError = $('#shipping_name_error');

            // Check if the input field is empty
            if (!shippingnameInput.val().trim()) {
                shippingnameError.text('Please enter your full name.');
                event.preventDefault(); // Prevent form submission
            } else {
                shippingnameError.text(''); // Clear any previous error messages
            }


            var shippingemailInput = $('#shipping_email');
            var shippingemailError = $('#shipping_email_error');

            // Check if the input field is empty
            if (!shippingemailInput.val().trim()) {
                shippingemailError.text('Please enter your email.');
                event.preventDefault(); // Prevent form submission
            } else {
                shippingemailError.text(''); // Clear any previous error messages
            }



            var shippingphoneInput = $('#shipping_phone');
            var shippingphoneError = $('#shipping_phone_error');

            // Check if the input field is empty
            if (!shippingphoneInput.val().trim()) {
                shippingphoneError.text('Please enter your phone number.');
                event.preventDefault(); // Prevent form submission
            } else {
                shippingphoneError.text(''); // Clear any previous error messages
            }




            var shippingaddressInput = $('#shipping_address');
            var shippingaddressError = $('#shipping_address_error');

            // Check if the input field is empty
            if (!shippingaddressInput.val().trim()) {
                shippingaddressError.text('Please enter your address.');
                event.preventDefault(); // Prevent form submission
            } else {
                shippingaddressError.text(''); // Clear any previous error messages
            }



            var countryInput = $('#country');
            var stateInput = $('#state');
            var cityInput = $('#city');
            var countryError = $('#country_error');
            var stateError = $('#state_error');
            var cityError = $('#city_error');

            var isValid = true;

            // Check if the country is selected
            if (!countryInput.val()) {
                countryError.text('Please select your country.');
                isValid = false;
            } else {
                countryError.text('');
            }

            // Check if the state is selected
            if (!stateInput.val()) {
                stateError.text('Please select your state.');
                isValid = false;
            } else {
                stateError.text('');
            }

            // Check if the city is selected
            if (!cityInput.val()) {
                cityError.text('Please select your city.');
                isValid = false;
            } else {
                cityError.text('');
            }

        });




        // Add input event listener to clear error message when typing
        $('#shipping_name').on('input', function() {
            $('#shipping_name_error').text('');
        });
        $('#shipping_email').on('input', function() {
            $('#shipping_email_error').text('');
        });
        $('#shipping_phone').on('input', function() {
            $('#shipping_phone_error').text('');
        });
        $('#shipping_address').on('input', function() {
            $('#shipping_address_error').text('');
        });



    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#country').on('change', function() {
            var countryID = $(this).val();
            if (countryID) {
                $.ajax({
                    url: "{{ route('getStates') }}",
                    type: "POST",
                    data: {
                        country_id: countryID,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#state').empty().append(
                            '<option value="">Select State</option>');
                        $('#city').empty().append('<option value="">Select City</option>');
                        $.each(data, function(key, value) {
                            $('#state').append('<option value="' + value.id + '">' +
                                value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#state').empty().append('<option value="">Select State</option>');
                $('#city').empty().append('<option value="">Select City</option>');
            }
        });

        $('#state').on('change', function() {
            var stateID = $(this).val();
            if (stateID) {
                $.ajax({
                    url: "{{ route('getCities') }}",
                    type: "POST",
                    data: {
                        state_id: stateID,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#city').empty().append('<option value="">Select City</option>');
                        $.each(data, function(key, value) {
                            $('#city').append('<option value="' + value.id + '">' +
                                value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#city').empty().append('<option value="">Select City</option>');
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#edit_shipping_country').on('change', function() {
            var countryID = $(this).val();
            if (countryID) {
                $.ajax({
                    url: "{{ route('getStates') }}",
                    type: "POST",
                    data: {
                        country_id: countryID,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#edit_shipping_state').empty().append(
                            '<option value="">Select State</option>');
                        $('#edit_shipping_city').empty().append(
                            '<option value="">Select City</option>');
                        $.each(data, function(key, value) {
                            $('#edit_shipping_state').append('<option value="' +
                                value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#edit_shipping_state').empty().append('<option value="">Select State</option>');
                $('#edit_shipping_city').empty().append('<option value="">Select City</option>');
            }
        });

        $('#edit_shipping_state').on('change', function() {
            var stateID = $(this).val();
            if (stateID) {
                $.ajax({
                    url: "{{ route('getCities') }}",
                    type: "POST",
                    data: {
                        state_id: stateID,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#edit_shipping_city').empty().append(
                            '<option value="">Select City</option>');
                        $.each(data, function(key, value) {
                            $('#edit_shipping_city').append('<option value="' +
                                value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#edit_shipping_city').empty().append('<option value="">Select City</option>');
            }
        });
        $('.edit-address-link').on('click', function() {
            var address_id = $(this).data('address-id');
            var address_url = $(this).data('url');

            $.ajax({
                url: address_url,
                type: "POST",
                data: {
                    address_id: address_id,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    // Show loader before the request starts
                    $('#editAddressModal .edit-content').html(`
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 mb-0">Loading address details...</p>
                        </div>
                    `);
                    $('#editAddressModal').modal('show');
                },
                success: function(response) {
                    $('#editAddressModal .edit-content').html(response.html);
                },
                error: function(xhr) {
                    $('#editAddressModal .edit-content').html(`
                        <div class="text-center py-4 text-danger">
                            Failed to load address. Please try again.
                        </div>
                    `);
                }
            });
        });

    });
</script>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all trigger buttons for opening modals
        const editButtons = document.querySelectorAll('.edit-address-link');

        // Add event listener to each edit button
        editButtons.forEach(function(editButton) {
            editButton.addEventListener('click', function(event) {
                event.preventDefault();

                // Get the address ID from the data attribute
                const addressId = this.getAttribute('data-address-id');

                // Generate the URL using the route helper
                const url = `{{ route('user.getAddress', ':id') }}`.replace(':id', addressId);

                // Make an AJAX request to fetch the address data
                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(addressData => {
                        // Populate the modal fields
                        document.getElementById('edit_address_id').value = addressData.id;
                        document.getElementById('edit_shipping_name').value = addressData
                            .shipping_name;
                        document.getElementById('edit_shipping_email').value = addressData
                            .shipping_email;
                        document.getElementById('edit_shipping_phone').value = addressData
                            .shipping_phone;
                        document.getElementById('edit_shipping_address').value = addressData
                            .shipping_address;
                        document.getElementById('edit_pincode').value = addressData.pincode;

                        // Open the modal
                        var editModal = new bootstrap.Modal(document.getElementById(
                            'editAddressModal'));
                        editModal.show();
                    })
                    .catch(error => {
                        console.error('Error fetching address data:', error);
                    });
            });
        });
    });
</script> --}}
