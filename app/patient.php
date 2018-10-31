<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    protected $table = 'patient_tb';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mrn', 'first_name','last_name','midd_name','bir_mm','bir_dd','bir_yy','gender','email','phone_num1','phone_num2','phone_num3','address1','address2','city','state','added_mm','added_dd','added_yy','created_at','updated_at' 
    ];
}
