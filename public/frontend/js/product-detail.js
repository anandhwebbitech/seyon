document.addEventListener("DOMContentLoaded", function () {
    function changeImage(thumbnail) {
        document.getElementById("mainImage").src = thumbnail.src;
        document.querySelectorAll(".thumbnail").forEach((img) => {
            img.classList.remove("active");
        });

        thumbnail.classList.add("active");
    }

    document.getElementById("nextBtn").addEventListener("click", function () {
        let thumbnails = document.querySelectorAll(".thumbnail");
        let activeIndex = Array.from(thumbnails).findIndex((img) =>
            img.classList.contains("active")
        );
        let nextIndex = (activeIndex + 1) % thumbnails.length;
        thumbnails[nextIndex].click();
    });

    document.getElementById("prevBtn").addEventListener("click", function () {
        let thumbnails = document.querySelectorAll(".thumbnail");
        let activeIndex = Array.from(thumbnails).findIndex((img) =>
            img.classList.contains("active")
        );
        let prevIndex =
            (activeIndex - 1 + thumbnails.length) % thumbnails.length;
        thumbnails[prevIndex].click();
    });

    // // Quantity controls
    // function increaseQuantity() {
    //     const quantityInput = document.getElementById("quantity");
    //     let currentValue = parseInt(quantityInput.value);
    //     if (currentValue < 99) {
    //         quantityInput.value = String(currentValue + 1).padStart(2, "0");
    //     }
    // }

    // function decreaseQuantity() {
    //     const quantityInput = document.getElementById("quantity");
    //     let currentValue = parseInt(quantityInput.value);
    //     if (currentValue > 1) {
    //         quantityInput.value = String(currentValue - 1).padStart(2, "0");
    //     }
    // }

    // Wishlist functionality
    // document.querySelector(".wishlist-btn")
    // .addEventListener("click", function () {
    //     const icon = this.querySelector("i");
    //     if (icon.classList.contains("far")) {
    //         icon.classList.remove("far");
    //         icon.classList.add("fas");
    //         this.style.color = "#dc3545";
    //     } else {
    //         icon.classList.remove("fas");
    //         icon.classList.add("far");
    //         this.style.color = "#6c757d";
    //     }
    // });

    const quantityInput = document.getElementById("quantity");

    // Countdown timer
    // function updateCountdown() {
    //     const now = new Date().getTime();
    //     const countdownEnd = now + 5 * 60 * 1000 + 59 * 1000 + 470; // 5:59:47 from now

    //     const interval = setInterval(function () {
    //         const now = new Date().getTime();
    //         const distance = countdownEnd - now;

    //         const hours = Math.floor(
    //             (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    //         );
    //         const minutes = Math.floor(
    //             (distance % (1000 * 60 * 60)) / (1000 * 60)
    //         );
    //         const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    //         const milliseconds = Math.floor((distance % 1000) / 10);

    //         document.getElementById("hours").textContent = String(
    //             hours
    //         ).padStart(2, "0");
    //         document.getElementById("minutes").textContent = String(
    //             minutes
    //         ).padStart(2, "0");
    //         document.getElementById("seconds").textContent = String(
    //             seconds
    //         ).padStart(2, "0");
    //         document.getElementById("milliseconds").textContent = String(
    //             milliseconds
    //         ).padStart(2, "0");

    //         if (distance < 0) {
    //             clearInterval(interval);
    //             document.querySelector(".countdown-text").textContent =
    //                 "Sale has ended!";
    //             document.getElementById("hours").textContent = "00";
    //             document.getElementById("minutes").textContent = "00";
    //             document.getElementById("seconds").textContent = "00";
    //             document.getElementById("milliseconds").textContent = "00";
    //         }
    //     }, 10);
    // }

    // Wishlist functionality
    // document.querySelector(".wishlist-btn")
    //     .addEventListener("click", function () {
    //         const icon = this.querySelector("i");
    //         if (icon.classList.contains("far")) {
    //             icon.classList.remove("far");
    //             icon.classList.add("fas");
    //             this.style.color = "#dc3545";
    //         } else {
    //             icon.classList.remove("fas");
    //             icon.classList.add("far");
    //             this.style.color = "#6c757d";
    //         }
    //     });

    // Initialize countdown
    // updateCountdown();

    // const wishlistBtn = document.querySelector(".wishlist-btn");

    // wishlistBtn.addEventListener("click", function () {
    //     const icon = this.querySelector("i");
    //     const textNode = this.childNodes[2]; // the text node after the icon

    //     if (icon.classList.contains("far")) {
    //         // Fill the heart and update text
    //         icon.classList.replace("far", "fas");
    //         icon.style.color = "#dc3545"; // red color
    //         textNode.textContent = " Added to Wishlist";
    //     } else {
    //         // Empty the heart and revert text
    //         icon.classList.replace("fas", "far");
    //         icon.style.color = "#6c757d"; // gray color
    //         textNode.textContent = " Add to Wishlist";
    //     }
    // });
});

