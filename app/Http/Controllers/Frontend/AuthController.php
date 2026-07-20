<?php

namespace App\Http\Controllers\Frontend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\TempUser;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return view('frontend.auth.register');
    }
    
    public function signup(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|digits:10|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => 'Email already exists!',
            'phone.unique' => 'Phone number already exists!',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);
        $checkUser = User::Where('phone', $request->phone)
                  ->first();
        
        if($checkUser){
            return back()->with('error', 'Email or Phone Already Exist!!');
        }
        else{
            date_default_timezone_set('Asia/Kolkata');
            $otp = rand(100000,999999);
            $prefix = 'SYNTS'; 
            
            $checktempuser = TempUser::where('email', $request->email)
                  ->orWhere('phone', $request->phone)
                  ->first();
            
            if($checktempuser)
            {
                $checktempuser->delete();
            }     
            $user = TempUser::create([
                'name'         => $request->name,
                'email'        => $request->email,
                'phone'        => $request->phone,
                'password'     => Hash::make($request->password)
            ]);
            
            if($user->phone)
            {
                $phone   = $user->phone;
                $message = 'Hi, your OTP for registration is '.$otp.'. It is valid for 10 minutes. Thanks for registering with us! Visit seyonkids.in to explore our products.';
                $template_id = '1707176242919483490';
                $response = Helper::sendSms($message, $template_id, $phone);
                
                if ($response === true) {
                    $verifyuser = TempUser::where('id',$user->id)->first();
                    $verifyuser->verification_code = $otp;
                    $verifyuser->user_unique_id = $prefix . str_pad($user->id, 3, '0', STR_PAD_LEFT);
                    $verifyuser->save();
                    $data['verification_code'] = $otp;
                }
                
                $email   = $user->email;
                
                $userdata = [
                    'name' => $user->name,
                    'email' => $email,
                    'otp' => $otp,
                    
                ];
                $user_id = $user->id;
                 // try {
                //     Mail::send('frontend.auth.email.otp', $userdata, function ($message) use ($userdata) {
                //         $message->from('ranjithweb90@gmail.com', 'OTP')
                //                 ->to($userdata['email'])
                //                 ->subject('Verification code');
                //     });
                // } catch (\Exception $e) {
                //     Log::error('Mail send failed: ' . $e->getMessage()); 
                // }
                
                return view('frontend.auth.registerwithotp', compact('user_id'))->with('refresh', true);
            }
        }
        
    }
    public function otpvarification(Request $request)
    {
        $otp = implode('', $request->otp);
        $user_id = $request->user_id;

        $verifyuser = TempUser::where('id', $user_id)
                            ->where('verification_code', $otp)
                            ->first();

        if ($verifyuser) {

            $user = new User();
            $user->name     = $verifyuser->name;
            $user->email    = $verifyuser->email;
            $user->phone    = $verifyuser->phone;
            $user->password = $verifyuser->password;
            $user->email_verified_at = now();
            $user->save();

            $user->user_unique_id = "SYNTS".str_pad($user->id, 3, '0', STR_PAD_LEFT);
            $user->save();

            TempUser::where('id', $user_id)->delete();
            Auth::login($user);
            return response()->json([
                'status' => true,
                'message' => 'OTP Verified Successfully! Redirecting...'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid OTP, please try again.'
        ]);
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        if ($request->type == 'guest') {
            return view('frontend.auth.login', [
                'error' => 'You need to log in to add items to your wishlist.',
            ]);
        }
        return view('frontend.auth.login');  
    }
    
    public function signin(Request $request)
    {

        if ($request->phone_or_email) {
            $user = User::where('phone', $request->phone_or_email)->where('user_type','user')->first();
        }

        if (!$user)
        {
            return Redirect::back()->with('danger', 'User not found!');
        }
        else if(!Hash::check($request->password, $user->password)) {
            return Redirect::back()->with('danger', 'Invalid Password!');
        }
        Auth::login($user);
        return redirect()->route('user.dashboard')->with('success', 'Your logged in successfully!!');

    }
    
    public function verify_user(Request $request, SmsService $smsService)
    {
        if (filter_var($request->phone_or_email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->phone_or_email)->first();
        }
        else
        {
            $user = User::where('phone', $request->phone_or_email)->first();
        }

        if ($user)
        {
            $otp = rand(1000,9999);
            $phone   = $user->phone;
            $message = $otp;
            $type = 'forget_password';
            $response = $smsService->sendSms($phone, $message,$type);
            
            if ($response === true) {
                $user->verification_code = $otp;
                $user->save();
            } else {
                $user->verification_code = null;
                $user->save();
            }
            
            $userdata = [
                'name' => $user->name,
                'email' => $user->email,
                'otp' => $message,
                
            ];
            
            Mail::send('frontend.auth.email.forget_password', $userdata, function ($message) use ($userdata) {
                $message->from('ranjithweb90@gmail.com', 'OTP')
                        ->to($userdata['email'])
                        ->subject('Verification code');
            });
            
            return view('frontend.auth.get_otp_screen',compact('user'))->with('success', 'OTP send successfully');
        }
        else
        {
            return Redirect::back()->with('danger', 'User not found!');
        }

    }
    
    public function userresendOtp($userId, SmsService $smsService) {
        $user = user::where('id',$userId)->first();
        
        $otp = rand(1000,9999);
        $phone   = $user->phone;
        $message = $otp;
        $type = 'register_otp';
        $response = $smsService->sendSms($phone, $message,$type);
        
        if ($response === true) {
            $verifyuser = user::where('id',$user->id)->first();
            $verifyuser->verification_code = $otp;
            $verifyuser->save();
        }
          
        $email   = $user->email;
        
        $userdata = [
            'name' => $user->name,
            'email' => $email,
            'otp' => $otp,
            
        ];

        Mail::send('frontend.auth.email.otp', $userdata, function ($message) use ($userdata) {
            $message->from('ranjithweb90@gmail.com', 'OTP')
                    ->to($userdata['email'])
                    ->subject('Verification code');
        });
                
        return response()->json(['success' => 'OTP resent successfully', 'user' => $user]);
        

    }
    
    public function user_verify_otp(Request $request)
    {
        $verification_code = implode('', $request->otp);
        // print_r($request->user_id); exit();
        $user = User::where('verification_code',$verification_code)->where('id',$request->user_id)->first();

        if ($user)
        {
            $user->save();
            Auth::login($user);
            // return view('frontend.my_profile',compact('user'))->with('success', 'Your logged in successfully!!');
            return redirect()->route('user.dashboard')->with('success', 'Your logged in successfully!!');
        }
        else
        {
           
            return redirect()->route('login.otp')->with('danger', 'Verification code does not match!!');
        }

    }
    
    public function forgot_password_step2(Request $request)
    {
        if ($request->phone_or_email) {
            $user = User::where('phone', $request->phone_or_email)->first();
        }

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found!'
            ]);
        }

        $otp = rand(100000, 999999);
        $phone = $user->phone;
        $message = 'Hi, Your One Time Password (OTP) for login is ' . $otp . '. Thank you, SEYON KIDS';
        $template_id = '1707176242909103944';
        $response = Helper::sendSms($message, $template_id, $phone);
        
        if ($response === true) {
            $user->verification_code = $otp;
            $user->save();
            
            return response()->json([
                'status' => true,
                'message' => 'OTP sent successfully',
                'user_id' => $user->id,
            ]);
        } else {
            $user->verification_code = null;
            $user->save();

            return response()->json([
                'status' => false,
                'message' => 'Failed to send OTP. Please try again.'
            ]);
        }
    }
    
    public function verification_code(Request $request)
    {
        $verification_code = $request->otp;

        $user = User::where('verification_code', $verification_code)
                    ->where('id', $request->user_id)
                    ->first();

        if ($user) {
            $otpSentAt = $user->updated_at;
            if (!$otpSentAt || now()->diffInMinutes($otpSentAt) > 5) {
                return response()->json([
                    'status' => false,
                    'message' => 'Verification code expired! Please request a new one.'
                ]);
            }

            $user->verification_code = null;
            $user->save();

            Auth::login($user);
            if(session('auth_type') == 'login-with-otp'){
                session()->forget('auth_type');
                return response()->json(['status' => true,'message' => 'Verification code matched!',
                'redirect' => route('user.dashboard')]);
            }
            return response()->json([
                'status' => true,
                'message' => 'Verification code matched!',
                'redirect' => route('change.password')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Verification code does not match!'
            ]);
        }
    }

    public function reset_password(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::where('id',$user_id)->first();
        if ($user)
        {
            $user->password = Hash::make($request->password);
            $user->email_verified_at = Carbon::now();
            $user->save();
            // return redirect()->route('login')->with('success', 'Password has been updated, you can login now');
            return response()->json(['success' => 'Password has been updated, you can login now', 'redirect' => route('user.login')], 200);
        }
        else
        {
             return response()->json(['danger' => 'User not found'], 404);
        }

    }    
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->route('user.login');
    }
}