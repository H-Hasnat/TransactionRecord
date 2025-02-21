<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function number(){
        return $this->belongsTo(NumberDetails::class,'number_details_id', 'id');
    }

    public function payment_method(){
       return $this->belongsTo(PaymentMethod::class,'payment_details_id', 'id');
    }
}
