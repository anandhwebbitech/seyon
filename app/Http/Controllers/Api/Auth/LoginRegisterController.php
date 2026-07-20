<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\TempUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;
use Carbon\Carbon;
use App\Services\SmsService;
use Mail;
use App\Http\Resources\Profile\ProfileInformation;


class LoginRegisterController extends Controller
{
     /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
   public function register_send_otp(Request $request, SmsService $smsService)
    {
        // Validate input as either email or phone
        $isEmail = filter_var($request->phone_or_email, FILTER_VALIDATE_EMAIL);
        $field = $isEmail ? 'email' : 'phone';
        
        // Check if user already exists
        $checkUser = User::where($field, $request->phone_or_email)->first();
        if ($checkUser) {
            return [
                'status' => 'failed',
                'message' => 'Email or Phone Already Exist!!',
            ];
        }
    
        date_default_timezone_set('Asia/Kolkata');
        $otp = rand(1000, 9999);
        $prefix = 'AIOT';
    
        // Check if a temporary user already exists
        $checktempuser = TempUser::where($field, $request->phone_or_email)->first();
        if ($checktempuser) {
            $checktempuser->delete();
        }
    
        // Create a new temporary user
        $user = TempUser::create([
            'name'     => "",
            'email'    => $isEmail ? $request->phone_or_email : '',
            'phone'    => $isEmail ? '' : $request->phone_or_email,
            'password' => Hash::make($request->password),
        ]);
    
        $data['token'] = $user->createToken($user->email ?? $user->phone)->plainTextToken;
        $data['user'] = $user;
    
        if ($user->phone || $user->email) {
            $phone = $user->phone;
            $message = $otp;
            $type = 'register_otp';
            $response = $smsService->sendSms($phone, $message, $type);
    
            if ($response === true) {
                $user->update([
                    'verification_code' => $otp,
                    'user_unique_id' => $prefix . str_pad($user->id, 3, '0', STR_PAD_LEFT),
                ]);
                $data['verification_code'] = $otp;
            }
    
            if ($isEmail) {
                $userdata = [
                    'email' => $user->email,
                    'otp' => $otp,
                ];
    
                Mail::send('frontend.auth.email.otp', $userdata, function ($message) use ($userdata) {
                    $message->from('preethabtechit252@gmail.com', 'OTP')
                            ->to($userdata['email'])
                            ->subject('Verification code');
                });
            }
    
            return [
                'status' => 'success',
                'message' => 'OTP sent successfully.',
                'data' => $data,
            ];
        }
    
        return [
            'status' => 'failed',
            'message' => 'OTP send failed.',
        ];
    }

    
    
    public function login(Request $request)
    {
        

        if (filter_var($request->phone_or_email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->phone_or_email)->first();
            $user->device_token = $request->device_token;
            $user->save();
        }
        else
        {
            $user = User::where('phone', $request->phone_or_email)->first();
            $user->device_token = $request->device_token;
            $user->save();
        }


        // Check password
        if (!$user)
        {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found!'
                ]);
        }
        else if(!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid Password!'
                ]);
        }
        
        $data['token'] = $user->createToken($request->phone_or_email)->plainTextToken;
        

        $data['user'] = $user;
        
        $response = [
            'status' => 'success',
            'message' => 'User is logged in successfully.',
            'data' => $data,
        ];

        return response()->json($response, 200);
    } 

    public function forget_password(Request $request, SmsService $smsService)
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
                $message->from('preethabtechit252@gmail.com', 'OTP')
                        ->to($userdata['email'])
                        ->subject('Verification code');
            });
            
            return response()->json(
                [
                    'result' => 'success',
                    'message'=> 'User found',
                    'data' => $user,
                ]
            );
        }
        else
        {
            return response()->json(
                [
                    'result' => 'failed',
                    'message'=> 'User not found',
                ]
            );
        }

    }



    public function verification_code(Request $request)
    {
        $verifyuser = TempUser::where('id',$request->user_id)->where('verification_code',$request->verification_code)->first();

        if ($verifyuser)
        {
            date_default_timezone_set('Asia/Kolkata');
            $prefix = 'AIOT';
            
            $user = new User();
            $user->name     = $verifyuser->name;
            $user->email    = $verifyuser->email;
            $user->phone    = $verifyuser->phone;
            $user->password = $verifyuser->password;
            $user->email_verified_at = Carbon::now();
            $user->device_token = $request->device_token;
            $user->save();
            
            $user->user_unique_id = $prefix . str_pad($user->id, 3, '0', STR_PAD_LEFT);
            $user->save();
            
            $tempUser = TempUser::where('id',$request->user_id)->first();
            $tempUser->delete();

            $data['token'] = $user->createToken($user->email)->plainTextToken;
            return response()->json([
                'status' => 'success',
                'message' => 'Verify code matched!!',
                'data' => $data,
            ]);
        }
        else
        {
            return response()->json([
                'status' => 'failed',
                'message'=> 'Verification code does not match!!'
            ]);
        }

    }


    public function reset_password(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'new_password' => 'required'
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        if (filter_var($request->phone_or_email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->phone_or_email)->first();
        }
        else
        {
            $user = User::where('phone', $request->phone_or_email)->first();
        }
        if ($user)
        {
            $user->password = Hash::make($request->new_password);
            $user->email_verified_at = Carbon::now();
            $user->save();

            return response()->json([
                'status' => 'success',
                'message'=> 'Password has been updated, you can login now'
            ]);
        }
        else
        {
            return response()->json([
                'status' => 'failed',
                'message'=> 'User not found'
            ]);
        }

    }
    
    
    
    public function edit_profile(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();
        if($user)
        {
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->phone    = $request->phone;

            
            $image = $request->file('image');
            if($image)
            {
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('profile_images'), $imageName);
                $user->image_name = $imageName;
                $user->image_path = 'profile_images/' . $imageName; 
            }
            
            $user->save();
            return response()->json(['status' => 'success', 'message'=>'Profile updated successfully']);
        }
        else
        {
            return response()->json(['status' => 'failed', 'message'=>'user not found']);
        }
        // print_r($user); exit(); 
    }
    
    
    public function getProfile(Request $request)
    {
        $user_id = $request->user_id;
        
        $user = User::Where('id',$user_id)->first();
        
        if($user)
        {
            return (new ProfileInformation($user))->additional([
                'result' => true
            ]);
        }
        else
        {
            return response()->json([
                'status'  => false,
                'message' => 'User not found'
                ]);
        }
        
     
        
    }
    
    

    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User is logged out successfully'
            ], 200);
    }    
}