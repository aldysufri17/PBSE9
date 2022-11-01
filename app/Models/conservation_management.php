<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conservation_management extends Model
{
    use HasFactory;

    protected $primaryKey = 'cm_id';
    protected $table = "conservation_management";
    protected $fillable = [
        'item',
        'desc',
        'date'
    ];
}
