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
}
