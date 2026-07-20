@extends('frontend.layouts.app')

@section('content')
<style>
/* ==========================
   Policy Page Styles
========================== */
.policy-section {
    background-color: #f9fafb;
    color: #111213 !important; /* fallback for text */
    padding: 60px 0;
}

.policy-section h1 {
    font-size: 32px;
    font-weight: 700;
    color: #111213;
    text-align: center;
    margin-bottom: 40px;
}

.policy-content {
    background: #ffffff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    line-height: 1.8;
    font-size: 16px;
    color: #111213 !important; /* force text color */
}

/* Headings inside policy content */
.policy-content h1,
.policy-content h2,
.policy-content h3,
.policy-content h4,
.policy-content h5,
.policy-content h6 {
    margin-top: 25px;
    margin-bottom: 12px;
    font-weight: 600;
    color: #111213 !important;
}

/* Paragraphs */
.policy-content p,
.policy-content span,
.policy-content li {
    margin-bottom: 16px;
    color: #111213 !important;
}

/* Lists */
.policy-content ul,
.policy-content ol {
    padding-left: 20px;
    margin-bottom: 16px;
}

/* Links */
.policy-content a {
    color: #2563eb;
    text-decoration: underline;
}

.policy-content a:hover {
    color: #1d4ed8;
}

/* Contact block custom styling */
.contact-info-block {
    background-color: #f3f4f6;
    border-left: 4px solid #111213;
    padding: 20px;
    margin-bottom: 35px;
    border-radius: 0 8px 8px 0;
}

.contact-info-block p {
    margin-bottom: 8px !important;
}

/* Override inline white color saved from editor */
.policy-content [style*="color"] {
    color: #111213 !important;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .policy-section h1 {
        font-size: 24px;
    }

    .policy-content {
        padding: 20px;
        font-size: 15px;
    }
}
</style>

