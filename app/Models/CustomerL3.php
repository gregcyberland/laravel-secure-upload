<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerL3 extends Model
{
    use HasFactory;
    protected $connection = 'customerL3';

    protected $table = 'users';

    //fillable
    protected $fillable = [
        'id',
        'password',
        'status',
    ];
}
