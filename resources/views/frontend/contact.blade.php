@extends('frontend.layouts.app')
@section('content')
    <div class="page-banner">
        <div class="container">
            <ul class="navigation-list">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Contact</li>
            </ul>
        </div>
    </div>


    <div class="contact">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-6">
                    <div class="contact-left">
                        <h1 class="contact-title">Contact Info</h1>
                        <p class="main-text mb-2">Are you ready to transform your space? Get in touch with junglly today for
                            a consultation.
                        </p>
                        <div class="contact-detail mt-4">
                            <div class="icon">
                                <i class="bi bi-telephone-inbound"></i>
                            </div>
                            <div class="text">
                                <h6 class="reservation-text">Phone Number</h6>
                                <p class="reservation-title">
                                    <a href="tel:+917845630620">
                                        <i class="fas fa-phone-alt me-2"></i> +91 78456 30620
                                    </a>
                                </p>

                                <br>

                                <h6 class="reservation-text">WhatsApp Number</h6>
                                <p class="reservation-title">
                                    <a href="https://wa.me/917845630620" target="_blank">
                                        <i class="fab fa-whatsapp me-2 text-success"></i> +91 78456 30620
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="contact-detail">
                            <div class="icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="text">
                                <h6 class="reservation-text">Email Info</h6>
                                <p class="reservation-title">
                                    <a href="mailto:seyontoys@gmail.com">
                                        <i class="fas fa-envelope me-2"></i> seyontoys@gmail.com
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="contact-detail">
                            <div class="icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="text">
                                <h6 class="reservation-text">Address</h6>
                                <p class="reservation-title">
                                    <a href="https://maps.app.goo.gl/ZNcZqkquE2QRGk5H7"
                                    target="_blank">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        26/7, 2nd Floor,<br>
                                        Nachimuthupudur 1st Cross St,<br>
                                        Ellis Nagar, Dharapuram,<br>
                                        Tiruppur - 638657
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="contact-detail">
                            <div class="icon">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div class="text">
                                <h6 class="reservation-text">Business Hours:</h6>
                                <p class="reservation-title"><a>9AM –7PM (Monday to Saturday)</a></p>
                            </div>
                        </div>
                        <div class="contact-detail">
                            <div class="icon">
                                <i class="bi bi-instagram"></i>
                            </div>
                            <div class="text">
                                <h6 class="reservation-text">Instagram</h6>
                                <p class="reservation-title">
                                    <a href="https://www.instagram.com/seyon_kids/" target="_blank">
                                        @seyon_kids
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-right">
                        <h1 class="get-title">Get In Touch</h1>
                        @if (session('success'))
                            <div id="success-message" class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            <script>
                                // Automatically hide the success message after 5 seconds
                                setTimeout(function() {
                                    document.getElementById('success-message').style.display = 'none';
                                }, 5000); // 5000 milliseconds = 5 seconds
                            </script>
                        @endif

                        <form class="row gx-lg-3 gy-3" method="POST" action="{{ route('contact.send') }}">
                            @csrf
                            <div class="col-md-6">
                                <div class="input-container">
                                    <i class="fa fa-user icon"></i>
                                    <input class="form-control" type="text" placeholder="Username" name="name"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-container">
                                    <i class="fa-regular fa-envelope icon"></i>
                                    <input class=" form-control" type="email" placeholder="Email" name="email" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-container">
                                    <i class="fa-solid fa-phone icon"></i>
                                    <input class=" form-control" type="text" placeholder="Phone" name="phone" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-container">
                                    <i class="fa-solid fa-pencil icon"></i>
                                    <input class=" form-control" type="text" placeholder="subject" name="subject"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-container">
                                    <i class="fa-solid fa-pencil icon"></i>
                                    <textarea class="form-control" rows="3" name="message"
                                        placeholder="How We Can Help You? Feel free to get in touch!" required></textarea>
                                </div>

                            </div>
                            <div style="display:none;">
                                <input type="text" name="website">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="contact-common-btn">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d250880.83976261524!2d77.5121142!3d10.7334711!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba9bf8b1bc0cd21%3A0x99e6a750d41e2ee9!2sSeyon%20Kids!5e0!3m2!1sen!2sin!4v1765797279484!5m2!1sen!2sin"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Contact Page Styles - Seyon Theme */

        /* Page Banner */

        .navigation-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .navigation-list li {
            color: #fff;
            font-size: 16px;
            font-weight: 500;
        }

        .navigation-list li::after {
            content: '>';
            margin-left: 15px;
            opacity: 0.7;
        }

        .navigation-list li:last-child::after {
            content: '';
        }

        .navigation-list a {
            color: #fff;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .navigation-list a:hover {
            opacity: 0.8;
        }

        /* Contact Section */
        .contact {
            padding: 60px 0;
            background: #f8f9fa;
        }

        .contact-left {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .contact-title {
            font-size: 36px;
            font-weight: 700;
            color: #2d3436;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 15px;
        }

        .contact-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #e53935, #e53935);
            border-radius: 2px;
        }

        .main-text {
            color: #636e72;
            font-size: 16px;
            line-height: 1.8;
        }

        .contact-detail {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 25px;
            margin-top: 20px;
            background: #f8f9fa;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .contact-detail:hover {
            background: #fff;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .contact-detail .icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #E53935 0%, #E53935 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .contact-detail .icon i {
            font-size: 22px;
            color: #fff;
        }

        .reservation-text {
            font-size: 14px;
            color: #95a5a6;
            margin-bottom: 5px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .reservation-title {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: black;
        }

        .reservation-title a {
            color: #2d3436;
            text-decoration: none;
            transition: color 0.3s;
        }

        .reservation-title a:hover {
            color: #FF6B6B;
        }

        /* Contact Form */
        .contact-right {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        .get-title {
            font-size: 36px;
            font-weight: 700;
            color: #2d3436;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }

        .get-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #e53935, #e53935);
            border-radius: 2px;
        }

        .input-container {
            position: relative;
            margin-bottom: 0;
        }

        .input-container .icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #95a5a6;
            font-size: 16px;
            z-index: 2;
        }

        .input-container textarea+.icon {
            top: 20px;
            transform: none;
        }

        .input-container .form-control {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .input-container .form-control:focus {
            outline: none;
            border-color: #FF6B6B;
            background: #fff;
            box-shadow: 0 5px 20px rgba(255, 107, 107, 0.1);
        }

        .input-container textarea.form-control {
            resize: vertical;
            min-height: 120px;
            padding-top: 15px;
        }

        .contact-common-btn {
            background: linear-gradient(135deg, #e53935 0%, #e53935 100%);
            color: #fff;
            padding: 15px 40px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
        }

        .common-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(255, 107, 107, 0.4);
        }

        .common-btn:active {
            transform: translateY(-1px);
        }

        /* Alert Messages */
        .alert-success {
            background: linear-gradient(135deg, #00b894 0%, #00cec9 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 25px;
            font-weight: 500;
            box-shadow: 0 5px 20px rgba(0, 184, 148, 0.2);
        }

        /* Map Container */
        .col-lg-12 iframe {
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }

        /* Responsive Design */
        @media (max-width: 991px) {

            .contact-left,
            .contact-right {
                padding: 30px;
            }

            .contact-title,
            .get-title {
                font-size: 28px;
            }

            .contact-detail {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .page-banner {
                padding: 30px 0;
            }

            .contact {
                padding: 40px 0;
            }

            .contact-left,
            .contact-right {
                padding: 25px;
                margin-bottom: 20px;
            }

            .contact-title,
            .get-title {
                font-size: 24px;
            }

            .contact-detail .icon {
                width: 45px;
                height: 45px;
            }

            .contact-detail .icon i {
                font-size: 20px;
            }

            .common-btn {
                width: 100%;
                padding: 15px 30px;
            }
        }
    </style>
@endsection