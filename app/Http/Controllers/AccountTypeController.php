<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use App\Models\NumberDetails;
use App\Models\TransactionDetails;
use Exception;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{
    public function index()
    {
        $numberDetails = AccountType::all();

        return view('pages/account_type_pages', compact('numberDetails'));
        // return response(['status'=>'success','data'=>$numberDetails]);
    }


    //Details
    function account_Details(){
        $numberDetails = AccountType::all();
        return response(['status'=>'success', 'data'=>$numberDetails]);

    }



    // Store New Number
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'string|max:255',
            ]);

            AccountType::create($request->all());

            return response(['status'=>'success', 'message'=>'Account type added successfully!']);
        }catch(Exception $e){
            return $e;
        }

    }




    //update
    public function update(Request $request)
{
    try {
        $id = $request->input('id');
        $column = $request->input('column'); // name or number
        $value = $request->input('value');

        // Ensure column is valid
        if (!in_array($column, ['name'])) {
            return response(['status' => 'error', 'message' => 'Invalid column'], 400);
        }


        // Update only the changed field

        AccountType::where('id', '=', $id)->update([
            $column => $value
        ]);

        return response(['status' => 'success', 'message' => ucfirst($column) . 'Data updated successfully!']);
    } catch (Exception $e) {
        return response(['status' => 'error', 'message' => 'Update failed'], 500);
    }
}




    // Delete Number
    public function destroy(Request $request)
    {
        try{
            $id=$request->input('id');


            // NumberDetails::where('account_type_id','=',$id)->delete();
           AccountType::where('id','=',$id)->delete();

              return response([ 'status'=>'success', 'message'=>'Number Deleted successfully!']);
        }catch(Exception $e){
            return $e;
        }


    }

















}
