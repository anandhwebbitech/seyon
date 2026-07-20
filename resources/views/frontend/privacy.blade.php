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
<section class="policy-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <h1 class="mb-4 text-center">Privacy Policy</h1>

                <div class="policy-content">
                    
                    <p>You are advised to please read the Privacy Policy carefully.</p>
                    
                    <p>This Privacy Policy provides succinctly the manner your data is collected and used by Seyon Kids. Privacy Policy of Seyon Kids and its affiliates respect your privacy. By accessing the services provided by Seyon Kids you agree to the collection and use of your data by Seyon Kids in the manner provided in this Privacy Policy.</p>
                    
                    <p>Our motive is to make you “feel comfortable using our website”. “Feel secure submitting information to us. ” contact us with your questions or concerns about privacy on this site”. “know that by using our sites you are consenting to the collection of certain data”</p>
                    
                    <p>We may collect the following personally identifiable information about you:</p>
                    <ul>
                        <li>Name including first and last name.</li>
                        <li>Alternate email address.</li>
                        <li>Mobile phone number and contact details.</li>
                        <li>ZIP/Postal code. and</li>
                        <li>Opinions of features on our websites.</li>
                        <li>Other information as per our registration process.</li>
                    </ul>

                    <p>We may also collect the following information:</p>
                    <ul>
                        <li>About the pages you visit/access.</li>
                        <li>The links you click on our site.</li>
                        <li>The number of times you access the page.</li>
                        <li>The number of times you have shopped on our web site.</li>
                    </ul>

                    <p>We collect photos for product reviews with customer consent. We may use these images for marketing purposes, respecting user privacy.</p>
                    
                    <p>The Site contains links to other Web sites. We are not responsible for the privacy practices of such Web sites which we do not own, manage or control.</p>
                    
                    <p><strong>How is the information used?</strong> We use your personal information to:</p>
                    <ul>
                        <li>Help us provide personalized features</li>
                        <li>Tailor our sites to your interest</li>
                        <li>To get in touch with you when necessary</li>
                        <li>To provide the services requested by you</li>
                        <li>T preserve social history as governed by existing law or policy</li>
                    </ul>

                    <p>Our advertisers may collect anonymous traffic information from their own assigned cookies to your browser. We will collect anonymous traffic information from you when you visit our site. We will collect personally identifiable information about you only as part of a voluntary registration process, on-line survey, or contest or any combination thereof.</p>
                    
                    <p><strong>With whom will your information be shared?</strong> We will not use your financial information for any purpose other than to complete a transaction with you. We do not rent, sell or share your personal information and we will not disclose any of your personally identifiable information to third parties unless:</p>
                    <ul>
                        <li>we have your permission</li>
                        <li>to provide products or services you’ve requested</li>
                        <li>to help investigate, prevent or take action regarding unlawful and illegal activities, suspected fraud, potential threat to the safety or security of any person, violations of Seyon Kids terms of use or to defend against legal claims</li>
                        <li>Special circumstances such as compliance with subpoenas, court orders, requests/order, notices from legal authorities or law enforcement agencies requiring such disclosure</li>
                    </ul>

                    <p>We share your information with advertisers on an aggregate basis only.</p>
                    
                    <p><strong>What choices are available to you regarding collection, use and distribution of your information?</strong> You may change your interests at any time and may opt-in or opt-out of any marketing / promotional / newsletters mailings. Seyon Kids reserves the right to send you certain service related communication, considered to be a part of your Seyon Kids account without offering you the facility to opt-out. You may update your information and change your account settings at any time.</p>
                    
                    <p><strong>Policy updates:</strong> We reserve the right to change or update this policy at any time by placing a prominent notice on our site. Such changes shall be effective immediately upon posting to this site.</p>

                </div>

            </div>
        </div>
    </div>
</section>
@endsection