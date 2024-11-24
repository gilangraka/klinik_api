<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxFormulirLayanan extends Model
{
    use HasFactory;
    protected $table = 'trx_formulir_layanan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'formulir_id',
        'layanan_id'
    ];
}
