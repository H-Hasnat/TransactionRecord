<?php

namespace App\Http\Controllers;

use App\Models\NumberDetails;
use App\Models\TransactionDetails;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Psy\Readline\Hoa\Console;

class NumberDetailsController extends Controller
{
    public function index()
    {
        $numberDetails = NumberDetails::all();

        return view('pages/number_details_pages', compact('numberDetails'));
        // return response(['status'=>'success','data'=>$numberDetails]);
    }






    function Number_Details(){
        $numberDetails = NumberDetails::with('type')->get();
        return response(['status'=>'success', 'data'=>$numberDetails]);

    }

    // Show Create Form
    public function create()
    {
        return view('number_details.create');
    }

    // Store New Number
    public function store(Request $request)
    {
        try{
            $request->validate([
                'agent_number' => 'required',
                'account_type_id'=>'integer',
                'amount'=>'required|numeric',
                'name' => 'max:255',
            ]);

            NumberDetails::create($request->all());

            return response(['status'=>'success', 'message'=>'Number added successfully!']);
        }catch(Exception $e){
            return $e;
        }

    }

    // Show Edit Form
    public function edit($id)
    {
        $numberDetail = NumberDetails::findOrFail($id);
        return view('number_details.edit', compact('numberDetail'));
        // return response(['status'=>'success','data'=>$numberDetail])
    }

    // Update Number


    public function update(Request $request)
{
    try {
        $id = $request->input('id');
        $column = $request->input('column'); // name or number
        $value = $request->input('value');

        // Ensure column is valid
        if (!in_array($column, [ 'agent_number','account_type','amount','name'])) {
            return response(['status' => 'error', 'message' => 'Invalid column'], 400);
        }


        // Update only the changed field

        NumberDetails::where('id', '=', $id)->update([
            $column => $value
        ]);

        return response(['status' => 'success', 'message' => ucfirst($column) . ' updated successfully!']);
    } catch (Exception $e) {
        return response(['status' => 'error', 'message' => 'Update failed'], 500);
    }
}









    // Delete Number
    public function destroy(Request $request)
    {
        try{
            $id=$request->input('id');
            NumberDetails::where('id','=',$id)->delete();

              return response([ 'status'=>'success', 'message'=>'Number Deleted successfully!']);
        }catch(Exception $e){
            return $e;
        }


    }

    function Number_Details_By_Id(Request $request){
        $id=$request->input('id');

        return NumberDetails::where('id','=',$id)->first();
    }














function AgentNumberDetails(Request $request)
{
    // ইনপুট থেকে start_date এবং end_date নেওয়া
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    // সমস্ত ট্রানজেকশন নিয়ে আসা এবং রিলেশন লোড করা
    $all_transactions = TransactionDetails::with('number', 'payment_method')->get();
    $agent_details = NumberDetails::get();
    // ফিল্টার করা ট্রানজেকশন এবং agent_sums তৈরি করা
    $agent_sums = [];
    $total_amount = 0;  // পরিমাণের যোগফল

    foreach ($all_transactions as $transaction) {
        // ডেট ফিল্টার করা (start_date এবং end_date এর মধ্যে)
        $transaction_date = $transaction->created_at->format('Y-m-d');

        // যদি transaction_date start_date এবং end_date এর মধ্যে থাকে
        if ($transaction_date >= $start_date && $transaction_date <= $end_date) {


            // যদি agent_number agent_details এর মধ্যে থাকে
            if ($agent_details->contains('agent_number', $transaction->number->agent_number)) {
                // যদি agent_number এর জন্য পূর্বে কোনো পরিমাণ না থাকে
                $key = $transaction->number->agent_number . '|' . $transaction->number->type['name'];


                if (!isset($agent_sums[$key])) {
                    $agent_sums[$key] = [
                        'amount' => 0,  // পরিমাণ
                        'type' => $transaction->number->type['name'] // টাইপ
                    ];
                }





                // পরিমাণ যোগ করা
                $agent_sums[$key]['amount'] += (float) $transaction->amount;

                // মোট পরিমাণ যোগ করা
                $total_amount += (float) $transaction->amount;
            }
        }
    }

    // ফলাফল রিটার্ন করা
    return response()->json([
        'agent_sums' => $agent_sums, // প্রত্যেক agent_number এর জন্য তার পরিমাণ
        'total_amount' => $total_amount // মোট পরিমাণ
    ]);
}




}
















