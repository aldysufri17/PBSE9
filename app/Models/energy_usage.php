<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class energy_usage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'eu_id';
    //public $incrementing = false;
    protected $table = "energy_usages";
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'post_by', 'user_id');
    }

    public function energy()
    {
        return $this->belongsTo(Energy::class, 'energy_id');
    }
}
