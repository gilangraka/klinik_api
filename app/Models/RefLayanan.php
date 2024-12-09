<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefLayanan extends Model
{
    use HasFactory;
    protected $table = 'ref_layanan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
        'jenis_layanan_id',
        'deskripsi',
        'biaya'
    ];

    public function ref_jenis_layanan()
    {
        return $this->belongsTo(RefJenisLayanan::class, 'jenis_layanan_id');
    }

    public function trx_formulir()
    {
        return $this->belongsToMany(TrxFormulir::class, 'trx_formulir_layanan', 'layanan_id', 'formulir_id');
    }
}
