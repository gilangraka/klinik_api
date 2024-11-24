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
        'tipe_layanan_id',
        'deskripsi',
        'biaya'
    ];
}
