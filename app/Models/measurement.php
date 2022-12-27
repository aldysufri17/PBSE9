<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class measurement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'm_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function section()
    {
        return $this->belongsTo(Section::class,'section_id');
    }
}
