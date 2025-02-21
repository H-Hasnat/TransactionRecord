<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;

class CustomerDetailsController extends Controller
{
    public function index()
    {
        $numberDetails =Customer::all();

        return view('pages/customer_details_pages', compact('numberDetails'));
        // return response(['status'=>'success','data'=>$numberDetails]);
    }


    //Details
    function customer_Details(){
        $numberDetails = Customer::all();
        return response(['status'=>'success', 'data'=>$numberDetails]);

    }



    // Store New Number
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'max:255',
                'number' => 'required|digits:11',
            ]);

            Customer::create($request->all());

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
        if (!in_array($column, [ 'number','name'])) {
            return response(['status' => 'error', 'message' => 'Invalid column'], 400);
        }


        // Update only the changed field

       Customer::where('id', '=', $id)->update([
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


            // NumberDetails::where('account_type_id','=',$id)->delete();
            Customer::where('id','=',$id)->delete();

              return response([ 'status'=>'success', 'message'=>'Number Deleted successfully!']);
        }catch(Exception $e){
            return $e;
        }


    }


    function cus_By_id(Request $request){
        $id=$request->input('id');
       return  Customer::where('id',$id)->first();
    }












}
