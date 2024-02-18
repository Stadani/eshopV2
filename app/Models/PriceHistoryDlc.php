<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistoryDlc extends Model
{
    use HasFactory;

    protected $table = 'price_history_dlc';
    protected $fillable = [
        'dlc_id',
        'price',
    ];

    public function gameDLCs()
    {
        return $this->belongsTo(GameDLC::class);
    }
}
