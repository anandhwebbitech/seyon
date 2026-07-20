@extends('admin.index')
@section('admin')
    <style>
        .table-scroll {
            max-height: 450px;
            /* adjust height if needed */
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
        <h4 class="card-title">All Banner Images</h4>
        <a href="{{ route('admin.banner.add') }}" class="btn btn-primary">
            Add Banner Image
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if (session('danger'))
        <div class="alert alert-success mt-3">{{ session('danger') }}</div>
    @endif
    <div class="card-body">
        <div class="table-responsive table-scroll">
            <table class="table table-bordered table-striped" style="min-width: 845px">

                <thead class="thead-success">
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Banner Link</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($banner_images as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->title }}</td>
                            <td>
                                <img src="{{ asset($item->image) }}" width="120">
                            </td>
                            <td>{{ $item->banner_link }}</td>
                            <td>{{ $item->description }}</td>
                            <td>
                                <a href="{{ route('banner_images.delete', $item->id) }}"
                                    class="btn btn-danger shadow btn-xs sharp">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection
