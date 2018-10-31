<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ptpyrel extends Model
{
    protected $table = 'ptpyrel_tb';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 	'ptid', 	'pyid', 	'att_file', 	'created_at', 	'updated_at'  
    ];
}
