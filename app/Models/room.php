<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class energy_weight extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'room_id';
    public $incrementing = false;

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function building()
    {
        return $this->belongsTo(building::class, 'building_id');
    }
}