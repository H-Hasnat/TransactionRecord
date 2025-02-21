<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nette\Schema\Elements\Type;

class NumberDetails extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function type(){
        return $this->belongsTo(AccountType::class,'account_type_id', 'id');
    }

    public function type1()
{
    return $this->belongsTo(AccountType::class,'account_type_id', 'id'); // `type_id` হলো foreign key
}


}
