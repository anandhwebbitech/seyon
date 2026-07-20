@extends('admin.index')

@section('admin')
    <link href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">

    <style>
        thead th {
            font-family: 'Open Sans', sans-serif !important;
        }

        .thead-success th {
            background-color: #f71517 !important;
            color: #fff;
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
            background-color: #198754;
            /* thead-success */
            color: #fff;
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
    </style>

    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Shop By Reels List</h4>
        <a href="{{ route('shop-by-reels.create') }}" class="btn btn-primary">
            Add New
        </a>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
        <div id="successAlert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('danger'))
        <div id="dangerAlert" class="alert alert-danger">
            {{ session('danger') }}
        </div>
    @endif

    <div class="card-body">
        <div class="table-responsive table-scroll">
            <table class="table table-bordered table-striped">
                <thead class="thead-success">
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th>Video URL</th>
                        <th>Redirect URL</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($reels as $reel)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reel->title }}</td>

                            <td>
                                <a href="{{ $reel->url }}" target="_blank">
                                    View Reel
                                </a>
                            </td>

                            <td>
                                <a href="{{ $reel->redirect_url }}" target="_blank">
                                    Redirect Link
                                </a>
                            </td>

                            <td>
                                @if ($reel->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('shop-by-reels.edit', $reel->id) }}"
                                        class="btn btn-success btn-xs me-2">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <form action="{{ route('shop-by-reels.destroy', $reel->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
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

            setTimeout(() => {
                $('#successAlert, #dangerAlert').fadeOut('fast');
            }, 3000);

            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                let form = this;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This record will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
