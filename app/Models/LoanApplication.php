<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;
    protected $table = 'table_loanapplications';


    public function user(){
        return $this->belongsTo(User::class,'customer_id','id');
    }
}