// copy
function copyUrl() {
    const copyText = document.getElementById("myInput").value;
    navigator.clipboard.writeText(copyText).catch((err) => {});
}

// cate

// Cross-browser compatible JavaScript with helper function
document.addEventListener("DOMContentLoaded", function () {
    // Cross-browser closest() polyfill
    function findClosest(element, selector) {
        if (!element) return null;

        // Check if element itself matches
        if (element.matches && element.matches(selector)) {
            return element;
        }

        // Traverse up the DOM tree
        var current = element.parentElement;
        while (current && current !== document) {
            if (current.matches && current.matches(selector)) {
                return current;
            }
            current = current.parentElement;
        }
        return null;
    }

    // View toggle functionality
    // document.addEventListener("click", function (e) {
    //     var target = e.target;
    //     var clickedBtn = findClosest(target, ".view-btn");

    //     if (clickedBtn) {
    //         var parentContainer = findClosest(clickedBtn, ".view-toggle");

    //         if (parentContainer) {
    //             var siblingBtns = parentContainer.querySelectorAll(".view-btn");
    //             for (var i = 0; i < siblingBtns.length; i++) {
    //                 siblingBtns[i].classList.remove("active");
    //             }
    //             clickedBtn.classList.add("active");
    //         }
    //     }
    // });

    
    // Dropdown functionality
    // document.addEventListener("click", function (e) {
    //     var target = e.target;
    //     var clickedItem = findClosest(target, ".dropdown-item");

    //     if (clickedItem) {
    //         e.preventDefault();

    //         var dropdown = findClosest(clickedItem, ".dropdown");

    //         if (dropdown) {
    //             var dropdownItems = dropdown.querySelectorAll(".dropdown-item");
    //             var dropdownToggleSpan = dropdown.querySelector(
    //                 ".dropdown-toggle span"
    //             );

    //             // Remove active class from all items in this dropdown
    //             for (var i = 0; i < dropdownItems.length; i++) {
    //                 dropdownItems[i].classList.remove("active");
    //             }

    //             // Add active class to clicked item
    //             clickedItem.classList.add("active");

    //             // Update dropdown button text
    //             if (dropdownToggleSpan) {
    //                 dropdownToggleSpan.textContent = clickedItem.textContent;
    //             }
    //         }
    //     }
    // });

    // Product card hover effects
    document.addEventListener("mouseover", function (e) {
        var target = e.target;
        var card = findClosest(target, ".product-card");

        if (card) {
            card.style.transform = "translateY(-5px)";
            card.style.transition = "transform 0.3s ease, box-shadow 0.3s ease";
        }
    });

    document.addEventListener("mouseout", function (e) {
        var target = e.target;
        var card = findClosest(target, ".product-card");

        if (card) {
            // Check if we're still inside the card
            var relatedTarget = e.relatedTarget;
            if (
                !relatedTarget ||
                !findClosest(relatedTarget, ".product-card")
            ) {
                card.style.transform = "translateY(0)";
            }
        }
    });

    // Filter functionality for categories
    document.addEventListener("change", function (e) {
        var target = e.target;

        if (target.type === "checkbox" && findClosest(target, ".sidebar")) {
            var checkbox = target;
            var label = checkbox.nextElementSibling;

            if (label) {
                if (checkbox.checked) {
                    label.style.fontWeight = "600";
                    label.style.color = "#dc3545";
                } else {
                    label.style.fontWeight = "400";
                    label.style.color = "#666";
                }
            }
        }
    });

    // price filetr

    // class PriceSlider {
    //     constructor() {
    //         this.minPrice = 0;
    //         this.maxPrice = 200;
    //         this.currentMin = 0;
    //         this.currentMax = 200;
    //         this.isDragging = null;

    //         this.sliderContainer = document.getElementById("sliderContainer");
    //         this.sliderTrack = document.getElementById("sliderTrack");
    //         this.minThumb = document.getElementById("minThumb");
    //         this.maxThumb = document.getElementById("maxThumb");
    //         this.minPriceLabel = document.getElementById("minPrice");
    //         this.maxPriceLabel = document.getElementById("maxPrice");
    //         this.minInput = document.getElementById("minInput");
    //         this.maxInput = document.getElementById("maxInput");

    //         this.init();
    //     }

    //     init() {
    //         this.updateSlider();
    //         this.bindEvents();
    //     }

    //     bindEvents() {
    //         // Thumb dragging events
    //         this.minThumb.addEventListener("mousedown", (e) =>
    //             this.startDrag(e, "min")
    //         );
    //         this.maxThumb.addEventListener("mousedown", (e) =>
    //             this.startDrag(e, "max")
    //         );

    //         // Global mouse events
    //         document.addEventListener("mousemove", (e) => this.drag(e));
    //         document.addEventListener("mouseup", () => this.stopDrag());

    //         // Input events
    //         this.minInput.addEventListener("input", () =>
    //             this.handleInputChange()
    //         );
    //         this.maxInput.addEventListener("input", () =>
    //             this.handleInputChange()
    //         );

    //         // Prevent text selection during drag
    //         this.sliderContainer.addEventListener("selectstart", (e) =>
    //             e.preventDefault()
    //         );
    //     }

    //     startDrag(e, thumb) {
    //         this.isDragging = thumb;
    //         const thumbElement =
    //             thumb === "min" ? this.minThumb : this.maxThumb;
    //         thumbElement.classList.add("dragging");
    //         e.preventDefault();
    //     }

    //     drag(e) {
    //         if (!this.isDragging) return;

    //         const rect = this.sliderContainer.getBoundingClientRect();
    //         const percentage = Math.max(
    //             0,
    //             Math.min(1, (e.clientX - rect.left) / rect.width)
    //         );
    //         const value = Math.round(
    //             percentage * (this.maxPrice - this.minPrice) + this.minPrice
    //         );

    //         if (this.isDragging === "min") {
    //             this.currentMin = Math.min(value, this.currentMax - 1);
    //         } else if (this.isDragging === "max") {
    //             this.currentMax = Math.max(value, this.currentMin + 1);
    //         }

    //         this.updateSlider();
    //         this.updateInputs();
    //     }

    //     stopDrag() {
    //         if (this.isDragging) {
    //             const thumbElement =
    //                 this.isDragging === "min" ? this.minThumb : this.maxThumb;
    //             thumbElement.classList.remove("dragging");
    //             this.isDragging = null;
    //         }
    //     }

    //     handleInputChange() {
    //         const minVal = parseInt(this.minInput.value) || 0;
    //         const maxVal = parseInt(this.maxInput.value) || 200;

    //         this.currentMin = Math.max(
    //             this.minPrice,
    //             Math.min(minVal, maxVal - 1)
    //         );
    //         this.currentMax = Math.min(
    //             this.maxPrice,
    //             Math.max(maxVal, this.currentMin + 1)
    //         );

    //         this.updateSlider();
    //         this.updateInputs();
    //     }

    //     updateSlider() {
    //         const minPercent =
    //             ((this.currentMin - this.minPrice) /
    //                 (this.maxPrice - this.minPrice)) *
    //             100;
    //         const maxPercent =
    //             ((this.currentMax - this.minPrice) /
    //                 (this.maxPrice - this.minPrice)) *
    //             100;

    //         // Update track
    //         this.sliderTrack.style.left = minPercent + "%";
    //         this.sliderTrack.style.width = maxPercent - minPercent + "%";

    //         // Update thumbs
    //         this.minThumb.style.left = minPercent + "%";
    //         this.maxThumb.style.left = maxPercent + "%";

    //         // Update labels
    //         this.minPriceLabel.textContent = this.currentMin;
    //         this.maxPriceLabel.textContent = this.currentMax;
    //     }

    //     updateInputs() {
    //         this.minInput.value = this.currentMin;
    //         this.maxInput.value = this.currentMax;
    //     }

    //     reset() {
    //         console.log("Reset button clicked");
    //         this.currentMin = this.minPrice;
    //         this.currentMax = this.maxPrice;
    //         this.updateSlider();
    //         this.updateInputs();
    //     }
    // }

    // const priceSlider = new PriceSlider();

    window.resetSlider = function () {
        priceSlider.reset();
    };

    // Price filter functionality
    // document.addEventListener("change", function (e) {
    //     var target = e.target;

    //     if (target.type === "radio" && target.name === "price") {
    //         var radio = target;
    //         var allPriceLabels = document.querySelectorAll(
    //             'input[name="price"] + label'
    //         );

    //         // Reset all labels
    //         for (var i = 0; i < allPriceLabels.length; i++) {
    //             allPriceLabels[i].style.fontWeight = "400";
    //             allPriceLabels[i].style.color = "#666";
    //         }

    //         // Highlight selected price range
    //         if (radio.checked && radio.nextElementSibling) {
    //             var selectedLabel = radio.nextElementSibling;
    //             selectedLabel.style.fontWeight = "600";
    //             selectedLabel.style.color = "#dc3545";
    //         }
    //     }
    // });

    // Initialize default states
    function initializeDefaults() {
        var defaultBagsCheckbox = document.getElementById("bags");
        if (defaultBagsCheckbox && defaultBagsCheckbox.checked) {
            var label = defaultBagsCheckbox.nextElementSibling;
            if (label) {
                label.style.fontWeight = "600";
                label.style.color = "#dc3545";
            }
        }

        var defaultPriceRadio = document.getElementById("all");
        if (defaultPriceRadio && defaultPriceRadio.checked) {
            var label = defaultPriceRadio.nextElementSibling;
            if (label) {
                label.style.fontWeight = "600";
                label.style.color = "#dc3545";
            }
        }
    }

    // Run initialization
    initializeDefaults();

    // Utility functions for dynamic content
    window.ProductListingUtils = {
        reinitialize: function () {
            initializeDefaults();
        },

        addProductCard: function (container, cardHtml) {
            if (container && container.insertAdjacentHTML) {
                container.insertAdjacentHTML("beforeend", cardHtml);
            }
        },

        addDropdown: function (container, dropdownHtml) {
            if (container && container.insertAdjacentHTML) {
                container.insertAdjacentHTML("beforeend", dropdownHtml);
            }
        },
    };
});

