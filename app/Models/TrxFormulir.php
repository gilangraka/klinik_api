<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxFormulir extends Model
{
    use HasFactory;
    protected $table = 'trx_formulir';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
        'usia',
        'email',
        'gender',
        'nomor_hp',
        'alamat',
        'keluhan',
        'start_time',
        'end_time',
        'lokasi',
        'is_done'
    ];

    public function ref_layanan()
    {
        return $this->belongsToMany(RefLayanan::class, 'trx_formulir_layanan', 'layanan_id', 'formulir_id');
    }

    public function payments()
    {
        return $this->hasOne(Payment::class, 'formulir_id');
    }

    public function not_available()
    {
        return $this->hasOne(NotAvailable::class, 'formulir_id');
    }
}
