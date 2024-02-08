<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDLC extends Model
{
    use HasFactory;

    protected $table = 'dlcs';

    protected $fillable = [
        'game_id',
        'name',
        'price',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
