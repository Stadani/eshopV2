<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryGame extends Model
{
    use HasFactory;

    protected $table = 'purchase_history';

    protected $guarded= [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->hasMany(Game::class);
    }
    public function dlc()
    {
        return $this->hasMany(GameDLC::class);
    }
}
