@extends('frontend.layouts.app')
@section('content')
    <div class="page-banner">
        <div class="container">
            <ul class="navigation-list">
                <li><a href="index.html">Home</a></li>
                <li>Payment</li>
            </ul>
        </div>
    </div>
    <style>
        .img-btn img {}

        .img-btn>input {
            display: none
        }

        .img-btn>img {
            cursor: pointer;
            border: 1px solid #b5b5b5;
            border-radius: 10px;
            width: 100%;
            height: 150px;
            margin-bottom: 20px;
            padding: 10px;
        }

        .img-btn>input:checked+img {

            border-radius: 10px;
            border: 1px solid red;
            width: 100%;
            height: 150px;
            margin-bottom: 20px;
            padding: 10px;
        }

        .padd-both-30 {
            padding: 30px 0;
        }
    </style>

    <div class="padd-both-30">
        <div class="container padd-both-30">
            <div class="row justify-content-center">
                {{-- <div class="col-lg-2 d-none">
                    <label class="img-btn">
                        <input type="radio" name="payment_method" id="instamojo" value="instamojo">
                        <img src="{{ url('public/payment/instamojo.png') }}">
                        <p class="text-center">Instamojo</p>
                    </label>
                </div> --}}
                <div class="col-lg-2">
                    <label class="img-btn">
                        <input type="radio" name="payment_method" id="cod" value="cod" checked>
                        <img src="{{ url('public/payment/cod.svg') }}">
                        <p class="text-center">Cash on delivery</p>
                    </label>
                </div>
            </div>
            <form id="paymentForm" action="{{ route('payment.process') }}" method="POST">
                @csrf
                <input type="hidden" name="shipping_address" value="{{ $address }}">
                <input type="hidden" name="total_amount" value="{{ $amount }}">
                <input type="hidden" name="shipping_cost" value="{{ $shipping_cost }}">
                <input type="hidden" name="gst" value="{{ $gst }}">
                <input type="hidden" name="coupon_discount" value="{{ $coupon_discount }}">
            </form>
        </div>
    </div>

    <p class="mt-3 mb-3 text-center">
        <button class="btn common-btn" onclick="submitForm()">Confirm</button>
    </p>
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
    function submitForm() {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

        const paymentInput = document.createElement('input');
        paymentInput.type = 'hidden';
        paymentInput.name = 'payment_method';
        paymentInput.value = paymentMethod;

        const form = document.getElementById('paymentForm');
        form.appendChild(paymentInput);

        form.submit();
    }
</script>
