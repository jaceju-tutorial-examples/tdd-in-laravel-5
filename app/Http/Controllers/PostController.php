<?php namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Repositories\PostRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller {

    protected $post;

    public function __construct(PostRepository $post)
    {
        $this->middleware('auth', ['except' => 'index']);
        $this->post = $post;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$posts = $this->post->latest10();
        return view('post.index', compact('posts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('post.create');
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return Response
     */
	public function store(PostRequest $request)
	{
        $this->post->create($request->all());
        return Redirect::route('posts.index');
	}
}
