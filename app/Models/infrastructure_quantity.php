<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class infrastructure_quantity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $primaryKey = 'iq_id';
    public $incrementing = false;

    public function infrastruktur()
    {
        return $this->belongsTo(infrastructure::class, 'is_id');
    }

    public function building()
    {
        return $this->belongsTo(building::class, 'building_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'post_by');
    }
}
