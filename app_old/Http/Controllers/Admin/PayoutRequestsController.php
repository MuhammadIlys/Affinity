<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransactionsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayoutRequestsController extends Controller
{

    public function approve_request($id = null)
    {
        $payout = TransactionsModel::findOrFail(decrypt($id));
        $referrer = User::findOrFail($payout->referrer_id);
        $admin = Auth::user();

        // Deduct from referrer
        $referrer->total_amount = round((float)$referrer->total_amount - (float)$payout->total_amount, 2);

        // Add to admin
        $admin->total_amount = round((float)$admin->total_amount + (float)$payout->total_amount, 2);

        // Update approved_by and status
        $payout->approved_by = $admin->id;
        $payout->status = 'completed';

        $referrer->save();
        $admin->save();

        if ($payout->save()) {
            return redirect()->back()->with('success', 'Payout approved and amount transferred to admin successfully.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong, kindly try again.');
        }
    }
    public function reject_request($id = null)
    {
        $payout = TransactionsModel::findorfail(decrypt($id));
        $payout->status = 'rejected';
        if ($payout->save()) {
            return redirect()->back()->with('success', 'Payout rejected successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong Kindly try again');
        }
    }
    public function pending_request($id = null)
    {
        $payout = TransactionsModel::findorfail(decrypt($id));
        $payout->status = 'pending';
        if ($payout->save()) {
            return redirect()->back()->with('success', 'Payout status changed successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong Kindly try again');
        }
    }
    public function delete_request($id = null)
    {
        $payout = TransactionsModel::findorfail(decrypt($id));
        if ($payout->delete()) {
            return redirect()->back()->with('success', 'Payout deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong Kindly try again');
        }
    }

    public function update_request(Request $request, $id = null)
    {
        $id = decrypt($id);
        $payout = TransactionsModel::findorfail($id);
        $payout->total_amount = $request->total_amount;
        if ($payout->save()) {
            return redirect()->back()->with('success', 'Payout edited successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong Kindly try again');
        }
    }


    //////// DATA FOR TABLES //////////
    public function pending()
    {
        $payouts = TransactionsModel::select(
            'transactions.*',
            // DB::raw("CONCAT(approver.first_name, ' ', approver.last_name) AS approver_name"),
            DB::raw("CONCAT(referrer.first_name, ' ', referrer.last_name) AS referrer_name")
        )
            // ->leftJoin('users as approver', 'transactions.approved_by', '=', 'approver.id')
            ->leftJoin('users as referrer', 'transactions.referrer_id', '=', 'referrer.id')
            ->where('transactions.status', 'pending')
            // ->where('transactions.referrer_id', Auth::id())
            ->get();

        return view('Admin.payouts.pending_payouts', compact('payouts'));
    }
    public function approved()
    {
        $payouts = TransactionsModel::select(
            'transactions.*',
            // DB::raw("CONCAT(approver.first_name, ' ', approver.last_name) AS approver_name"),
            DB::raw("CONCAT(referrer.first_name, ' ', referrer.last_name) AS referrer_name")
        )
            // ->leftJoin('users as approver', 'transactions.approved_by', '=', 'approver.id')
            ->leftJoin('users as referrer', 'transactions.referrer_id', '=', 'referrer.id')
            ->where('transactions.status', 'completed')
            // ->where('transactions.referrer_id', Auth::id())
            ->get();

        return view('Admin.payouts.completed_payouts', compact('payouts'));
    }
    public function rejected()
    {
        $payouts = TransactionsModel::select(
            'transactions.*',
            // DB::raw("CONCAT(approver.first_name, ' ', approver.last_name) AS approver_name"),
            DB::raw("CONCAT(referrer.first_name, ' ', referrer.last_name) AS referrer_name")
        )
            // ->leftJoin('users as approver', 'transactions.approved_by', '=', 'approver.id')
            ->leftJoin('users as referrer', 'transactions.referrer_id', '=', 'referrer.id')
            ->where('transactions.status', 'rejected')
            // ->where('transactions.referrer_id', Auth::id())
            ->get();

        return view('Admin.payouts.rejected_payouts', compact('payouts'));
    }
}
