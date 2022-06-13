<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PutRequest;
use App\Http\Requests\Post\StoreRequest;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(10);
        return view('dashboard.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::pluck('id', 'title');
        $post = new Post();

        //dd($categories);

        // $posts = Post::get();

        //dd($posts);

        echo view('dashboard.post.create', compact('categories', 'post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        //
        //echo (request("title"));
        //echo $request->input('slug');

        // $validated = $request->validate(StoreRequest::myRules());

        //$request->validate(StoreRequest::myRules());
        //$validated = Validator::make($request->all(), StoreRequest::myRules());

        //dd($validated->failed());

        // $data = array_merge($request->all(), ['image' => '']);

        // dd($data);

        /*$data = $request->validated();

        $data['slug'] = Str::slug($data['tittle']);*/



        Post::create($request->validated());

        //
        //return route("post.create");
        //return redirect("/post/create");
        //return redirect()->route("post.create");
        return to_route("post.index")->with('status', "Registro creado.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        return view("dashboard.post.show", compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
        $categories = Category::pluck('id', 'title');

        //dd($categories);

        echo view('dashboard.post.edit', compact('categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PutRequest $request, Post $post)
    {
        $data =  $request->validated();
        if (isset($data["image"])) {

            $data["image"] = $filename = time() . "." . $data["image"]->extension();

            $request->image->move(public_path("image"), $filename);
        }
        //
        $post->update($data);
        //$request->session()->flash('status', "Registro actualizado.");
        return to_route("post.index")->with('status', "Registro actualizado.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        //echo "Destroy";
        $post->delete();

        return to_route("post.index")->with('status', "Registro eliminado.");
    }
}
