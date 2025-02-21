<?php

namespace App\Http\Controllers;

use App\Models\NumberDetails;
use App\Models\TransactionDetails;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon; // Carbon ক্লাস ব্যবহার করার জন্য

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
    public function destroy(Request $request)
    {
        try{
            $id=$request->input('id');
            TransactionDetails::where('id','=',$id)->delete();

              return response([ 'status'=>'success', 'message'=>'Number Deleted successfully!']);
        }catch(Exception $e){
            return $e;
        }


    }

    public function Number_Details_By_Id(Request $request){
        $id=$request->input('id');

        return TransactionDetails::where('id','=',$id)->first();
    }



}