// slider

// (function () {
//     const minInput = document.getElementById("price-min");
//     const maxInput = document.getElementById("price-max");
//     const fill = document.getElementById("range-fill");
//     const label = document.getElementById("price-label");
//     const minHidden = document.getElementById("price-min-hidden");
//     const maxHidden = document.getElementById("price-max-hidden");

//     const MIN = +minInput.min,
//         MAX = +minInput.max;

//     function clampHandles() {
//         // keep at least 1 step between handles if you want; set to 0 for touching
//         const STEP_GAP = 0;
//         if (+minInput.value > +maxInput.value - STEP_GAP) {
//             minInput.value = +maxInput.value - STEP_GAP;
//         }
//         if (+maxInput.value < +minInput.value + STEP_GAP) {
//             maxInput.value = +minInput.value + STEP_GAP;
//         }
//     }

//     function updateUI() {
//         const minVal = +minInput.value;
//         const maxVal = +maxInput.value;

//         // position fill
//         const left = ((minVal - MIN) / (MAX - MIN)) * 100;
//         const right = 100 - ((maxVal - MIN) / (MAX - MIN)) * 100;
//         fill.style.left = left + "%";
//         fill.style.right = right + "%";

//         // label
//         if (minVal === MIN && maxVal === MAX) {
//             label.textContent = "All";
//         } else {
//             label.textContent = `$${minVal}–$${maxVal}`;
//         }

