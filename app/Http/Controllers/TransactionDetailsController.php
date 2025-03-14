<?php

namespace App\Http\Controllers;

use App\Models\NumberDetails;
use App\Models\TransactionDetails;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon; // Carbon ক্লাস ব্যবহার করার জন্য
use Symfony\Component\Console\Input\Input;

class TransactionDetailsController extends Controller
{
    public function index()
    {
        $numberDetails = TransactionDetails::all();

        return view('pages/transaction_details_pages', compact('numberDetails'));
        // return response(['status'=>'success','data'=>$numberDetails]);
    }






    public function Transaction_Details(){

        $numberDetails = TransactionDetails::with('number.type1')->with('payment_method')->get();
        return response(['status'=>'success','data'=>$numberDetails]);

    }



    // Show Create Form
    public function create()
    {
        return view('number_details.create');

    }

    // Store New Number
    public function store(Request $request)
{
    try {
        $request->validate([
            'name' => 'nullable|max:255',
            'cus_number' => 'required|digits:11',
            'amount' => 'required|numeric',
            'number_details_id' => 'integer',
            'payment_details_id' => 'integer',
        ]);

        $name = $request->input('name');
        $cus_number = $request->input('cus_number');
        $amount = $request->input('amount');
        $number_details_id = $request->input('number_details_id');
        $payment_details_id = $request->input('payment_details_id');

        // বাংলাদেশি সময় নির্ধারণ করে তৈরি করা
        $transactions = TransactionDetails::create([
            'name' => $name,
            'cus_number' => $cus_number,
            'amount' => $amount,
            'number_details_id' => $number_details_id,
            'payment_details_id' => $payment_details_id,
            'created_at' => Carbon::now('Asia/Dhaka'), // বাংলাদেশি সময়
            'updated_at' => Carbon::now('Asia/Dhaka'), // বাংলাদেশি সময়
        ]);

        $agent_amount = 0;
        $transaction_id = $transactions->id;
        $transaction_details = TransactionDetails::where('id', '=', $transaction_id)->first();

        $number_details_id = $transaction_details->number_details_id;

        $number_details = NumberDetails::where('id', '=', $number_details_id)->first();

        NumberDetails::where('id', '=', $number_details_id)->update(
            [
                'agent_number' => $number_details->agent_number,
                'account_type_id' => $number_details->account_type_id,
                'amount' => $number_details->amount + $amount,
                'name' => $number_details->name,
            ]
        );

        return response(['status' => 'success', 'message' => 'Number added successfully!']);

    } catch (Exception $e) {
        return $e;
    }
}

    // Show Edit Form
    public function edit($id)
    {
        $numberDetail = TransactionDetails::findOrFail($id);
        return view('number_details.edit', compact('numberDetail'));
        // return response(['status'=>'success','data'=>$numberDetail])
    }

    // Update Number


    // public function update(Request $request)
    // {

    //     try {
    //         $id = $request->input('id');
    //         $column = $request->input('column'); // name or number or amount
    //         $value = $request->input('value');

    //         // Ensure column is valid
    //         if (!in_array($column, ['name', 'cus_number','amount'])) {
    //             return response(['status' => 'error', 'message' => 'Invalid column'], 400);
    //         }


    //         // Update only the changed field

    //         TransactionDetails::where('id', '=', $id)->update([
    //             $column => $value
    //         ]);

    //         return response(['status' => 'success', 'message' => ucfirst($column) . ' updated successfully!']);
    //     } catch (Exception $e) {
    //         return response(['status' => 'error', 'message' => 'Update failed'], 500);
    //     }





    // }







    public function update(Request $request)
{
    try {
        $id = $request->input('id');
        $column = $request->input('column'); // name or cus_number or amount
        $value = $request->input('value');

        // Ensure column is valid
        if (!in_array($column, ['name', 'cus_number', 'amount'])) {
            return response(['status' => 'error', 'message' => 'Invalid column'], 400);
        }

        // Retrieve the transaction details
        $transaction = TransactionDetails::find($id);

        if (!$transaction) {
            return response(['status' => 'error', 'message' => 'Transaction not found'], 404);
        }

        // If the `amount` is updated, adjust the associated `number_details.amount`
        if ($column === 'amount') {
            $oldAmount = $transaction->amount; // Original amount
            $newAmount = $value; // New amount

            // Find the associated number_details record
            $numberDetails = NumberDetails::find($transaction->number_details_id);

            if ($numberDetails) {
                // Adjust the amount in number_details
                $numberDetails->amount = $numberDetails->amount - $oldAmount + $newAmount;
                $numberDetails->save();
            }
        }

        // Update the transaction column
        $transaction->update([
            $column => $value,
        ]);

        return response(['status' => 'success', 'message' => ucfirst($column) . ' updated successfully!']);
    } catch (Exception $e) {
        return response(['status' => 'error', 'message' => 'Update failed: ' . $e->getMessage()], 500);
    }











}
























