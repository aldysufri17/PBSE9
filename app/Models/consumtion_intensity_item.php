<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class consumtion_intensity_item extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'ci_item_id';
    protected $table = "consumtion_intensity_items";
    protected $fillable = [
        'name',
    ];
    protected $dates = ['deleted_at']; 

}