//         // hidden values for form submits
//         minHidden.value = minVal;
//         maxHidden.value = maxVal;

//         // dispatch a custom event if your product grid listens for changes
//         const evt = new CustomEvent("priceRangeChange", {
//             detail: { min: minVal, max: maxVal },
//         });
//         document.getElementById("price-filter").dispatchEvent(evt);
//     }

//     function onInput() {
//         clampHandles();
//         updateUI();
//     }

//     minInput.addEventListener("input", onInput);
//     maxInput.addEventListener("input", onInput);

//     // initial paint
//     updateUI();
// })();


// document.addEventListener("DOMContentLoaded", function () {
//     const mainImage = document.getElementById("mainImage");
//     const zoomResult = document.getElementById("zoomResult");
//     const thumbnails = document.querySelectorAll(".thumbnail");
//     const prevBtn = document.getElementById("prevBtn");
//     const nextBtn = document.getElementById("nextBtn");

//     let currentIndex = 0;

//     // Update main image + zoom background
//     function updateMainImage(index) {
//         const newSrc = thumbnails[index].getAttribute("src");
//         mainImage.setAttribute("src", newSrc);
//         zoomResult.style.backgroundImage = `url(${newSrc})`;
//         currentIndex = index;

//         thumbnails.forEach((thumb, i) => {
//             thumb.classList.toggle("active", i === index);
//         });
//     }

