<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class infrastucture_legality_items extends Model
{
    use HasFactory;
    protected $table = "infrastructure_legalities_items";
    protected $guarded = [];
    protected $primaryKey = 'ili_id';
    public $incrementing = false;
}