<section class="policy-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <h1>Terms &amp; Conditions</h1>

                <div class="policy-content">

                    <!-- Contact Us Block -->
                    <div class="contact-info-block">
                        <h3>Contact Us</h3>
                        <p><strong>Phone number :</strong> +91 7845630620</p>
                        <p><strong>Email Id:</strong> Seyontoys@gmail.com</p>
                        <p><strong>Whatsapp :</strong> +91 7845630620</p>
                        <p><strong>Address :</strong> 26/7, 2nd Floor, <br>
                        Nachimuthupudur 1ST cross st, <br>
                        Ellis Nagar, Dharapuram, Tiruppur-638657</p>
                        <p><strong>Instagram Link :</strong> _____________</p>
                        <p><strong>Business Hours:</strong> 9AM – 7PM (Monday to Saturday)</p>
                    </div>

                    <!-- Terms and Conditions Content -->
                    <p>Thank you for shopping with Seyon Kids.  We aim to provide you with the best possible shopping experience, including a smooth and transparent shipping process. Please read our terms and conditions carefully to understand our procedures and timelines.</p>

                    <h3>1. Order Processing Time</h3>
                    <ul>
                        <li>All orders are processed within 1-2 business days (excluding weekends and holidays) after receiving your order confirmation.</li>
                        <li>You will receive another notification when your order has shipped.</li>
                    </ul>

                    <h3>2. Shipping Rates</h3>
                    <ul>
                        <li>Shipping charges for your order will be calculated and displayed at checkout.</li>
                        <li>We offer a flat rate shipping fee of ₹ 80 for all orders within Tamil Nadu.</li>
                        <li>For orders in Kerala, Karnataka, Andhra Pradesh and Telangana the shipping rate is ₹90.</li>
                        <li>For other Indian states, its ₹ 100.</li>
                    </ul>

                    <h3>3. Delivery Estimates</h3>
                    <ul>
                        <li>Standard Shipping: 2-3 business days inside Tamil Nadu and 4-7 days for other states.</li>
                        <li>For express shipping or emergency order(s), please contact us.</li>
                        <li>Note: Delivery estimates are calculated from the time your order is shipped, not from the time you place your order. Delivery delays can occasionally occur.</li>
                    </ul>

                    <h3>4. Shipping Destinations</h3>
                    <ul>
                        <li>We ship all over India and other specific countries.</li>
                    </ul>

                    <h3>5. International Shipping</h3>
                    <ul>
                        <li>We ship internationally and the shipping cost are subject to the volume, dimension of the box and the country.</li>
                        <li>Please contact us for further details on International shipping.</li>
                    </ul>

                    <h3>6. Order Tracking</h3>
                    <ul>
                        <li>When your order has shipped, you will receive an email notification from us which will include a tracking number you can use to check its status.</li>
                        <li>Please allow 24 hours for the tracking information to become available with Professional/ST courier(s) and 48 hours for India Post.</li>
                        <li>If you haven’t received your order within the mentioned number days of receiving your shipping confirmation email, please contact us at +91 7845630620 with your name and order number, and we will look into it for you.</li>
                    </ul>

                    <h3>7. Damages and Issues</h3>
                    <ul>
                        <li>Opening video is must for any claim.</li>
                        <li>Please inspect your order upon reception and contact us immediately if the item is defective, damaged or if you receive the wrong item, so that we can evaluate the issue and make it right.</li>
                        <li>In the event that your order arrives damaged in any way, please WhatsApp us as soon as possible at +91 7845630620 with your order number and the opening video. We address these on a case-by-case basis but will try our best to work towards a satisfactory solution.</li>
                    </ul>

                    <h3>8. Incorrect Shipping Address</h3>
                    <ul>
                        <li>If you provide an incorrect shipping address during checkout, please contact us immediately at +91 7845630620.</li>
                        <li>We will do our best to update the address before the order is shipped. However, once an order has been shipped, we are unable to change the delivery address.</li>
                        <li>Customers are responsible for ensuring the accuracy of their shipping address. If a package is returned to us due to an incorrect address or unavailability of the receiver or incorrect mobile number you will be responsible for the cost of re-shipping the item.</li>
                    </ul>

                    <h3>9. Cancellation</h3>
                    <ul>
                        <li>Once an order has been placed and confirmed on our website, it cannot be cancelled for any reason. We process orders immediately to ensure quick dispatch and delivery. Please review your order carefully before completing your purchase.</li>
                    </ul>

                    <h3>10. Refund Policy (Damage in Transit Only)</h3>
                    <p>We only offer refunds in the event that your product arrives damaged during transit. We take utmost care in packaging our products, but unforeseen circumstances can occur during shipping.</p>

                    <p><strong>Conditions for Refund due to Damage in Transit:</strong></p>
                    <ul>
                        <li><strong>Mandatory Unboxing Video:</strong> To be eligible for a refund due to transit damage, you must provide an uncut, unedited, clear unboxing video from the moment you open the package until the damaged product is clearly visible. This video serves as crucial evidence for us to assess the damage and process your claim.</li>
                        <li><strong>Reporting Period:</strong> You must report the damage and submit the unboxing video to us within 24 hours of receiving your delivery. Any claims reported after this period will not be entertained.</li>
                        <li><strong>Verification:</strong> Our team will review the unboxing video and verify the damage. This verification process may take up to 1-2 business days from the time we receive your video.</li>
                        <li><strong>No Other Reasons for Refund:</strong> Please note that refunds will not be issued for any other reasons, including but not limited to:
                            <ul>
                                <li>Change of mind</li>
                                <li>Incorrect product ordered by the customer</li>
                                <li>Delays in delivery (unless explicitly covered by a separate shipping guarantee)</li>
                                <li>Minor packaging damage that does not affect the product itself</li>
                                <li>Damage caused by misuse or mishandling by the customer after delivery.</li>
                                <li>For further details, please contact +91 7845630620.</li>
                            </ul>
                        </li>
                    </ul>

                    <h3>10. Governing Law &amp; Jurisdiction</h3>
                    <p>This policy shall be governed by and construed in accordance with the laws of India, specifically the laws applicable in the State of Tamil Nadu. Any disputes arising out of or in connection with this policy shall be subject to the exclusive jurisdiction of the courts in Dharapuram, Tirupur District, Tamil Nadu, India.</p>

                </div>

            </div>
        </div>
    </div>
</section>
@endsection