@extends('admin.index')

@section('admin')

<div class="container my-5">
    <h3 class="mb-3">Milestone Settings</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('milestone.update') }}" method="POST">
        @csrf

        @foreach ($milestones as $milestone)
            <div class="card p-4 mb-3">

                <h4>Milestone {{ $loop->iteration }}</h4>

                <input type="hidden" name="milestone[{{ $milestone->id }}][id]" value="{{ $milestone->id }}">

                <div class="form-group mb-2">
                    <label>Name</label>
                    <input type="text" 
                        name="milestone[{{ $milestone->id }}][name]" 
                        class="form-control"
                        value="{{ $milestone->name }}">
                </div>

                <div class="form-group mb-2">
                    <label>Amount</label>
                    <input type="number"
                        name="milestone[{{ $milestone->id }}][amount]"
                        class="form-control"
                        value="{{ $milestone->amount }}">
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input"
                        type="checkbox"
                        name="milestone[{{ $milestone->id }}][status]"
                        value="1"
                        {{ $milestone->status ? 'checked' : '' }}>
                    <label class="form-check-label">Enable</label>
                </div>

            </div>
            @endforeach
        <button class="btn btn-primary mt-4">Save</button>
    </form>
</div>
@endsection
