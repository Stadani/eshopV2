<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;




class Post extends Model
{
    use HasFactory;

//    mass assigment only allow these attributes
    protected $fillable = ['title', 'excerpt', 'body'];

    //looks for search query in url if there is any it shows them
    public function scopeFilter($query, array $filters)
    {
        //Code executes if 'search' key exists and is not null or false
                if ($filters['search'] ?? false) {
                    //searches only for title, commented part doesnt work correctly
            $query
                ->where('title', 'like', '%' . request('search') . '%');
//                ->orWhereHas('user', function ($userQuery) {
//                    $userQuery->where('name', 'like', '%' . request('search') . '%');
//                });
        }


       /* $query->when($filters['search'] ?? false, function ($query, $searchQuery) {
            $query->where(function ($subquery) use ($searchQuery) {
                $subquery
                    ->where('title', 'like', '%' . $searchQuery . '%')
                    ->orWhereHas('user', function ($userQuery) use ($searchQuery) {
                        $userQuery->where('name', 'like', '%' . $searchQuery . '%');
                    })
                    ->orWhereExists(function ($nestedSubquery) use ($searchQuery) {
                        $nestedSubquery
                            ->from('post_tag')
                            ->join('tags', 'post_tag.tag_id', '=', 'tags.id')
                            ->whereRaw('posts.id = post_tag.post_id')
                            ->where('tags.name', '=', $searchQuery);
                    });
            });
        });*/


        //not working well (shows posts with no tag when searching with title)
        // its because of orwherehas when searching for authors
        $query->when($filters['tag'] ?? false, function ($query, $tagName) {
            $query->whereExists(function ($subquery) use ($tagName) {
                $subquery
                    ->from('post_tag')
                    ->join('tags', 'post_tag.tag_id', '=', 'tags.id')
                    ->whereRaw('posts.id = post_tag.post_id')
                    ->where('tags.name', '=', $tagName);
            });
        });
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
