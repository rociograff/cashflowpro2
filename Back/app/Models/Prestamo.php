<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $table = 'prestamos';

    protected $fillable = [
        'id',
        'user_id',
        'deudor',
        'importe',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
