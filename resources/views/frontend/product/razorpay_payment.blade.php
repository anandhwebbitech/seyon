<!-- resources/views/frontend/product/razorpay_payment.blade.php -->
@extends('frontend.layouts.app')

@section('content')
<style>
    .razorpay-btn {
        background: linear-gradient(135deg, #0d6efd, #1a75ff);
        border: none;
        color: #fff;
        padding: 12px 25px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 50px;
        cursor: pointer;
        transition: 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 115, 230, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .razorpay-btn:hover {
        background: linear-gradient(135deg, #1a75ff, #4d94ff);
        box-shadow: 0 6px 16px rgba(0, 115, 230, 0.5);
        transform: translateY(-2px);
    }

    .razorpay-btn:active {
        transform: scale(0.98);
    }

</style>
<div class="container" style="text-align: center;padding: 100px;">
    <h2>Complete Payment</h2>
    <form id="razorpay-payment-form" action="{{ route('payment.success') }}" method="POST">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="{{ $razorpayOrderId }}">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    </form>
    
    <button id="rzp-button1" class="razorpay-btn">
        <img src="https://razorpay.com/assets/razorpay-logo.svg" style="height:18px;">
        Pay with Razorpay ₹{{ $finalTotal }}
    </button>

</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ env('RAZORPAY_KEY') }}",
        "amount": "{{ $finalTotal * 100 }}",
        "currency": "INR",
        "name": "Seyon",
        "description": "Order Payment",
        "image": "{{ asset('frontend/img/logo.png') }}",
        "order_id": "{{ $razorpayOrderId }}", 
        "handler": function (response){
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('razorpay-payment-form').submit();
        },
        "prefill": {
            "name": "{{ auth()->user()->name }}",
            "email": "{{ auth()->user()->email }}"
        },
        "theme": {
            "color": "#F37254"
        }
    };
    var rzp1 = new Razorpay(options);
    document.getElementById('rzp-button1').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    }
</script>
@endsection
