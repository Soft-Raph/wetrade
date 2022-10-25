<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Unicodeveloper\Paystack\Facades\Paystack;


class PaymentController extends Controller
{
    protected $rate;
    public function __construct()
    {
        $this->rate = config('paystack.rate');
        $this->middleware('auth');
    }
    public function callback(Request $request)
    {
        $usdAmount = $request->amount;
        if ($usdAmount <= 9 || $usdAmount > 300){
            toast('The amount is not allow.', 'error');
            return redirect()->back();
        }
        $nairaAmount = $usdAmount*$this->rate*100;
        $user = Auth::user();
        $data = array(
            "amount" => $nairaAmount,
            "first_name"=>$user->first_name,
            "last_name"=>$user->last_name,
            "reference" => Paystack::genTranxRef(),
            "email" => $user->email,
            "phone"=>$user->phone,
            "currency" => "NGN",
        );
        \request()->merge($data);
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    public function getData()
    {
        $user = Auth::user();
        $divide = $this->rate * 100;
        $getdata = Paystack::getPaymentData();
        $final =($getdata['data']['amount'] / $divide) - ($getdata['data']['fees'] / $divide);
        if (!$getdata['status']){
            Transaction::query()->create([
                'user_id'=>$user->id,
                'amount'=>$getdata['data']['amount'] / $divide,
                'type'=>'Funding Account',
                'status'=>$getdata['data']['gateway_response']
            ]);
            toast('Account fund not successful.', 'error');
            return redirect()->back();
        }
        User::query()->update([
            'balance'=>$user->balance + $final,
        ]);
            Transaction::query()->create([
                'user_id'=>$user->id,
                'amount'=>$final,
                'type'=>'Funding Account',
                'status'=>$getdata['data']['gateway_response']
            ]);
        toast('Account fund successful.', 'success');
       return  redirect()->back();
    }
}
