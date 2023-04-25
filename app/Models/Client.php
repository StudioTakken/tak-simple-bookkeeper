<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;


    // has many invoices
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    protected $fillable = [
        'email',
        'phone',
        'company_name',
        'tav',
        'address',
        'zip_code',
        'city',
    ];
}
