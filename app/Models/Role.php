<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class role extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'role_id';
    public $incrementing = false;
    protected $table = "roles";
    
    protected $dates = ['deleted_at'];  
}
