<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'invoice_nr',
        'client_id',
        'date',
        'description',
        'amount',
        'vat',
        'amount_vat',
        'amount_inc',
        'details',
        'exported'
    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
