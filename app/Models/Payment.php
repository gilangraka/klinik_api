<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payment';
    protected $primaryKey = 'id';
    protected $fillable = [
        'formulir_id',
        'external_id',
        'amount',
        'status',
        'payment_method'
    ];

    public function trx_formulir()
    {
        return $this->belongsTo(TrxFormulir::class, 'formulir_id');
    }
}
