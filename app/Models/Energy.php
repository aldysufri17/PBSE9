<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Energy extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'energy_id';
    public $incrementing = false;

    protected $guarded = [];

    protected $dates = ['deleted_at'];
}
