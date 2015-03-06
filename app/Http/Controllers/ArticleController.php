<?php namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class ArticleController extends Controller {

    protected $repository;

    public function __construct(ArticleRepository $post)
    {
        $this->middleware('auth', ['except' => 'index']);
        $this->repository = $post;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$articles = $this->repository->latest10();
        return view('articles.index', compact('articles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('articles.create');
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleRequest $request
     * @return Response
     */
	public function store(ArticleRequest $request)
	{
        $this->repository->create($request->all());
        return Redirect::route('articles.index');
	}
}
