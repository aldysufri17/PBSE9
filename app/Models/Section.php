<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class section extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'section_id';
    public $incrementing = false;
    protected $table = "sections";
    protected $guarded = [];
    
    protected $dates = ['deleted_at'];  
}
