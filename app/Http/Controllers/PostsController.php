<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use DB;
class PostsController extends Controller
{
	 public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }
	// All the methods created below are called resource methods are std given by
	//Laravel. This can be created at the time of controller making using
	// php artisan make:controller --resource
	
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	//POSTS::METHOD NAME IS THE ELOQUENT ORM MODEL THAT IS USED TO FIRE QUERIES
	//TRADITIONAL SQL CAN BE USED FOR THE SAME
    public function index()
    {
        /*
		$posts= Post::all(); Gets all the posts
		return Post::where('title','Post 2')->get(); 
		
		$posts= Post::orderBy('title','desc')->take(1)->get(); // here take works as LIMTI
		
		 **** TRADITIONAL SQL SYNTAX ****
		$posts=DB::select('select * from posts where id=2');
		$posts=DB::select('select * from posts');
		*/
		//$posts= Post::orderBy('title','desc')->get();// gets all the posts with title sorted in descending order. ->get() is compul when we use such clauses
		$posts= Post::orderBy('created_at','desc')->paginate(3);
		return view('posts.index')->with('posts',$posts);
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
		return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		$this->validate($request,[
			'title'=>'required',
			'body'=>'required',
			'cover_image' => 'image|nullable|max:1999'
		]);
		//Handle file
		if($request->hasFile('cover_pic')){
		//get file name with ext
			$fileNameWithExt=$request->file('cover_pic')->getClientOriginalName();
			//get just file name
			$fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
			//get just ext
			$ext=$request->file('cover_pic')->getClientOriginalExtension();
			//filename to store
			$fileNameToStore=$fileName.'_'.time().'.'.$ext;
			//Upload image
			$path=$request->file('cover_pic')->storeAs('public/cover_images',$fileNameToStore);
		}else{
			$fileNameToStore='no_image.jpg';
		}
		//Create post
		$post= new Post;
		$post->title=$request->input('title');
		$post->body=$request->input('body');
		$post->cover_image=$fileNameToStore;
//		auth() and user() are becasue of auth provided by laravel php artisan make:auth
		$post->user_id=auth()->user()->id;
		$post->save();
		
		return redirect('/posts')->with('success','Posts Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
		$post= Post::find($id); 
		return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
		$post= Post::find($id);
		 //check for corect user
		if(auth()->user()->id !== $post->user_id){
			return redirect('/posts')->with('error','Unauthorized Page');
		}
		
		return view('posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
		$this->validate($request,[
			'title'=>'required',
			'body'=>'required',
			'cover_image' => 'image|nullable|max:1999'
		]);
		
		if($request->hasFile('cover_pic')){
		//get file name with ext
			$fileNameWithExt=$request->file('cover_pic')->getClientOriginalName();
			//get just file name
			$fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
			//get just ext
			$ext=$request->file('cover_pic')->getClientOriginalExtension();
			//filename to store
			$fileNameToStore=$fileName.'_'.time().'.'.$ext;
			//Upload image
			$path=$request->file('cover_pic')->storeAs('public/cover_images',$fileNameToStore);
		}
		
		//Create post
		$post= Post::find($id );
		$post->title=$request->input('title');
		$post->body=$request->input('body');
		//if no new image is added then dont update existing one	
		if($request->hasFile('cover_pic')){
			$post->cover_image=$fileNameToStore;
		}
		$post->save();
		
		return redirect('/posts')->with('success','Posts Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
		$post= Post::find($id );
		//check for correct  user
		if(auth()->user()->id !== $post->user_id){
			return redirect('/posts')->with('error','Unauthorized Page');
		}
		if($post->cover_image!='no_image.jpg'){
			Storage::delete('public/cover_images/'.$post->cover_image);
		}
		$post->delete(); 
		return redirect('/posts')->with('success','Posts Deleted');
    }
}
