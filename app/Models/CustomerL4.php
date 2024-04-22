<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerL4 extends Model
{
    use HasFactory;
    protected $connection = 'customerL4';

    protected $table = 'users';

    //fillable
    protected $fillable = [
        'id',
        'password',
        'status',
    ];
}
