<?php

namespace Modules\CustomerRetail\App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Retailer extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'business_name',
        'email',
        'password',
        'phone',
        'address',
        'about',
        'profile_image',
        'application_form',
        'compliance_certificate',
        'bank_statement',
        'is_active',
        'businessName',
        'contact',
        'yearOfEstablishment',
        'applicationForm',
        'complianceCertificate',
        'bankStatement',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'retailer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'retailer_id');
    }
}
