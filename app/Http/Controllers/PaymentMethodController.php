<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Exception;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $numberDetails = PaymentMethod::all();

        return view('pages/payment_method_pages', compact('numberDetails'));
        // return response(['status'=>'success','data'=>$numberDetails]);
    }






    function Payment_Details()
    {
        $numberDetails = PaymentMethod::all();
        return response(['status' => 'success', 'data' => $numberDetails]);
    }



    // Store New Number
    public function store(Request $request)
    {
        try {
            $request->validate([
                'type' => 'string|max:255',
            ]);

            PaymentMethod::create($request->all());

            return response(['status' => 'success', 'message' => 'Number added successfully!']);
        } catch (Exception $e) {
            return $e;
        }
    }



    // Update Number


    public function update(Request $request)
    {
        try {
            $id = $request->input('id');
            $column = $request->input('column'); // name or number
            $value = $request->input('value');

            // Ensure column is valid
            if (!in_array($column, ['type'])) {
                return response(['status' => 'error', 'message' => 'Invalid column'], 400);
            }


            // Update only the changed field

            PaymentMethod::where('id', '=', $id)->update([
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
        try {
            $id = $request->input('id');
            PaymentMethod::where('id', '=', $id)->delete();

            return response(['status' => 'success', 'message' => 'Number Deleted successfully!']);
        } catch (Exception $e) {
            return $e;
        }
    }
}
