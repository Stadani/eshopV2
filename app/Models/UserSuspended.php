<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSuspended extends Model
{
    use HasFactory;

    protected $table = 'suspended_users';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
