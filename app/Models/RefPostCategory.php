<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPostCategory extends Model
{
    use HasFactory;
    protected $table = 'ref_post_category';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama'
    ];
}
