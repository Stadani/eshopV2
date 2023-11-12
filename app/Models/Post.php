<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;



class Post extends Model
{
    use HasFactory;

//    mass assigment only allow these attributes
    protected $fillable = ['title', 'excerpt', 'body'];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }



}
