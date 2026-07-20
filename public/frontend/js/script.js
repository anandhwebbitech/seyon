document.addEventListener("DOMContentLoaded", () => {
    document.querySelector(".next-btnn")?.addEventListener("click", () => {
        const slider = document.querySelector(".category-slider");
        slider.scrollBy({ left: window.innerWidth, behavior: "smooth" });
    });

    document.querySelector(".prev-btn")?.addEventListener("click", () => {
        const slider = document.querySelector(".category-slider");
        slider.scrollBy({ left: -window.innerWidth, behavior: "smooth" });
    });
});


// cata

// carousel

// Get the carousel inner element and the buttons
const carouselItems = document.getElementById("carouselItems");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");

// Set the scroll distance for each slide
const scrollDistance = 250; // Adjust this value based on the width of your cards

// Function to create and add a new product card dynamically
function addProductCard(image, title, price, oldPrice, discount) {
    const newCard = document.createElement("div");
    newCard.classList.add("carousel-item");
    newCard.classList.add("active"); // Keep the new card active initially

    // newCard.innerHTML = `
    //   <div class="d-flex gap-3">
    //     <div class="card product-card">
    //       <div class="ratio ratio-4x3 position-relative">
    //         <img src="${image}" class="card-img-top object-fit-cover" alt="${title}">
    //         <span class="badge bg-warning text-dark discount-badge">${discount}</span>
    //         <div class="product-actions">
    //           <a href="#" class="btn btn-light btn-sm action" title="Wishlist"><i class="bi bi-heart"></i></a>
    //           <a href="#" class="btn btn-light btn-sm action" title="Quick view"><i class="bi bi-eye"></i></a>
    //           <a href="#" class="btn btn-primary btn-sm action" title="Add to cart"><i class="bi bi-cart"></i></a>
    //         </div>
    //       </div>
    //       <div class="card-body p-2">
    //         <p class="card-title small text-truncate-2 mb-1">${title}</p>
    //         <div class="price small">
    //           <span class="text-danger fw-semibold">${price}</span>
    //           <span class="text-muted text-decoration-line-through">${oldPrice}</span>
    //         </div>
    //       </div>
    //     </div>
    //   </div>
    // `;

    // Append new card to carousel
    // carouselItems.appendChild(newCard);

    // Ensure the carousel slides to the new card after adding it
    // carouselItems.scrollBy({
    //   left: scrollDistance,
    //   behavior: 'smooth'
    // });
}

// Example: Add a product card dynamically after 2 seconds
setTimeout(() => {
    addProductCard(
        "https://images.unsplash.com/photo-1601972599720-bd7b4f35a5ba?w=800",
        "New Product Added",
        "$300",
        "$400",
        "25% OFF"
    );
}, 2000);

document.addEventListener("DOMContentLoaded", () => {
    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");
    const carouselItems = document.querySelector(".carousel-items");
    const scrollDistance = 250; // adjust based on card width

    if (prevBtn && nextBtn && carouselItems) {
        // Navigate to previous card
        prevBtn.addEventListener("click", () => {
            carouselItems.scrollBy({
                left: -scrollDistance,
                behavior: "smooth",
            });
        });

        // Navigate to next card
        nextBtn.addEventListener("click", () => {
            carouselItems.scrollBy({
                left: scrollDistance,
                behavior: "smooth",
            });
        });
    } else {
        // console.warn("Carousel elements not found in DOM");
    }
});

// Drag scroll on the product track
const track = document.getElementById("productTrack");

let isDown = false;
let startX = 0;
let scrollLeft = 0;

// Pointer (mouse) events
track.addEventListener("mousedown", (e) => {
    isDown = true;
    track.classList.add("is-dragging");
    startX = e.pageX - track.offsetLeft;
    scrollLeft = track.scrollLeft;
});

window.addEventListener("mouseup", () => {
    isDown = false;
    track.classList.remove("is-dragging");
});

track.addEventListener("mouseleave", () => {
    isDown = false;
    track.classList.remove("is-dragging");
});

track.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - track.offsetLeft;
    const walk = x - startX; // 1px movement = 1px scroll
    track.scrollLeft = scrollLeft - walk;
});

