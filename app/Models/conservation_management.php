<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conservation_management extends Model
{
    use HasFactory;

    protected $primaryKey = 'cm_id';
    protected $guarded = [];

    public function conservation_item()
    {
        return $this->belongsTo(conservation_item::class, 'coi_id');
    }
}
