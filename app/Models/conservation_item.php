<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conservation_item extends Model
{
    use HasFactory;
    protected $primaryKey = 'coi_id';
    protected $guarded = [];
}
