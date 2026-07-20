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
            /* adjust height */
            overflow-y: auto;
            overflow-x: auto;
        }

        .table-scroll thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #198754;
            /* match thead-success */
            color: #fff;
        }

        /* Prevent column shifting */
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
    </style>



    <div class="card-header">
        <h4 class="card-title">User List</h4>
    </div>




    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <div class="card-body">
        <div class="table-responsive table-scroll">
            <table id="example4" class="table table-bordered table-striped verticle-middle">
                <thead class="thead-success sticky-head">
                    <tr>
                        <th>S.No</th>
                        <th>NAME</th>
                        <th style="width:15%">MOBILE NO</th>
                        <th style="width:30%">EMAIL</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                @if ($item->user_status == 1)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                           
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.user.preview', $item->id) }}" class="btn btn-info btn-xs me-2">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.user.delete', $item->id) }}" class="btn btn-danger btn-xs">
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
