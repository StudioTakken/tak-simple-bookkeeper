<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_nr',
        'client_id',
        'date',
        'description',
        'amount',
        'details'
    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
