<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model // <--- Make sure the class name is 'Staff'
{
    use HasFactory;

    // protected $fillable = ['name', 'email', 'position'];
    // protected $fillable = ['name', 'email', 'role', 'stage_id'];
    protected $fillable = ['name', 'email', 'age', 'hire_date', 'phone', 'gender', 'address', 'stage_id'];
    
    public function stage()
    {
        return $this->belongsTo(ProductionStage::class, 'stage_id');
    }
}