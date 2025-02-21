<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetails;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    function historyPage(){
        return view('history.history');
    }
    public function HistoryList(Request $request)
{
    // Start এবং End Date ইনপুট নেওয়া
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    // সমস্ত ট্রানজেকশন নিয়ে আসা এবং রিলেশন লোড করা
    $all_transactions = TransactionDetails::with('number.type1')->with('payment_method')->get();

    $filtered_transactions = [];
    $total_amount = 0; // এখানে `amount` এর যোগফল রাখব

    foreach ($all_transactions as $transaction) {
        // ডেট ফিল্টার করা (start_date এবং end_date এর মধ্যে)
        $transaction_date = $transaction->created_at->format('Y-m-d');
        if ($transaction_date >= $start_date && $transaction_date <= $end_date) {
            $filtered_transactions[] = $transaction; // ফিল্টার করা ডেটা যোগ করা

            // `amount` যোগ করা, নিশ্চিত করার জন্য যে এটি সংখ্যা
            $total_amount += (float) $transaction->amount;
        }
    }

    // ফিল্টার করা ডেটা এবং যোগফল রিটার্ন করা
    return response()->json([
        'transactions' => $filtered_transactions,
        'total_amount' => $total_amount
    ]);
}


public function downloadHistory(Request $request)
{
    try {
        // Fetch data based on the filters
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $total_amount = 0;

        // Fetch and filter transactions
        $all_transactions = TransactionDetails::with('number', 'payment_method')->get();
        $filtered_transactions = [];
        foreach ($all_transactions as $transaction) {
            // Filter data based on the start_date and end_date
            $transaction_date = $transaction->created_at->format('Y-m-d');
            if ($transaction_date >= $start_date && $transaction_date <= $end_date) {
                $filtered_transactions[] = $transaction;
                $total_amount += (float) $transaction->amount; // Ensure `amount` is numeric
            }
        }

        // Generate the PDF
        $pdf = Pdf::loadView('History.download-history', [
            'all_transactions' => $filtered_transactions,
            'total_amount' => $total_amount,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        // Return the PDF for download
        return $pdf->download('transaction_history.pdf');
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}













}
