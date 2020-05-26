<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Post;
use App\Category;
use App\Tag;
use App\User;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Dummy Author
        $author1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        $author2 = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        // Dummy Categories
        $category1 = Category::create([
            'name' => 'News'
        ]);

        $category2 = Category::create([
            'name' => 'Marketing'
        ]);

        $category3 = Category::create([
            'name' => 'Partnership'
        ]);

        // Dummy Posts
        $post1 = Post::create([
            'title' => 'We relocated our office to a new designed garage',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s',
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
            'category_id' => $category1->id,
            'image' => 'posts/1.jpg',
            'user_id' => $author1->id   // Method One
        ]);

        $post2 = $author2->posts()->create([     // Method Two
            'title' => 'Top 5 brilliant content marketing strategies',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s',
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
            'category_id' => $category2->id,
            'image' => 'posts/2.jpg'
        ]);

        $post3 = $author1->posts()->create([
            'title' => 'Best practices for minimalist design with example',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s',
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
            'category_id' => $category3->id,
            'image' => 'posts/3.jpg'
        ]);

        $post4 = $author2->posts()->create([
            'title' => 'Congratulate and thank to Maryam for joining our team',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s',
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
            'category_id' => $category2->id,
            'image' => 'posts/4.jpg'
        ]);

        // Dummy Tags
        $tag1 = Tag::create([
            'name' => 'job'
        ]);

        $tag2 = Tag::create([
            'name' => 'customers'
        ]);

        $tag3 = Tag::create([
            'name' => 'records'
        ]);

        // Attach ( Or Join ) Posts and Tags
        $post1->tags()->attach([ $tag1->id, $tag2->id ]);
        $post2->tags()->attach([ $tag2->id, $tag3->id ]);
        $post3->tags()->attach([ $tag1->id, $tag3->id ]);
    }
}
