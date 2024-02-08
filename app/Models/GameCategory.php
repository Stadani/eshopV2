<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'slug',
    ];

    public function game()
    {
        return $this->belongsToMany(Game::class);
    }
}
