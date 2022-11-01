<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class infrastructure_legality extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $primaryKey = 'il_id';
    public $incrementing = false;

    public function infrastruktur()
    {
        return $this->belongsTo(infrastructure::class, 'is_id');
    }
}
