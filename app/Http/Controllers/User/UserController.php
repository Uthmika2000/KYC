<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    function create(Request $request)
    {
        //Validate Inputs
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|max:30',
            'cpassword' => 'required|min:5|max:30|same:password'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $save = $user->save();
        $last_id = $user->id;

        $token = $last_id.hash('sha256', Str::random(120));
        $verifyURL = route('user.verify', ['token'=>$token, 'service' => 'Email_verification']);

        VerifyUser::create([
            'user_id' => $last_id,
            'token'   => $token,

        ]);

        $message = 'Dear <b>'.$request->name.',<br/>';
        $message.= 'Thanks for signing up, we just need you to verify your email address to complete setting up your account.';

        $mail_data = [
            'recipient' => $request->email,
            'fromEmail' => $request->email,
            'fromName' => $request->name,
            'subject'  => "Email Verification",
            'body' =>$message,
            'actionLink' => $verifyURL,
        ];

        Mail::send('layouts.email-template',  $mail_data , function ($message) use ($mail_data) {
            $message->to($mail_data['recipient'])
            ->from($mail_data['fromEmail'], $mail_data[ 'fromName'] )
            ->subject($mail_data['subject']);
        });


        if ($save) {
            return redirect()->back()->with('success', 'You need to verify your account. We have sent you an activation link, please check your emai.');
        } else {
            return redirect()->back()->with('fail', 'Something went wrong, failed to register');
        }
    }


    public function verify(Request $request){
        $token=$request->token;
        $verifyUser =  VerifyUser::where('token',$token) ->first();
        if(!is_null( $verifyUser )){
            $user = $verifyUser->user;

            if(!$user->email_verified){
                $verifyUser->user->email_verified=1;
                $verifyUser->user->save();

                return redirect()->route('user.login')->with('info',"Your email has been verified. You can login now.")->with('verifiedEmail', $user->email);

            }else{
                return redirect()->route('user.login')->with('info', "Email already verified")->with('verifiedEmail', $user->email);
            }
        }
    }

    function check(Request $request)
    {
        //Validate inputs
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:5|max:30'
        ], [
            'email.exists' => 'This email is not exists on users table'
        ]);

        $creds = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($creds)) {
            return redirect()->route('user.home');
        } else {
            return redirect()->route('user.login')->with('fail', 'Incorrect credentials');
        }
    }

    function logout(){
        Auth::guard('web')->logout();
        return redirect('/');
    }

    public function showForgotForm(){
        return view('dashboard.user.forgot');
    }

    public function sendResetLink(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=> Carbon::now(),
        ]);

        $action_link = route('user.reset.password.form',['token'=>$token,'email'=>$request->email]);
        $body = "We are received a request to reset the password for <b>KYC-XEPAYS </b> account associated with ".$request->email.". You can reset your password by clicking the link below.";

        Mail::send('layouts.email-forgot',['action_link'=>$action_link,'body'=>$body],function ($message) use ($request){
            $message->from('noreply@example.com','KYC-XEPAYS');
            $message->to($request->email,'Your Name')
            ->subject('Reset Password');
        });

        return back()->with('success', 'We have emailed your password reset link!');
    }

    public function showResetForm(Request $request, $token= null){
        return view('dashboard.user.reset')->with( ['token'=>$token,'email'=>$request->email] );
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' =>  'required',
        ]);

        $check_token = DB::table( 'password_reset_tokens' )->where([
            'email'=>$request->email,
            'token'=>$request->token,
        ])->first();
        
        if(!$check_token){
            return back()->withInput()->with('fail','Invalid Token');
        }else{
            User::where( 'email', $request->email )->update([
                'password'=>Hash::make($request->password),
            ]);

            DB::table( 'password_reset_tokens' )->where([
                'email'=>$request->email,
            ])->delete();
            
            return redirect()->route('user.login')->with('info','Password has been changed! Please login to continue')->with('verifiedEmail',$request->email);
        }
    }
}
