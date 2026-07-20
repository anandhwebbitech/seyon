@extends('frontend.layouts.app')
@section('content')
    <style>
        .confirmation-container {
            background: white;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 500px;
            animation: fallDown 1s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes fallDown {
            0% {
                opacity: 0;
                transform: translateY(-100vh) rotate(-20deg) scale(0.3);
            }

            60% {
                transform: translateY(30px) rotate(5deg) scale(1.1);
            }

            80% {
                transform: translateY(-15px) rotate(-3deg) scale(0.95);
            }

            100% {
                opacity: 1;
                transform: translateY(0) rotate(0deg) scale(1);
            }
        }

        .checkmark-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: popRotate 0.6s ease-out 1s both;
        }

        @keyframes popRotate {
            0% {
                transform: scale(0) rotate(-180deg);
                opacity: 0;
            }

            50% {
                transform: scale(1.2) rotate(10deg);
            }

            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        .checkmark {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: block;
            stroke-width: 3;
            stroke: #fff;
            stroke-miterlimit: 10;
            box-shadow: inset 0px 0px 0px #667eea;
            animation: fill 0.4s ease-in-out 1.3s forwards, scale 0.3s ease-in-out 1.7s both;
        }

        .checkmark-circle-inner {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 3;
            stroke-miterlimit: 10;
            stroke: #fff;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) 1.3s forwards;
        }

        .checkmark-check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 1.6s forwards;
        }

        @keyframes stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes scale {

            0%,
            100% {
                transform: none;
            }

            50% {
                transform: scale3d(1.1, 1.1, 1);
            }
        }

        h1 {
            color: #333;
            font-weight: 700;
            margin-bottom: 15px;
            animation: slideInLeft 0.6s ease-out 1.4s both;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Button Styling for tk-butn class */

        .tk-butn {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 14px 40px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .tk-butn:hover {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px #11998e;
            color: white;
        }

        .tk-butn:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px #11998e;
        }

        /* .tk-butn:focus {
            outline: none;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3), 0 0 0 3px rgba(231, 76, 60, 0.1);
        } */

        /* Responsive Design */
        @media (max-width: 768px) {
            .tk-butn {
                padding: 12px 30px;
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            .tk-butn {
                padding: 12px 25px;
                font-size: 14px;
                width: 100%;
                display: block;
            }
        }

        .order-details {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            animation: fadeIn 0.6s ease-out 2s both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .order-details p {
            margin: 10px 0;
            color: #666;
            font-size: 16px;
        }

        .order-number {
            color: #667eea;
            font-weight: 600;
            font-size: 18px;
        }

        .btn-primari {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
            padding: 12px 40px;
            border-radius: 50px;
            font-weight: 600;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: zoomIn 0.5s ease-out 1.8s both;
            cursor: pointer;
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .btn-primari:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(17, 153, 142, 0.4);
        }

        .text-muted {
            animation: fadeIn 0.6s ease-out 1.6s both;
        }

        .display-7 {
            animation: fadeIn 0.6s ease-out 2s both;
        }

        /* Glitter Animation */
        .glitter-particle {
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            border-radius: 50%;
            animation: glitterFall linear forwards;
        }

        @keyframes glitterFall {
            0% {
                transform: translateY(0) rotate(0deg) scale(1);
                opacity: 1;
            }

            50% {
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) rotate(720deg) scale(0.3);
                opacity: 0;
            }
        }

        /* Confetti Animation */
        .confetti {
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            animation: confetti-fall 3s linear forwards;
        }

        .p-relative {
            position: relative;
        }

        @keyframes confetti-fall {
            to {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
    <div class="d-flex justify-content-center align-items-center py-5 p-relative">
        <div class="confirmation-container">
            <div class="checkmark-circle">
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark-circle-inner" cx="26" cy="26" r="25" fill="none" />
                    <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                </svg>
            </div>

            <h1>Order Confirmed!</h1>
            <p class="text-muted">Thank you for your purchase</p>

            <button class="btn-primary tk-butn text-light" onclick="window.location.href='#'">Continue Shopping</button>
            <p class="display-7 my-3 text-dark">Redirecting in <span id="countdown">5</span> seconds...</p>
        </div>
        <div class="glitter-particle"></div>
    </div>
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Create glitter effect
    function createGlitter() {
        const colors = [
            'linear-gradient(45deg, #ffd700, #ffed4e)',
            'linear-gradient(45deg, #ff6b6b, #ff8e53)',
            'linear-gradient(45deg, #4facfe, #00f2fe)',
            'linear-gradient(45deg, #fa709a, #fee140)',
            'linear-gradient(45deg, #a8edea, #fed6e3)',
            'linear-gradient(45deg, #ff9a9e, #fecfef)'
        ];

        for (let i = 0; i < 100; i++) {
            setTimeout(() => {
                const glitter = document.createElement('div');
                glitter.className = 'glitter-particle';

                const size = Math.random() * 8 + 4;
                glitter.style.width = size + 'px';
                glitter.style.height = size + 'px';
                glitter.style.left = Math.random() * 100 + '%';
                glitter.style.top = '-20px';
                glitter.style.background = colors[Math.floor(Math.random() * colors.length)];
                glitter.style.boxShadow = `0 0 ${size * 2}px rgba(255, 255, 255, 0.8)`;
                glitter.style.animationDuration = (Math.random() * 3 + 2) + 's';
                glitter.style.animationDelay = Math.random() * 0.5 + 's';

                document.body.appendChild(glitter);

                setTimeout(() => glitter.remove(), 5000);
            }, i * 50);
        }
    }

    // Create confetti effect
    function createConfetti() {
        const colors = ['#11998e', '#38ef7d', '#06d6a0', '#1dd1a1', '#667eea', '#764ba2'];
        for (let i = 0; i < 50; i++) {
            setTimeout(() => {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';

                const size = Math.random() * 10 + 5;
                confetti.style.width = size + 'px';
                confetti.style.height = size + 'px';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.top = '-20px';
                confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
                confetti.style.animationDelay = Math.random() * 0.5 + 's';

                document.body.appendChild(confetti);

                setTimeout(() => confetti.remove(), 4000);
            }, i * 30);
        }
    }


    // Trigger effects on page load
    window.addEventListener('load', () => {
        setTimeout(() => {
            createGlitter();
            createConfetti();
        }, 800);

        // Continue glitter throughout
        setInterval(() => {
            for (let i = 0; i < 10; i++) {
                setTimeout(() => {
                    const glitter = document.createElement('div');
                    glitter.className = 'glitter-particle';

                    const size = Math.random() * 6 + 3;
                    glitter.style.width = size + 'px';
                    glitter.style.height = size + 'px';
                    glitter.style.left = Math.random() * 100 + '%';
                    glitter.style.top = '-20px';
                    glitter.style.background = 'linear-gradient(45deg, #ffd700, #ffed4e)';
                    glitter.style.boxShadow = `0 0 ${size * 2}px rgba(255, 215, 0, 0.8)`;
                    glitter.style.animationDuration = (Math.random() * 2 + 2) + 's';

                    document.body.appendChild(glitter);
                    setTimeout(() => glitter.remove(), 4000);
                }, i * 100);
            }
        }, 2000);
    });
</script>
<script>
    $(document).ready(function() {
        let countdown = 5;
        const $countdown = $("#countdown");

        const timer = setInterval(function() {
            countdown--;
            $countdown.text(countdown);

            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = "{{ route('user.order.details', $order->id) }}";
            }
        }, 1000);

        let token = $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url: "{{ route('send.order.sms') }}",
            type: "POST",
            data: {
                _token: token,
                order_id: "{{ $order->id }}"
            },
            success: function(res) {
                if(res.status) {
                    // alert("SMS sent successfully!");
                } else {
                    // alert("Failed to send SMS: " + res.message);
                }
            },
            error: function(xhr) {
                // alert("Something went wrong. Try again!");
                console.log(xhr.responseText);
            }
        });
    });
</script>
