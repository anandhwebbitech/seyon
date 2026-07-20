@extends('frontend.layouts.app')
@section('content')
    <style>
        /* Category Section Styling */
.py-5 {
    background: #f8f9fa;
}

.category-card {
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    background: #ffffff;
    border: 2px solid transparent;
}

.category-card:hover {
    border-color: #E43935;
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(228, 57, 53, 0.2) !important;
}

/* Image Container */
.category-card .ratio {
    overflow: hidden;
    background: #f5f5f5;
    position: relative;
}

.category-card .ratio::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.3) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.category-card:hover .ratio::after {
    opacity: 1;
}

.category-card .card-img-top {
    transition: transform 0.4s ease;
}

.category-card:hover .card-img-top {
    transform: scale(1.1);
}

/* Card Body */
.category-card .card-body {
    background: #ffffff;
    padding: 1rem !important;
}

/* Category Name */
.category-card h6 {
    color: #2c3e50;
    font-weight: 600;
    transition: color 0.3s ease;
}

.category-card:hover h6 {
    color: #E43935;
}

/* Button Theme */
.btn-theme {
    background: #E43935;
    color: #ffffff;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    font-size: 0.875rem;
    font-weight: 600;
    white-space: nowrap;
}

.btn-theme:hover {
    background: #c72f2b;
    color: #ffffff;
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(228, 57, 53, 0.4);
}

.btn-theme:active {
    transform: scale(0.98);
}

/* Text Color */
.text-dark-blue-gray {
    color: #2c3e50;
}

/* Image Loading */
.category-card img {
    background-color: #f5f5f5;
}

/* Responsive Design */
@media (max-width: 767.98px) {
    .category-card h6 {
        font-size: 0.875rem;
    }
    
    .btn-theme {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem !important;
    }

    .category-card:hover {
        transform: translateY(-4px);
    }
}

/* Text Truncation */
.category-card .text-truncate {
    max-width: calc(100% - 70px);
}
    </style>
    <!-- Breadcrumb Section -->
    <section class="breadcrumb-section">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a class="text-decoration-none text-dark" href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
            </ol>
        </nav>
        <h4 class="page-title">Wishlist</h4>
    </section>


    <section class="py-5">
        <div class="container">
            <div class="row">
                @if ($categories->isNotEmpty())
                    @foreach ($categories as $category)
                        <div class="col-lg-3 col-md-6 col-6 my-3">
                            <div class="card border-0 shadow-sm h-100 category-card">
                                <div class="ratio ratio-4x3">
                                    <img src="{{ asset($category->subcategory_image) }}"
                                        class="card-img-top object-fit-cover rounded-top" alt="{{ $category->name }}">
                                </div>
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 class="fw-semibold text-dark-blue-gray mb-0 text-truncate pe-2">
                                            {{ $category->name }}
                                        </h6>
                                        <a href="#" class="btn-theme btn-sm px-3 py-1 fw-semibold">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
