<footer class="footer">
    <div class="container mb-5">
        <div class="row">
            <!-- About Us -->
            <div class="col-md-4 footer-logo wit">
                <img src="{{ asset('frontend/img/footer-logo.png') }}" alt="Logo">
                <p class="text-white">At Seyon, we deliver best quality of products for kids that combine learning and play.</p>
            </div>



            <!-- Quick Links -->
            <div class="col-md-3 wit">
                <h3 class="mb-4">Quick Links</h3>
                <div class="quick-links ms-2">
                    @php
                        $categories = \App\Models\ProductCategory::where('status', 1)->get();
                    @endphp
                    @foreach ($categories as $category)
                        <a href="{{ route('category.list') }}?selected_categories[]={{ $category->id }}">{{ $category->name }}</a>
                    @endforeach
                    <a href="{{ route('privacy_policy') }}">Privacy Policy</a>
                    <a href="{{ route('terms_condition') }}">Terms & Conditions</a>
                </div>
            </div>
             <!-- Contact Us -->
            <div class="col-md-4 wit">
                <h3 class="mb-4">Contact US</h3>
                <p><i class="fa-solid fa-envelope"></i><a href="mailto:Seyontoys@gmail.com">Seyontoys@gmail.com</a></p>
                <p><i class="fa-solid fa-location-dot"></i>26/7, 2ndFloor,<br> Nachimuthupudur 1STcross st,<br> Ellis Nagar, Dharapuram,<br> Tiruppur-638657</p>
                <p><i class="fa-solid fa-phone"></i><a href="tel:+917845630620">+91 78456 30620</a></p>
            </div>
        </div>
    </div>
    <div class="bottom-foot">
        <div class="container">
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p>© {{ date('Y') }} Seyonkids. All rights reserved. Developed by <a style="color: #ADB7BC"
                            href="https://webbitech.com/">Webbitech</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js    "></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>


<script>
    const swiper = new Swiper('#newArrivals', {
        speed: 500,
        spaceBetween: 12,
        slidesPerView: 1, // Default for mobile
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            240: {
                slidesPerView: 1
            }, // tablets
            768: {
                slidesPerView: 2
            }, // desktops
            920: {
                slidesPerView: 3
            }, // tablets
            992: {
                slidesPerView: 5
            }, // desktops
        },
    });
</script>
