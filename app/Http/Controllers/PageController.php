<?php namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Console;
use App\Models\Post;
use App\Enums\Categories;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Comment;

class PageController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Page Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles all page routes. All views are located in
	| resources/views
	|
	*/

	/**
	*
	* Show the application's index page
	*
	**/
	public function index(Request $request)
    {
		$category     = $request->input('category', false);
		$platform     = $request->input('platform', false);
		$sort         = $request->input('sort', 'new');
		$limit        = (int)$request->input('limit', 10);
		$after        = decodeHashId($request->input('after', 0));
		$fromTimezone = $request->input('ftz');
		$toTimezone   = $request->input('ttz');
		$useTimezone  = $fromTimezone != null;
		$t            = $request->input('t', 'day');
		$guardedLimit = min($limit, 100);
		$guardedLimit = max($guardedLimit, 1);
		$to           = Carbon::now();
		$from         = stringToFromDate($t);


    	if ($category != false)
    	{
			switch($category)
			{
				case "anytime":
					$category = Categories::ANYTIME;
					break;
				case "planned":
					$category = Categories::PLANNED;
					break;
				case "asap":
					$category = Categories::ASAP;
					break;
			}

			$posts = Post::where('category', $category)->orderBy('created_at', ($sort == 'new' ? 'DESC' : 'ASC'))->take($limit)->get();
    	}
    	else
    	{
    		$posts = Post::orderBy('created_at', ($sort == 'new' ? 'DESC' : 'ASC'))->take($limit)->get();
    	}


        if ($request->ajax())
            return invitesToDtos($posts);


        # Only fetch topPlayers if $request is not ajax
        $topPlayers = User::topPlayers();


		return view('pages.index', ['posts' => $posts, 'topPlayers' => $topPlayers]);
	}


	/**
	*
	* The login / register page
	*
	**/
	public function login()
	{
		return view('pages.login');
	}


	/**
	*
	* User settings page
	*
	**/
	public function settings()
	{
		return view('pages.users.settings');
	}


	/**
	*
	* Notifications page
	*
	**/
	public function notifications()
	{
		$notifications = Auth::user()->rNotifications()->orderBy('id', 'DESC')->get();

		return view('pages.notifications')->with(['notifications' => $notifications]);
	}


	/**
	*
	* Connect PSN page
	*
	**/
	public function connectPsn()
	{
		return view('pages.connect.psn');
	}


	/**
	*
	* Connect XBL page
	*
	**/
	public function connectXbl()
	{
		return view('pages.connect.xbl');
	}


	/**
	*
	* Connect Steam page
	*
	**/
	public function connectSteam()
	{
		return view('pages.connect.steam');
	}


	/**
	*
	* Post Form page
	*
	**/
	public function postForm()
	{
		$consoles = Console::all();

        $consoleSelections = ['0' => 'Select a console'];
        foreach ($consoles as $console)
        {
            $consoleSelections[] = $console->name;
        }

		return view('pages.posts.form', [ 'consoleSelections' => $consoleSelections]);
	}


	/**
	*
	* Post details page
	*
	**/
	public function post($hashid, $slug)
	{
		$post = Post::find(decodeHashId($hashid));

		if (!$post)
			return redirect('/page-not-found');

		return view('pages.posts.detailpage', ['post' => $post]);
	}

    /**
     *
     * Post details page
     *
     **/
    public function postWithContext(Request $request, $hashid, $slug, $context)
    {
        $post = Post::find(decodeHashId($hashid));

        if (!$post)
            return redirect('/page-not-found');

        $comment = Comment::find(decodeHashId($context));

        if (!$comment)
            return redirect('/page-not-found');

        $context = max((int)$request->input("context", 0), 0);

        return view('pages.posts.detailpage', ['post' => $post, 'context' => $context, 'comment' => $comment]);
    }


    /**
    *
    * User profile page
    *
    **/
    public function userProfile($username)
    {
    	$user = User::where('username', $username)->first();

    	if (!$user)
    		return redirect('/gamer-not-found');

    	return view('pages.users.profile', ['user' => $user]);
    }

}
