<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Post;
use App\Category;
use App\Tag;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('VerifyCategoriesCount')->only('create', 'store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {

        // Upload image to the storage
        $image = $request->image->store('posts');

        // Create Post
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $image,
            'published_at' => $request->published_at,
            'category_id' => $request->category,
            'user_id' => auth()->user()->id
        ]);

        if($request->tags) {
            // Can use attach() because of belongsToMany R/L
            $post->tags()->attach($request->tags);
        }

        // Flash Message
        session()->flash('success', 'Post created successfully.');

        // Redirect User
        return redirect(route('posts.index'));
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->only(['title', 'description', 'published_at', 'content', 'category']);
        // Check if new image
        if($request->hasFile('image')) {
            // Upload it
            $image = $request->image->store('posts');

            // Delete old one
            $post->deleteImage();

            $data['image'] = $image;
        }

        // Adding category_id manually
        $data['category_id'] = $request->category;

        /**
         *
         * What This Is Gonna Do
         *
         * 1. Add Only Newly Added Tags,
         * 2. Remove Duplicates from previous list ( if any )
         * 3. If no new tag selected, Then previous ones are selected automatically
         * 4. This whole thing with sync() method, Only available for belongsToMany R/L
         *
        **/
        if($request->tags) {
            // sync(): Only available for belongsToMany R/L
            $post->tags()->sync($request->tags);
        }

        // Update attributes
        $post->update($data);

        // Flash message
        session()->flash('success', 'Post updated successfully.');

        // Redirect User
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        if($post->trashed()) {
            $post->deleteImage();   // Delete from storage
            $post->forceDelete();   // Delete form DB
            session()->flash('success', 'Post deleted successfully.');
        } else {
            $post->delete();
            session()->flash('success', 'Post trashed successfully.');
        }

        return redirect(route('posts.index'));
    }

     /**
     * Display list of trashed posts
     *
     * Fetch All Post, Not Trashed, using "all()"
     * Fetch ( All Posts + Trashed Posts ) using "withTrashed()"
     * Fetch ( Only Trashed Posts ) using "onlyTrashed()"
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashed = Post::onlyTrashed()->get();

        return view('posts.index')->with('posts', $trashed);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @desc withTrashed() => Query from only trashed posts not all posts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        $post->restore();

        session()->flash('success', 'Post restored successfully.');

        return redirect()->back();
    }
}
