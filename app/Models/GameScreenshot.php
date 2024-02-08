<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameScreenshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'screenshot',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
