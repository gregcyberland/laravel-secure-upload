<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer2 extends Model
{
    use HasFactory;
    protected $connection = 'customer2';

    protected $table = 'users';
    public $timestamps = false; // Disable automatic timestamps handling

    //fillable
    protected $fillable = [
        'password',
        'status',
    ];
}
