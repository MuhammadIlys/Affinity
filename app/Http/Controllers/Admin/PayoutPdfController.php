<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransactionsModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayoutPdfController extends Controller
{
    public function completed_payout()
    {
        $payouts = DB::table('transactions')
            // Join for referrer
            ->leftJoin('users as referrer', 'transactions.referrer_id', '=', 'referrer.id')
            // Join for approved_by
            ->leftJoin('users as approver', 'transactions.approved_by', '=', 'approver.id')
            ->select(
                'transactions.*',
                DB::raw("CONCAT(referrer.first_name, ' ', referrer.last_name) as referrer_name"),
                DB::raw("CONCAT(approver.first_name, ' ', approver.last_name) as approved_by")
            )
            ->get();
            
        $pdf = Pdf::loadView('Admin.pdf.completed_payouts', compact('payouts'));

        // Return the PDF as download
        return $pdf->download('completed_payouts.pdf');
    }
}
