<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    use HasFactory;

//    mass assigment only allow these attributes
protected $guarded = [];

    //looks for search query in url if there is any it shows them
    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query
                ->where('title', 'like', '%' . request('search') . '%');
        }

        //function - anonymous function executed if when is true
        $query->when($filters['tag'] ?? false, function ($query, $tags) {
            $tags = is_array($tags) ? $tags : [$tags];

            $query->whereHas('tag', function ($tagQuery) use ($tags) {
                $tagQuery->whereIn('slug', $tags);

            }, '=', count($tags)); //makes sure that posts contain tags in array
        });
    }



    public function toggleLike(User $user)
    {
        if ($this->likes()->where('user_id', $user->id)->exists()) {
            $this->likes()->where('user_id', $user->id)->delete();
        } else {
            $this->likes()->create(['user_id' => $user->id]);
        }
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
