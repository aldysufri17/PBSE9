<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class infrastructure extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'is_id';
    public $incrementing = false;
    protected $table = "infrastructures";
    
    protected $dates = ['deleted_at'];  
}
