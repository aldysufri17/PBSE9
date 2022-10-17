<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnergyUsages extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "energy_usages";

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function energy()
    {
        return $this->belongsTo(Energy::class);
    }
}
