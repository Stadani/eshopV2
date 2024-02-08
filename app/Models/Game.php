<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'game_picture',
        'release_date',
        'rating',
    ];

    public function category()
    {
        return $this->belongsToMany(GameCategory::class, 'game_and_category', 'game_id', 'category_id');
    }
    public function platform()
    {
        return $this->belongsToMany(GamePlatform::class, 'game_and_platform', 'game_id', 'platform_id')->withPivot('price');;
    }
    public function trailer()
    {
        return $this->hasMany(GameTrailer::class, 'game_id');
    }
    public function screenshot()
    {
        return $this->hasMany(GameScreenshot::class, 'game_id');
    }
    public function gameSeries()
    {
        return $this->hasMany(SameSeriesGame::class,'original_id');
    }
    public function gameDLCs()
    {
        return $this->hasMany(GameDLC::class, 'game_id');
    }
    public function developer()
    {
        return $this->belongsToMany(GameDeveloper::class, 'games_and_developers', 'game_id', 'developer_id');
    }
    public function publisher()
    {
        return $this->belongsToMany(GamePublisher::class, 'games_and_publishers', 'game_id', 'publisher_id');
    }

}