//     // Thumbnail click
//     thumbnails.forEach((thumb, index) => {
//         thumb.addEventListener("click", () => updateMainImage(index));
//     });

//     // Prev/Next
//     prevBtn.addEventListener("click", () => {
//         currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
//         updateMainImage(currentIndex);
//     });
//     nextBtn.addEventListener("click", () => {
//         currentIndex = (currentIndex + 1) % thumbnails.length;
//         updateMainImage(currentIndex);
//     });

//     // Zoom effect
//     mainImage.addEventListener("mousemove", (e) => {
//         zoomResult.style.display = "block";
//         const rect = mainImage.getBoundingClientRect();
//         const x = ((e.pageX - rect.left - window.pageXOffset) / rect.width) * 100;
//         const y = ((e.pageY - rect.top - window.pageYOffset) / rect.height) * 100;

//         zoomResult.style.backgroundPosition = `${x}% ${y}%`;
//     });

//     mainImage.addEventListener("mouseleave", () => {
//         zoomResult.style.display = "none";
//     });

//     // Init
//     updateMainImage(currentIndex);
// });

document.addEventListener("DOMContentLoaded", function () {
    const mainImage = document.getElementById("mainImage");
    const zoomResult = document.getElementById("zoomResult");
    const thumbnails = document.querySelectorAll(".thumbnail");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");

    let currentIndex = 0;

    function setActive(index) {
        thumbnails.forEach((thumb, i) => {
            thumb.classList.toggle("active", i === index);
        });
    }

    function updateMainImage(index) {
        const newSrc = thumbnails[index].getAttribute("src");
        mainImage.setAttribute("src", newSrc);
        zoomResult.style.backgroundImage = `url(${newSrc})`;
        currentIndex = index;
        setActive(index);
    }

    // Thumbnails click
    thumbnails.forEach((thumb, index) => {
        thumb.addEventListener("click", () => updateMainImage(index));
    });

    // Prev/Next
    prevBtn.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
        updateMainImage(currentIndex);
    });
    nextBtn.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % thumbnails.length;
        updateMainImage(currentIndex);
    });

    // Zoom effect
    mainImage.addEventListener("mousemove", (e) => {
        zoomResult.style.display = "block";
        const rect = mainImage.getBoundingClientRect();
        const x = ((e.pageX - rect.left - window.pageXOffset) / rect.width) * 100;
        const y = ((e.pageY - rect.top - window.pageYOffset) / rect.height) * 100;
        zoomResult.style.backgroundPosition = `${x}% ${y}%`;
    });
    mainImage.addEventListener("mouseleave", () => {
        zoomResult.style.display = "none";
    });

    // Init
    updateMainImage(currentIndex);
});


// swiper slider home

document.addEventListener("DOMContentLoaded", function () {
  new Swiper(".categorySwiper", {
    slidesPerView: 3,
    spaceBetween: 20,
    loop: true,
    navigation: {
      nextEl: ".swiper-next",
      prevEl: ".swiper-prev",
    },
    breakpoints: {
      320: { slidesPerView: 1.3, spaceBetween: 10 },
      576: { slidesPerView: 2, spaceBetween: 15 },
      992: { slidesPerView: 3, spaceBetween: 20 },
    },
  });
});