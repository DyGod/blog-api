<?php

use Illuminate\Database\Seeder;
use App\Post;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->seedFood();
        $this->seedTravel();
        $this->seedBusiness();

    }
    private function seedFood()
    {
        $path = storage_path() . "/app/public/food.json";

        $data = file_get_contents($path);  
        $data = json_decode($data, true);

        foreach($data as $row){
            $post = [
                'title' => $row['title'],
                'slug' =>  Str::slug($row['title'], "-"),
                'content' => $row['content'],
                'category' => 'Food',
                'thumbnail' => $row['thumbnail'],
                'description' => $row['description'],
                'author' => 'Lifestyle Admin'
            ];
            Post::create($post);
        }
    }

    private function seedTravel()
    {
        $path = storage_path() . "/app/public/travel.json";

        $data = file_get_contents($path);  
        $data = json_decode($data, true);

        foreach($data as $row){
            $post = [
                'title' => $row['title'],
                'slug' =>  Str::slug($row['title'], "-"),
                'content' => $row['content'],
                'category' => 'Travel',
                'thumbnail' => $row['thumbnail'],
                'description' => $row['description'],
                'author' => 'Lifestyle Admin'
            ];
            Post::create($post);
        }
    }

    private function seedBusiness(){
        $path = storage_path() . "/app/public/business.json";

        $data = file_get_contents($path);  
        $data = json_decode($data, true);

        foreach($data as $row){
            $post = [
                'title' => $row['title'],
                'slug' =>  Str::slug($row['title'], "-"),
                'content' => $row['content'],
                'category' => 'Business',
                'thumbnail' => $row['thumbnail'],
                'description' => $row['description'],
                'author' => 'Lifestyle Admin'
            ];
            Post::create($post);
        }
    }
}
