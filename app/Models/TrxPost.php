<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxPost extends Model
{
    use HasFactory;
    protected $table = 'trx_post';
    protected $primaryKey = 'id';
    protected $fillable = [
        'judul',
        'category_id',
        'thumbnail',
        'content'
    ];

    public function post_category()
    {
        return $this->belongsTo(RefPostCategory::class, 'category_id');
    }
}
