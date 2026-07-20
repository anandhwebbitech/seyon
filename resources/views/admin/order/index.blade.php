@extends('admin.index')
@section('admin')
    <link href="vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        thead th {
            font-family: 'Open Sans', sans-serif !important;
        }

        .thead-success th {
            background-color: #f71517 !important;
        }

        table {
            margin-bottom: 20px !important;
        }

        .table-scroll {
            max-height: 460px;
            /* orders table is tall */
            overflow-y: auto;
            overflow-x: auto;
        }

        .table-scroll thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background-color: #198754;
            /* thead-success */
            color: #fff;
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
    </style>

    <div class="card-header">
        <h4 class="card-title">Order List</h4>
    </div>

    @if (session('danger'))
        <div id="dangerAlert" class="alert alert-danger">
            {{ session('danger') }}
        </div>

        <script>
            setTimeout(function() {
                $('#dangerAlert').fadeOut('fast');
            }, 3000);
        </script>
    @endif


    @if (session('success'))
        <div id="successAlert" class="alert alert-success">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function() {
                $('#successAlert').fadeOut('fast');
            }, 3000);
        </script>
    @endif

    <div class="card-body">
        <form method="GET" action="{{ route('admin.order.list') }}" class="mb-4">
            <div class="row g-3">

                <!-- Date From -->
                <div class="col-md-3">
                    <label>From Date</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <!-- Date To -->
                <div class="col-md-3">
                    <label>To Date</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                <!-- Payment Method -->
                <div class="col-md-3">
                    <label>Payment Method</label>
                    <select name="payment_method" class="form-control">
                        <option value="">All</option>
                        <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>COD</option>
                        <option value="online" {{ request('payment_method') == 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                </div>

                <!-- Order Status -->
                <div class="col-md-3">
                    <label>Order Status</label>
                    <select name="order_status" class="form-control">
                        <option value="">All</option>
                        <option value="0" {{ request('order_status') == '0' ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ request('order_status') == '1' ? 'selected' : '' }}>Approved</option>
                        <option value="2" {{ request('order_status') == '2' ? 'selected' : '' }}>Cancelled</option>
                        <option value="3" {{ request('order_status') == '3' ? 'selected' : '' }}>Waiting</option>
                    </select>
                </div>

                <!-- Shipping Status -->
                <div class="col-md-3">
                    <label>Shipping Status</label>
                    <select name="shipping_status" class="form-control">
                        <option value="">All</option>
                        <option value="1" {{ request('shipping_status') == '1' ? 'selected' : '' }}>Order Received
                        </option>
                        <option value="2" {{ request('shipping_status') == '2' ? 'selected' : '' }}>Shipped</option>
                        <option value="3" {{ request('shipping_status') == '3' ? 'selected' : '' }}>Out For Delivery
                        </option>
                        <option value="4" {{ request('shipping_status') == '4' ? 'selected' : '' }}>Delivered</option>
                    </select>
                </div>

                <!-- Search by Name / Email / Phone -->
                <div class="col-md-3">
                    <label>Search User</label>
                    <input type="text" name="keyword" class="form-control" placeholder="Name / Email / Phone"
                        value="{{ request('keyword') }}">
                </div>

                <!-- Filter Button -->
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>

                <!-- Reset Button -->
                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ url('admin-all-orders') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </div>
        </form>
        <div class="table-responsive table-scroll">
            <table id="example4" class="table table-bordered verticle-middle table-striped table-responsive-sm"
                style="min-width: 845px">
                <thead class="thead-success">
                    <tr>
                        <th>S.No</th>
                        <th style="width:30%">Order Id</th>
                        <th style="width:30%">Name</th>
                        <th style="width:30%">email</th>
                        <th style="width:30%">Phone</th>
                        <th style="width:15%">Payment Method</th>
                        <th style="width:15%">Payment Status</th>
                        <th style="width:15%">Order Status</th>
                        <th style="width:15%">Shipping Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $item)
                        {{-- ⚠️ PERFORMANCE NOTE BELOW --}}
                        @php
                            $user = App\Models\User::find($item->user_id);
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>{{ $item->payment_order_id }}</td>
                            <td>{{ $user->name ?? '-' }}</td>
                            <td>{{ $user->email ?? '-' }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>{{ $item->payment_method }}</td>
                            <td>{{ $item->payment_status ?? '-' }}</td>

                            <td>
                                @if ($item->order_status == 0)
                                    <span class="badge badge-light">Pending</span>
                                @elseif($item->order_status == 1)
                                    <span class="badge badge-success">Approved</span>
                                @elseif($item->order_status == 2)
                                    <span class="badge badge-danger">Cancelled</span>
                                @else
                                    <span class="badge badge-warning">Waiting</span>
                                @endif
                            </td>

                            <td>
                                @if ($item->shipping_status == 1)
                                    <span class="badge badge-warning">Order Received</span>
                                @elseif($item->shipping_status == 2)
                                    <span class="badge badge-warning">Shipped</span>
                                @elseif($item->shipping_status == 3)
                                    <span class="badge badge-warning">Out Of Delivery</span>
                                @elseif($item->shipping_status == 4)
                                    <span class="badge badge-success">Delivered</span>
                                @else
                                    <span class="badge badge-light">Pending</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.order.detail', $item->id) }}"
                                        class="btn btn-success btn-xs me-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>




    <script src="vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="js/plugins-init/sweetalert.init.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('a.btn-danger').click(function(event) {
                event.preventDefault(); // Prevent the default action of the link

                var deleteUrl = $(this).attr('href'); // Get the URL to delete

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
                        // If the user confirms, proceed with the deletion
                        window.location.href = deleteUrl; // Redirect to the delete URL
                    } else {
                        // If the user cancels, show a message
                        /*Swal.fire(
                        'Cancelled',
                        'Your file is safe :)',
                        'error'
                        );*/
                    }
                });
            });
        });
    </script>
@endsection
