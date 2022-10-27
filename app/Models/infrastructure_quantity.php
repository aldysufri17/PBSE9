<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class infrastructure_quantity extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'is_id';
    public $incrementing = false;

    public function infrastruktur()
    {
        return $this->belongsTo(infrastructure::class, 'is_id');
    }
}
