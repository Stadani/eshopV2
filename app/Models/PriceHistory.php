<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class PriceHistory extends Model
{
    use HasFactory;

    protected $table = 'price_history';
    protected $fillable = [
        'game_id',
        'platform_id',
        'price',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function platform()
    {
        return $this->belongsTo(GamePlatform::class);
    }

}