// Touch events
track.addEventListener(
    "touchstart",
    (e) => {
        const t = e.touches[0];
        isDown = true;
        track.classList.add("is-dragging");
        startX = t.pageX - track.offsetLeft;
        scrollLeft = track.scrollLeft;
    },
    { passive: true }
);

track.addEventListener(
    "touchmove",
    (e) => {
        if (!isDown) return;
        const t = e.touches[0];
        const x = t.pageX - track.offsetLeft;
        const walk = x - startX;
        track.scrollLeft = scrollLeft - walk;
    },
    { passive: true }
);

track.addEventListener("touchend", () => {
    isDown = false;
    track.classList.remove("is-dragging");
});

// OPTIONAL: keyboard support for accessibility
track.addEventListener("keydown", (e) => {
    const step = 250; // roughly one card
    if (e.key === "ArrowRight") track.scrollBy({ left: step });
    if (e.key === "ArrowLeft") track.scrollBy({ left: -step });
});

// Dynamic add card: updated with new class names
// function addProductCard(image, title, price, oldPrice, discount) {
//   const wrapper = document.createElement("div");
//   wrapper.className = "d-flex gap-3 product-slide";

//   wrapper.innerHTML = `
//     <div class="card product-card">
//       ${discount ? `<span class="badge text-dark discount-badge">${discount}</span>` : ""}
//       <div class="ratio ratio-4x3 position-relative justify-content-center">
//         <img src="${image}" class="card-img-top object-fit-cover" alt="${title}">
//         <div class="product-actions">
//           <a href="#" class="card-btun btn-sm action" title="Wishlist"><i class="bi bi-heart"></i></a>
//           <a href="#" class="card-btun btn-sm action" title="Quick view"><i class="bi bi-eye"></i></a>
//           <a href="#" class="card-btun btn-sm action" title="Add to cart"><i class="bi bi-cart"></i></a>
//         </div>
//       </div>
//       <div class="card-body p-2">
//         <p class="card-title small text-truncate-2 mb-1">${title}</p>
//         <div class="price small">
//           <span class="text-danger fw-semibold">${price}</span>
//           ${oldPrice ? `<span class="text-muted text-decoration-line-through">${oldPrice}</span>` : ""}
//         </div>
//       </div>
//     </div>
//   `;

//   track.appendChild(wrapper);
// }

// Example add after 2s
setTimeout(() => {
    addProductCard(
        "https://images.unsplash.com/photo-1601972599720-bd7b4f35a5ba?w=800",
        "New Product Added",
        "$300",
        "$400",
        "25% OFF"
    );
}, 2000);

document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.getElementById("reelsCarousel");
    if (!carousel) return;

    const items = carousel.querySelectorAll(".carousel-item");
    const minPerSlide = 5; // match the widest breakpoint

    items.forEach((el) => {
        let next = el.nextElementSibling;
        for (let i = 1; i < minPerSlide; i++) {
            if (!next) next = items[0]; // wrap
            el.appendChild(next.firstElementChild.cloneNode(true)); // clone the card column
            next = next.nextElementSibling;
        }
    });
});

function togglePassword() {
    const passwordInput = document.getElementById("passwordInput");
    const passwordIcon = document.getElementById("passwordIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordIcon.classList.remove("fa-eye");
        passwordIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        passwordIcon.classList.remove("fa-eye-slash");
        passwordIcon.classList.add("fa-eye");
    }
}

// Add some interactive elements
document.addEventListener("DOMContentLoaded", function () {
    // Add focus animations
    const formControls = document.querySelectorAll(".form-control");
    formControls.forEach((control) => {
        control.addEventListener("focus", function () {
            this.style.transform = "translateY(-2px)";
        });

        control.addEventListener("blur", function () {
            this.style.transform = "translateY(0)";
        });
    });
});

function togglePassword(button) {
    const passwordField = document.getElementById(
        button.getAttribute("data-target")
    );
    const eyeIcon = document.getElementById(button.getAttribute("data-icon"));

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.innerHTML = `
            <path class="eye-hidden" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle class="eye-hidden" cx="12" cy="12" r="3"></circle>
        `;
    } else {
        passwordField.type = "password";
        eyeIcon.innerHTML = `
            <path class="eye-hidden" d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
            <line class="eye-hidden" x1="1" y1="1" x2="23" y2="23"></line>
        `;
    }
}

