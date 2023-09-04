<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\StripeAccountVerification;
use App\Models\User;
use App\Mail\EmailManager;
class VerificationController extends Controller
{
    public function email_verification(Request $request)
    {
        $email=Auth::user()->email;
        $stripe = new \Stripe\StripeClient(
            $_ENV['STRIPE_SECRET_KEY']
            );
          // create connect accoount
        $account=$stripe->accounts->create([
        'type' => 'express',
        'country' => 'US',
        'email' => $email,
        'capabilities' => [
            'card_payments' => ['requested' => true],
            'transfers' => ['requested' => true],
            ],
        ]);
        $id=$account->id;
        return redirect()->route('email_verified.index',['id'=>$id]);
    }
    public function email_verified(Request $request)
    {
        $id=$request->id;
        $stripe = new \Stripe\StripeClient(
            $_ENV['STRIPE_SECRET_KEY']
            );
        $link=$stripe->accountLinks->create([
            'account' =>$id,
            'refresh_url' => 'https://b4m.veravalonline.com/b4m/trip',
            'return_url' => 'https://b4m.veravalonline.com/b4m/trip',
            'type' => 'account_onboarding',
        ]);
        // dd($link->url);
        return redirect($link->url)->withSuccess("You are successfully connected with Stripe");
    }
    public function verifiedOtp(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        $otpData = EmailVerification::where('otp',$request->otp)->first();
        if(!$otpData){
            return response()->json(['success' => false,'msg'=> 'You entered wrong OTP']);
        }
        else{

            $currentTime = time();
            $time = $otpData->created_at;

            if($currentTime >= $time && $time >= $currentTime - (90+5)){//90 seconds
                User::where('id',$user->id)->update([
                    'is_verified' => 1
                ]);
                return response()->json(['success' => true,'msg'=> 'Mail has been verified']);
            }
            else{
                return response()->json(['success' => false,'msg'=> 'Your OTP has been Expired']);
            }

        }
    }

    public function resendOtp(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        $otpData = EmailVerification::where('email',$request->email)->first();

        $currentTime = time();
        $time = $otpData->created_at;

        if($currentTime >= $time && $time >= $currentTime - (90+5)){//90 seconds
            return response()->json(['success' => false,'msg'=> 'Please try after some time']);
        }
        else{

            $this->sendOtp($user);//OTP SEND
            return response()->json(['success' => true,'msg'=> 'OTP has been sent']);
        }

    }
    public function mobile_verification(Request $request)
    {
        return view("frontend.mobile_verify");
    }
    public function processMobileVerification(Request $request)
    {
        switch ($request["action"]) {
            case "send_otp":
            $mobile_number = $request['mobile_number'];
            $apiKey = urlencode(env('STRIPE_SECRET_KEY', null));
            $Textlocal = new Textlocal(false, false, $apiKey);
            $numbers = array(
                $mobile_number
            );
            $sender = 'PHPPOT';
            $otp = rand(100000, 999999);
            $_SESSION['session_otp'] = $otp;
            $message = "Your One Time Password is " . $otp;
            try{
                $response = $Textlocal->sendSms($numbers, $message, $sender);
                require_once ("verification-form.php");
                exit();
            }catch(Exception $e){
                die('Error: '.$e->getMessage());
            }
            break;
            case "verify_otp":
            $otp = $_POST['otp'];
            
            if ($otp == $_SESSION['session_otp']) {
                unset($_SESSION['session_otp']);
                echo json_encode(array("type"=>"success", "message"=>"Your mobile number is verified!"));
            } else {
                echo json_encode(array("type"=>"error", "message"=>"Mobile number verification failed"));
            }
            break;
        }
    }
    public function stripeIdentity(Request $request)
    {
        // if(Auth::user()->email_veryfied=='1')
        // {
            // return view("frontend.stripe_verification.index");
        // }
        // else
        // {
            return redirect("/email_verification");
        // }
       
    }
    public function create_verification_session(Request $request)
    {
        $stripe = new \Stripe\StripeClient([
            'api_key' => $_ENV['STRIPE_SECRET_KEY'],
            'stripe_version' => '2020-08-27',
        ]);
        $verification_session = $stripe->identity->verificationSessions->create([
            'type' => 'document',
            'metadata' => [
            'user_id' => '{{USER_ID}}',
            ]
        ]);
        echo json_encode(['client_secret' => $verification_session->client_secret]);
    }
    public function submitted(Request $request)
    {
        return view("frontend.stripe_verification.submitted");
    }
    public function create_concted_account(Request $request)
    {
        $stripe = new \Stripe\StripeClient(
             $_ENV['STRIPE_SECRET_KEY']
        );
        $stripe->accounts->create([
            'country' => 'US',
            'type' => 'express',
            'capabilities' => [
              'card_payments' => ['requested' => true],
              'transfers' => ['requested' => true],
            ],
            'business_type' => 'individual',
            'business_profile' => ['url' => 'https://b4m.veravalonline.com/b4m/'],
          ]);
        return back();
    }
    public function checkout(Request $request)
    {
        return view("frontend.stripe_conect_payout.checkout");
    }
    public function purchase(Request $request)
    {
        $user=Auth::user();
        $product=OrderDetail::where('upc',$request->upc)->first();
        if(is_null($product))
        {
            return back()->withError("product not available !");
        }
        return back()->withSuccess("You have bough the ".$product->product_name);
    }
    public function payment_save(Request $request)
    {
        $card=[
            'cards'=>$request->cc_number,
            'exp_month'=>$request->month,
            'exp_year'=>$request->year,
            'cvc'=>$request->cvc
        ];
        $user=Auth::user();
        return redirect()->route("home")->withSuccss("card added");
    }
    public function seller_create(Request $request)
    {
       
    }

    public function sendVerificationEmail(Request $request)
    {
        $email=$request->email;
        $user=User::where('email',$email)->first();
        $user->email_veryfied="1";
        $user->save();
        return redirect()->route("home")->withSuccess("email verified !");
    }
    public function check_mail(Request $request)
    {
        if(Auth::user()->email_veryfied=="0")
        {
            return view("frontend.emails.check_mail");
        }
        else
        {
            return redirect()->route("home")->withSuccess("Welcome Your email verified !");
        }
      
    }
    public function email_verify(Request $request)
    {
        
        
        if(Auth::user()->email_veryfied=="0")
        {
            $array=array();
            $array['email'] = Auth::user()->email;
            Mail::send('frontend.emails.verify_email', $array,function($message) use ($array) {
                $message->to($array['email']);
                $message->subject('buy4me email verify');
            });
            return view("frontend.emails.check_mail");
        }
        else
        {
            return redirect()->route("home")->withSuccess("Welcome Your email verified !");
        }
    }

    
}
