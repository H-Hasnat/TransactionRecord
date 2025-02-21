<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $guarded=[];
    // public function isAdmin()
    // {
    //     return $this->role === 'admin';
    // }

    // public function isCustomer()
    // {
    //     return $this->role === 'customer';
    // }
}
