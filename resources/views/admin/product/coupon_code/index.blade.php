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
            max-height: 450px;
            /* adjust as needed */
            overflow-y: auto;
            overflow-x: auto;
        }

        .table-scroll thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background-color: #198754;
            /* matches thead-success */
            color: #fff;
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
    </style>



    <div class="card-header">
        <h4 class="card-title">Coupon code</h4>
        <button type="button" class="btn btn-primary"
            onclick="window.location.href = '{{ route('admin.product.coupon_code.add') }}'">
            Add New
        </button>

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
        <div class="table-responsive table-scroll">
            <table id="example4" class="display table table-bordered verticle-middle table-striped table-responsive-sm"
                style="min-width: 845px">

                <thead class="thead-success">
                    <tr>
                        <th>S.No</th>
                        <th>CODE</th>
                        <th style="width:30%">PERCENTAGE</th>
                        <th style="width:15%">STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($coupon_code as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->percentage }}%</td>
                            <td>
                                @if ($item->status == 1)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.product.coupon_code.edit', $item->id) }}"
                                        class="btn btn-success shadow btn-xs sharp me-2">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <a href="{{ route('product.coupon_code.delete', $item->id) }}"
                                        class="btn btn-danger shadow btn-xs sharp">
                                        <i class="fa fa-trash"></i>
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
