<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function destroy(Request $request)
    {
        $details =Transaction::query()->where('id',$request->id)->first();
        $details->delete();
        toast('Transaction history deleted successfully', 'success');
        return redirect()->back();
    }
}
