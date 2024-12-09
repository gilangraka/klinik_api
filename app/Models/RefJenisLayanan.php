<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefJenisLayanan extends Model
{
    use HasFactory;
    protected $table = 'ref_jenis_layanan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama'
    ];

    public function ref_layanan()
    {
        return $this->hasMany(RefLayanan::class, 'jenis_layanan_id');
    }
}
