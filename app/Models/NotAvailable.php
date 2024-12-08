<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotAvailable extends Model
{
    protected $table = 'not_availables';
    protected $primaryKey = 'id';
    protected $fillable = [
        'formulir_id',
        'start_time',
        'end_time'
    ];
}
