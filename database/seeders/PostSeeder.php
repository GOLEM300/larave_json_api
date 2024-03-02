<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin.shaw@jsonapi-tutorial.test',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role' => 'admin'
        ]);

        $author = User::create([
            'name' => 'Artie Shaw',
            'email' => 'artie.shaw@jsonapi-tutorial.test',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $commenter = User::create([
            'name' => 'Benny Goodman',
            'email' => 'benny.goodman@jsonapi-tutorial.test',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $tag1 = Tag::create(['name' => 'Laravel']);
        $tag2 = Tag::create(['name' => 'JSON:API']);

        $category1 = Category::create(['name' => 'About Laravel']);
        $category2 = Category::create(['name' => 'About JSON:API']);

        $post = new Post([
            'title' => 'Welcome to Laravel JSON:API',
            'published_at' => now(),
            'content' => 'In our first blog post, you will learn all about Laravel JSON:API...',
            'slug' => 'welcome-to-laravel-jsonapi',
        ]);

        $post->author()->associate($author)->save();
        $post->tags()->saveMany([$tag1, $tag2]);
        $post->categories()->saveMany([$category1, $category2]);

        $comment = new Comment([
            'content' => 'Wow! Great first blog article. Looking forward to more!',
        ]);

        $comment->post()->associate($post);
        $comment->user()->associate($commenter)->save();
    }
}