// Add some interactive feedback
document.addEventListener("DOMContentLoaded", function () {
    const inputs = document.querySelectorAll(".input-field");

    inputs.forEach((input) => {
        input.addEventListener("focus", function () {
            this.style.transform = "translateY(-1px)";
        });

        input.addEventListener("blur", function () {
            this.style.transform = "translateY(0)";
        });
    });
});

// category

// cart

// function openCart() {
//     document.getElementById("cartModal").classList.add("show");
//     document.getElementById("backdrop").classList.add("show");
// }

// function closeCart() {
//     document.getElementById("cartModal").classList.remove("show");
//     document.getElementById("backdrop").classList.remove("show");
// }

function updateQuantity(itemIndex, change) {
    const qtyInputs = document.querySelectorAll(".qty-input");
    const currentQty = parseInt(qtyInputs[itemIndex].value);
    const newQty = Math.max(0, currentQty + change);
    qtyInputs[itemIndex].value = newQty.toString().padStart(2, "0");

    updateSubtotal();
}

// function updateSubtotal() {
//     const qtyInputs = document.querySelectorAll(".qty-input");
//     const itemPrice = 14.8;
//     let total = 0;

//     qtyInputs.forEach((input) => {
//         total += parseInt(input.value) * itemPrice;
//     });

//     document.getElementById("subtotalAmount").textContent = `$${total.toFixed(
//         2
//     )}`;
// }

// Close cart when pressing Escape key
document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        closeCart();
    }
});

// Initialize cart as open for demo
setTimeout(() => {
    openCart();
}, 500);

// cart popup
// $(document).ready(function() {
//     $('#cart').on('click', function(){
//        $('#cartModal').addClass('show');
//        cartList();
//     });
//     $('.close-btn').on('click', function(){
//        $('#cartModal').removeClass('show');
//     });
//     function cartList(){
//        $.ajax()
//     }
//     function inceressQty(){

//     }
//     function decressQty(){

//     }
// });
// cart table
// function increaseQuantity(btn) {
//     const input = btn.previousElementSibling;
//     let currentValue = parseInt(input.value);
//     input.value = String(currentValue + 1).padStart(2, "0");
//     updateSubtotal();
// }

// function decreaseQuantity(btn) {
//     const input = btn.nextElementSibling;
//     let currentValue = parseInt(input.value);
//     if (currentValue > 1) {
//         input.value = String(currentValue - 1).padStart(2, "0");
//         updateSubtotal();
//     }
// }


// function updateSubtotal() {
//     // Simple calculation for demo - in real app, this would be more complex
//     const quantities = document.querySelectorAll(".quantity-input");
//     let total = 0;
//     quantities.forEach((q) => {
//         total += parseInt(q.value) * 14.8;
//     });

//     // Update displayed totals
//     const subtotalElements = document.querySelectorAll(".price-red");
//     subtotalElements.forEach((el) => {
//         el.textContent = `Rs.${total.toFixed(0)}`;
//     });
// }
// function removeItem(btn) {
//     const cartItem = btn.closest(".cart-item");
//     cartItem.style.transition = "all 0.3s ease";
//     cartItem.style.opacity = "0";
//     cartItem.style.transform = "translateX(-100%)";

//     setTimeout(() => {
//         cartItem.remove();
//         updateCartTotals();
//     }, 300);
// }
// Remove item functionality
// document.querySelectorAll(".remove-btn").forEach((btn) => {
//     btn.addEventListener("click", function () {
//         this.closest(".cart-item").remove();
//         updateSubtotal();
//     });
// });

// checkout page

// Form validation and interaction
document
    .querySelector(".place-order-btn")
    .addEventListener("click", function (e) {
        const form = document.querySelector("form");
        const requiredFields = form.querySelectorAll("[required]");
        let isValid = true;

        requiredFields.forEach((field) => {
            if (!field.value.trim()) {
                field.classList.add("is-invalid");
                isValid = false;
            } else {
                field.classList.remove("is-invalid");
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert("Please fill in all required fields.");
        } else {
            e.preventDefault();
            alert("Order placed successfully!");
        }
    });

// Remove validation styling on input
document.querySelectorAll(".form-control").forEach((field) => {
    field.addEventListener("input", function () {
        this.classList.remove("is-invalid");
    });
});

