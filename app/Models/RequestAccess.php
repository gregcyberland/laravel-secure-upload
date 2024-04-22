<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestAccess extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'user_id',
        'date',
        'customer',
        'reason',
        'password',
        'expiration',
        'link_expiration',
        'approved_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
