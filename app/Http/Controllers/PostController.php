<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\StorePostRequest;
use Image;
use Storage;


class PostController extends Controller
{
    //


    public function getPosts(Request $request){
 
        $limit = $request->perPage ? $request->perPage : 10;
        $offset = ($request->current - 1) * $limit;
        
        
        $q = $request->q;

        $post = Post::where('title','LIKE', "%$q%");
        
        if($request->category){
            $post->where('category', $request->category);
        }

        if($request->sort){
            $sort = explode(',', $request->sort);
            $post->orderBy($sort[0], $sort[1]);

        }

        $count = $post->get()->count();
        return [
            'data' => $post->offset($offset)->limit($limit)->get(),
            'pageFilter' => [
                'perPage' => $request->perPage,
                'current' => $request->current,
                'total' =>  $count
            ]
        ];
    }

    public function get($id){

        $post = Post::find($id);
        if(!$post){
            $res = [
                "error" => "Post Not Found",
                "data" => $post
            ];
            return response($res, 404);
        }
        return $post;
    }

    public function getBySlug($slug){

        $post = Post::where('slug', $slug)->first();
        if(!$post){
            $res = [
                "error" => "Post Not Found",
                "data" => $post
            ];
            return response($res, 404);
        }
        $post->next = $post->next();
        $post->prev = $post->prev();
        
        return $post;
    }

    public function store(StorePostRequest $request){
        $post = $request->id !== 0 ? Post::find($request->id) : new Post;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category = $request->category;
        $post->thumbnail = $this->saveThumbnail($request->thumbnail);
        $post->description = $request->description;
        $post->author = $request->author;
        $post->content = $request->content;

        $post->save();

        return $post;
    } 

    public function remove($id){
        Post::find($id)->delete();
        return ["Message" => "Post Deleted"];
    }

    private function saveThumbnail($thumbnail){
        $url = $thumbnail;
        // Save to storage
        if( $this->isBase64($thumbnail) ){
            $name = "pi_" . time() . rand(0,99) . ".jpg";
            $url = $this->addToStorage($name,$thumbnail);
        }
        return $url;
    }

    private function addToStorage($name,$thumbnail){
        $imgName = "thumbnail/$name"; 
        $img = Image::make($thumbnail);


        $img->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->resizeCanvas(150, 150);

        $img->stream();
        Storage::disk('public')->put($imgName,$img);
        return asset(Storage::url($imgName));
    }

    private function isBase64($src){
        return preg_match('/^data:image\/(\w+);base64,/', $src);
    }


}
