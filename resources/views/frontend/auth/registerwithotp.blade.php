@extends('frontend.layouts.app')
@section('content')

<style>
    .otp-button-size{
        margin-right: 5px;
        width: 40px;
        height: 40px;
        border-radius: 7px;
        text-align: center;
        border: 1px solid #b33425;
    }
</style>

<div class="login-detail">
    <div class="container">
        <div class="row gy-3 gx-0 justify-content-center align-items-center ">
            <div class="col-lg-6 col-md-8">
                <div class="login-box">
                    <h1 class="login-title">Verify OTP</h1>
                    @if (session('success'))
                        <div id="successMessage" class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('danger'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('danger') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('danger'))
                        <div id="dangerMessage" class="alert alert-danger">{{ session('danger') }}</div>
                    @endif
                    
                    <script>
                        setTimeout(function () {
                            $('#successMessage').fadeOut('slow');
                        }, 5000);
                    
                        setTimeout(function () {
                            $('#dangerMessage').fadeOut('slow');
                        }, 5000);
                    </script>
                    <form class="row gy-4" id="otpForm">
                        @csrf
                        <input type="hidden" class="form-input" name="user_id" value="{{ $user_id }}" placeholder="Enter Email">
                        <div class="col-md-12 text-center">
                            <input type="number" class="otp-button-size" id="otp1" name="otp[]" maxlength="1" size="1" required autofocus>
                            <input type="number" class="otp-button-size" id="otp2" name="otp[]" maxlength="1" size="1" required>
                            <input type="number" class="otp-button-size" id="otp3" name="otp[]" maxlength="1" size="1" required>
                            <input type="number" class="otp-button-size" id="otp4" name="otp[]" maxlength="1" size="1" required>
                            <input type="number" class="otp-button-size" id="otp5" name="otp[]" maxlength="1" size="1" required>
                            <input type="number" class="otp-button-size" id="otp6" name="otp[]" maxlength="1" size="1" required>
                        </div>
                        
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success w-50">Verify <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </form>
                    
                    <hr class="my-4" style="opacity: 0.2;">
                    
                   
                </div>
            </div>
        </div>
    </div>
 </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        let inputs = document.querySelectorAll("input[name='otp[]']");

        inputs.forEach((input, index) => {
            input.addEventListener("input", function () {

                // Allow only single digit
                this.value = this.value.slice(0, 1);

                // Move to next field
                if (this.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener("keydown", function (e) {
                // Move to previous field on backspace
                if (e.key === "Backspace" && this.value === "" && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    });
</script>
<script>
$(document).ready(function(){

    $("#otpForm").on("submit", function(e){
        e.preventDefault();

        let button = $(".btn-success");
        button.prop("disabled", true).html("Verifying...");

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('otpvarification') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){

                if(res.status === true){
                    // show success
                    $("#successMessage").remove();
                    $('.login-box').prepend(
                        `<div class="alert alert-success" id="successMessage">${res.message}</div>`
                    );

                    // redirect to dashboard
                    setTimeout(() => {
                        window.location.href = "{{ route('user.dashboard') }}";
                    }, 1500);
                }
                else{
                    $("#dangerMessage").remove();
                    $('.login-box').prepend(
                        `<div class="alert alert-danger" id="dangerMessage">${res.message}</div>`
                    );
                }

                button.prop("disabled", false).html("Verify");
            },
            error: function(){
                button.prop("disabled", false).html("Verify");

                $('.login-box').prepend(
                    `<div class="alert alert-danger" id="dangerMessage">Server error. Try again.</div>`
                );
            }
        });
    });

});
</script>

@endsection