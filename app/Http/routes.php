<?php

/*
|--------------------------------------------------------------------------
| Schema builder route
|--------------------------------------------------------------------------
|
*/
// Visit this route once to generate the tables in our db.
// See App/Http/Controllers/TempController@makedb

Route::get('/makedb', 'TempController@makedb');


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*
* Non authenticated routes
*
**/

// GET routes
Route::get('/', 'PageController@index');
Route::get('/login', 'PageController@login');

Route::get('/invite/{hashid}/{slug}', 'PageController@invite');
Route::get('/invite/{hashid}/{slug}/{context}', 'PageController@inviteWithContext');

Route::get('/game/consoles', 'GameController@formConsoles');

Route::get('/g/{username}', function($username) {
    return redirect("/gamer/$username", 301);
});
Route::get('/gamer/{username}', 'PageController@userProfile');

Route::get('/c/{hashid}/{crewname}', function($hashid, $crewname) {
    return redirect("/crew/$hashid/$crewname", 301);
});
Route::get('/crew/{hashid}/{crewname}', 'PageController@crewPage');



// POST routes
Route::post('/login', ['as' => 'user.login', 'uses' => 'UserController@login']);
Route::post('/register', ['as' => 'user.register', 'uses' => 'UserController@register']);
Route::post('/game/search', 'GameController@search');

Route::post('/invite/upvote', 'InviteController@upvote');
Route::post('/invite/downvote', 'InviteController@downvote');
Route::post('/invite/{hashid}/{slug}', 'InviteController@comment');

Route::post('/comment/upvote', 'CommentController@upvote');
Route::post('/comment/downvote', 'CommentController@downvote');

/**
*
* User authenticated routes
*
**/
Route::group(['middleware' => 'auth'], function()
{
	// Routes that should only be accesible if the user has successfully
	// logged in. If the user is not logged in, we redirect him to the
	// login page. We can control this behaviour in
	// App\Http\Middleware\Authenticate


	// GET routes
	Route::get('/logout', 'UserController@logout');

	Route::get('/settings', 'PageController@settings');
	Route::get('/account/connect/psn', 'PageController@connectPsn');
	Route::get('/account/connect/xbl', 'PageController@connectXbl');
	Route::get('/account/connect/steam', 'PageController@connectSteam');
	Route::get('/account/disconnect/{platform}/{username}', 'ProfileController@disconnect');

	Route::get('/notification', 'UserController@checkNotification');
	Route::get('/notifications', 'PageController@notifications');

	Route::get('/invite', 'PageController@inviteForm');

	Route::get('/crew/create', 'PageController@crewForm');


	// POST routes
    Route::post('account/connect/psn', 'PlatformValidatorController@validatePsn');
    Route::post('account/connect/xbl', 'PlatformValidatorController@validateXbl');
    Route::post('account/connect/steam', 'PlatformValidatorController@validateSteam');

    Route::post('/markasread', 'UserController@markNotificationAsRead');

    Route::post('/invite', 'InviteController@invite');

});



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| The following routes are API related
|
*/
Route::group(['prefix' => 'api'], function()
{
    Route::get('user/{username}', function()
    {
        // Matches "/api/user/noodles_ftw" URL
    });
});