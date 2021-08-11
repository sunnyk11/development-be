<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use DB;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Auth;
use App\Models\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //echo "Success";
        //return $request->get();
		//echo $request;
        //return Post::where('posts', Post::orderBy('updated_at', 'DESC')->get());
        //$posts = DB::select('select * from posts');
        //return $posts = DB::table('posts')->get();
		//return $posts = DB::table('posts')->orderBy('updated_at', 'DESC')->paginate(5);
		
		return $posts = DB::table('posts')
		->join('users', 'posts.created_by','=','users.id')
		->select('posts.*', 'users.id', 'users.name', 'users.profile_pic')
		->orderBy('updated_at', 'DESC')
		->paginate(5);
		
    }
	
	public function index_latest(Request $request)
    {	
		return $posts = DB::table('posts')
		->join('users', 'posts.created_by','=','users.id')
		->select('posts.*', 'users.id', 'users.name', 'users.profile_pic')
		->orderBy('updated_at', 'DESC')
		->take(3)->get();
		
    }
	

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'postImage' => 'required|mimes:jpg,png,jpeg',
			'category' => 'required'
			//'post_image' => 'required|image|mimes:jpg,png,jpeg'
			
        ]); 

        //$newPostImageName = uniqid() . '-' . $request->title . '.' . $request->post_image->extension();
		$newPostImageName = uniqid() . '-' . $request->file('postImage')->getClientOriginalName();

        $request->file('postImage')->move(public_path('storage/images'), $newPostImageName);

        Post::create([
            'title' => $request->input('title'),
			'views' => 0,
            'description' => $request->input('description'),
			'category' => $request->input('category'),
			'slug' => SlugService::createSlug(Post::class, 'slug', $request->title),
			'image_path' => $newPostImageName,
			'created_by' => $request->input('created_by'),
            //'image_path' => $newPostImageName
            
        ]);
		
		return response() -> json ([
            'message' => 'The post has been created'
        ], 201); 

        //return redirect('/blog')->with('message', 'Your post has been added!');
		
		//dd($request->all());
		/*if ($request->hasFile('image'))
      {
            $file      = $request->file('post_image');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = date('His').'-'.$filename;
            $file->move(public_path('store/images'), $picture);
            return response()->json(["message" => "Image Uploaded Succesfully"]);
      } 
      else
      {
            //return response()->json(["message" => "Select image first."]);
			return $request->all();
      } */
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($post)
    {
		//$selected_post = DB::table('posts')->get()->where('slug', $post);
		
		//return $posts = DB::table('posts')
		//->join('users', 'posts.created_by','=','users.id')
		//->select('posts.*', 'users.id', 'users.name', 'users.profile_pic')
		
		DB::table('posts')->where('slug', $post)->increment('views');
		$selected_post = DB::table('posts')
		->join('users', 'posts.created_by','=','users.id')
		->select('posts.*', 'users.id', 'users.name', 'users.profile_pic')
		->where('slug', $post)->get();
		//$selected_post->increment('views');
		//$selected_post = Post::where('slug', $post)->get();
		//echo $post;
		return $selected_post;
		
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'postImage' => 'required|mimes:jpg,png,jpeg',
			'category' => 'required',
			//'post_image' => 'required|image|mimes:jpg,png,jpeg'
			
        ]); 
		
		$updatedPostImageName = uniqid() . '-' . $request->file('postImage')->getClientOriginalName();

        $request->file('postImage')->move(public_path('storage/images'), $updatedPostImageName);
		
		Post::where('slug', $slug)->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
			'category' => $request->input('category'),
            'slug' => SlugService::createSlug(Post::class, 'slug', $request->title),
			'image_path' => $updatedPostImageName,
			'created_by' => $request->input('created_by'),
        ]);
		
		return response() -> json ([
            'message' => 'The post has been updated'
        ], 201); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
		$post = Post::where('slug', $slug);
        $post->delete();
        return response() -> json ([
            'message' => 'The post has been deleted.'
        ]); 
    }
}