    // Delete Number
    // public function destroy(Request $request)
    // {
    //     try{
    //         $id=$request->input('id');
    //         TransactionDetails::where('id','=',$id)->delete();

    //           return response([ 'status'=>'success', 'message'=>'Number Deleted successfully!']);
    //     }catch(Exception $e){
    //         return $e;
    //     }


    // }






    public function destroy(Request $request)
{
    try {
        $id = $request->input('id');

        // Retrieve the transaction details
        $transaction = TransactionDetails::find($id);

        if (!$transaction) {
            return response(['status' => 'error', 'message' => 'Transaction not found'], 404);
        }

        // Find the associated number_details record
        $numberDetails = NumberDetails::find($transaction->number_details_id);

        if ($numberDetails) {
            // Subtract the transaction amount from number_details amount
            $numberDetails->amount -= $transaction->amount;
            $numberDetails->save();
        }

        // Delete the transaction
        $transaction->delete();

        return response(['status' => 'success', 'message' => 'Number Deleted successfully!']);
    } catch (Exception $e) {
        return response(['status' => 'error', 'message' => 'Delete failed: ' . $e->getMessage()], 500);
    }
}




    public function Number_Details_By_Id(Request $request){
        $id=$request->input('id');

        return TransactionDetails::where('id','=',$id)->first();
    }















// public function FilterTransaction(Request $request)
// {
//     // ইনপুট ডেটা নেওয়া
//     $start_date = $request->input('start_date');
//     $end_date = $request->input('end_date');
//     $account_type = $request->input('account_type');

//     // NumberDetails থেকে account_type অনুযায়ী ID সংগ্রহ করা
//     $number_ids = NumberDetails::where('account_type_id', $account_type)
//                     ->pluck('id');

//     // Query বিল্ড করা
//     $query = TransactionDetails::with('number.type1', 'payment_method')
//                     ->whereIn('number_details_id', $number_ids);

//     // তারিখ অনুযায়ী ফিল্টার করা
//     if ($start_date === $end_date) {
//         // যদি start_date এবং end_date একই হয়, তাহলে whereDate ব্যবহার করা হবে
//         $query->whereDate('created_at', $start_date);
//     } else {
//         // ভিন্ন হলে whereBetween ব্যবহার করা হবে
//         $query->whereBetween('created_at', [$start_date, $end_date]);
//     }

//     // ফিল্টার করা ট্রান্সাকশন সংগ্রহ
//     $transactions = $query->get();

//     // মোট পরিমাণ হিসাব করা
//     $total_amount = $transactions->sum('amount');
//     $total_in = $transactions->where('amount', '>', 0)->sum('amount');
//     $total_out = abs($transactions->where('amount', '<', 0)->sum('amount'));

//     // রেসপন্স রিটার্ন করা
//     return response()->json([
//         'transactions' => $transactions,
//         'total_amount' => $total_amount,
//         'total_in' => $total_in,
//         'total_out' => $total_out
//     ]);
// }



public function FilterTransaction(Request $request)
{
    // ইনপুট ডেটা নেওয়া
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');
    $account_type = $request->input('account_type');

    // NumberDetails থেকে account_type অনুযায়ী ID সংগ্রহ করা
    $number_ids = NumberDetails::where('account_type_id', $account_type)
                    ->pluck('id');

    // Start Date ও End Date কে দিনব্যাপী কভার করার জন্য সময় সেট করা
    $start_date_time = Carbon::parse($start_date)->startOfDay(); // 00:00:00
    $end_date_time = Carbon::parse($end_date)->endOfDay(); // 23:59:59

    // Query বিল্ড করা
    $query = TransactionDetails::with('number.type1', 'payment_method')
                ->whereIn('number_details_id', $number_ids)
                ->whereBetween('created_at', [$start_date_time, $end_date_time]);

    // ফিল্টার করা ট্রান্সাকশন সংগ্রহ
    $transactions = $query->get();

    // মোট পরিমাণ হিসাব করা
    $total_amount = $transactions->sum('amount');
    $total_in = $transactions->where('amount', '>', 0)->sum('amount');
    $total_out = abs($transactions->where('amount', '<', 0)->sum('amount'));

    // রেসপন্স রিটার্ন করা
    return response()->json([
        'transactions' => $transactions,
        'total_amount' => $total_amount,
        'total_in' => $total_in,
        'total_out' => $total_out
    ]);
}




    }




