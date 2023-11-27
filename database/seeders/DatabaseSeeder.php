<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $tags = [
            ['name' => 'Guide', 'slug' => 'guide'],
            ['name' => 'Help', 'slug' => 'help'],
            ['name' => 'Walkthrough', 'slug' => 'walkthrough'],
            ['name' => 'Art', 'slug' => 'art'],
            ['name' => 'Meme', 'slug' => 'meme'],
        ];

        foreach ($tags as $tagData) {
            Tag::factory()->create($tagData);
        }

    }
}
