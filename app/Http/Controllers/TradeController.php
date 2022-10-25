<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function trade(Request $request)
    {
        $user = Auth::user();
        if ($user->balance <= 0){
            toast('You have zero balance please fund your account to trade', 'error');
            return redirect()->back();
        }
        $trade = Trade::query()->create([
            'user_id'=>$user->id,
           'usdt'=>$request->usdt,
            'amount'=>$user->balance
        ]);
        if ($trade){
            User::query()->update([
               'balance'=>0,
            ]);
        }
        if ($trade){
            Transaction::query()->create([
               'user_id'=>$user->id,
               'amount'=>$user->balance,
               'type'=>'Trade Placing',
                'status'=>'success'
            ]);
        }
        toast('Your '.number_format($trade->amount, 2).' Trade have been place successfully, your wallet will be credited in 48hours', 'success');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $details =Trade::query()->where('id',$request->id)->first();
        if ($details->status == "PROCESSING"){
            toast('Trade is in process you can not delete', 'error');
            return redirect()->back();
        }
        $details->delete();
        toast('Trade history deleted successfully', 'success');
        return redirect()->back();
    }
}
