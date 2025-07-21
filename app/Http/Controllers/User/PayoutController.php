<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TransactionsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayoutController extends Controller
{
    public function index()
    {
        $payouts = TransactionsModel::where('status', 'pending')->where('referrer_id', Auth::user()->id)->get();
    }

    public function pending()
    {
        $payouts = TransactionsModel::select(
            'transactions.*',
            DB::raw("CONCAT(users.first_name, ' ', users.last_name) as approver_name")
        )
            ->leftJoin('users', 'transactions.approved_by', '=', 'users.id') // LEFT JOIN handles nulls
            ->where('transactions.status', 'pending')
            ->where('transactions.referrer_id', Auth::id())
            ->get();
        return view('User.payouts.pending_payouts', compact('payouts'));
    }
    public function completed()
    {
        $payouts = TransactionsModel::select(
            'transactions.*',
            DB::raw("CONCAT(users.first_name, ' ', users.last_name) as approver_name")
        )
            ->join('users', 'transactions.approved_by', '=', 'users.id')
            ->where('transactions.status', 'completed')
            ->where('transactions.referrer_id', Auth::id())
            ->get();


        return view('User.payouts.completed_payouts', compact('payouts'));
    }
    public function rejected()
    {
        $payouts = TransactionsModel::select(
            'transactions.*',
            DB::raw("CONCAT(users.first_name, ' ', users.last_name) as approver_name")
        )
            ->join('users', 'transactions.approved_by', '=', 'users.id')
            ->where('transactions.status', 'rejected')
            ->where('transactions.referrer_id', Auth::id())
            ->get();

        return view('User.payouts.rejected_payouts', compact('payouts'));
    }
    public function requestPayout(Request $request)
    {
        $validated = $request->validate([
            'amountInput' => 'required|min:1',
        ]);

        $user = Auth::user();
        if ($user->total_amount > 0) {
            $transaction = TransactionsModel::create([
                'referrer_id' => Auth::id(),
                'approved_by' => null,
                'total_amount' => $validated['amountInput'],
                'status' => 'pending',
            ]);

            if ($transaction) {
                return redirect()->back()->with('success', 'Withdraw request sent successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong Kindly try again');
            }
        }else{
                return redirect()->back()->with('error', 'You dont have enough balance');
        }
    }

    public function delete_payout($id = null)
    {
        $payout = TransactionsModel::findorfail(decrypt($id));
        if ($payout->delete()) {
            return redirect()->back()->with('success', 'Payout deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong Kindly try again');
        }
    }
}
