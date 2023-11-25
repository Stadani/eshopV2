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
        User::factory()->create();
        Tag::factory()->create();
        $tags = ['Guide', 'Help', 'Walkthrough', 'Art', 'Meme'];
        $slug = ['guide', 'help', 'walkthrough', 'art', 'meme'];

        foreach ($tags as $tagName) {
            Tag::factory()->create(['name' => $tagName]);
        }
        foreach ($slug as $slugName) {
            Tag::factory()->create(['slug' => $slugName]);
        }

    }
}
