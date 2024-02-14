<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameAndPlatform extends Model
{
    use HasFactory;

    protected $table = 'game_and_platform';
    public $timestamps = false;

    protected $fillable = [
        'game_id',
        'platform_id',
        'price',
    ];

    public function platform()
    {
        return $this->belongsTo(GamePlatform::class, 'platform_id');
    }

}
