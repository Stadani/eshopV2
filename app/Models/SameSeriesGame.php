<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SameSeriesGame extends Model
{
    use HasFactory;

    protected $table = 'same_series_games';

    protected $fillable = [
        'original_id',
        'series_id',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
