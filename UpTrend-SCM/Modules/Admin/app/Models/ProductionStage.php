<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionStage extends Model
{
    use HasFactory;

    // protected $fillable = ['name', 'description', 'order'];

    protected $fillable = [
        'name',
        'description',
        'order',
        'max_staff',
    ];

    public function staff()
    {
        return $this->hasMany(Staff::class, 'stage_id');
    }
}
