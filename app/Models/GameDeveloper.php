<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDeveloper extends Model
{
    use HasFactory;

    protected $table = 'developers';

    protected $fillable = [
        'name',
    ];

    public function game()
    {
        return $this->belongsToMany(Game::class);
    }
}
