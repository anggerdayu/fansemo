<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::group(array('before' => 'lang'), function()
{
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@test');
    Route::get('/trending', 'HomeController@trending');
    Route::get('/post/{id}', 'PostController@post');
    Route::get('/halloffame', 'HomeController@hof');

    Route::get('/next/{type}/{page}','PostController@ajaxGetNextPage');
    Route::post('/like','VoteController@likePost');
    Route::post('/dislike','VoteController@dislikePost');

    Route::post('/chlang', 'BaseController@changeLanguage');
    Route::post('/register', 'UserController@register');
    Route::post('/login', 'UserController@doLogin');
    Route::post('/logout', 'UserController@doLogout');

    Route::get('imgpost/{uid}/{src}',function($uid,$src) {
        $cacheImage = Image::cache(function($image) use ($uid,$src){
            $image->make(asset("/usr/$uid/".$src))->fit(266,266);
        },10,false);
        
        return Response::make($cacheImage,200,array('Content-type'=>'image/jpeg'));
    });

    Route::group(array('before' => 'auth'), function(){
        Route::get('upload','PostController@upload');
        Route::post('upload','PostController@postImage');
        Route::post('ajaxupload', 'PostController@ajaxupload');
        Route::get('myposts','PostController@myPosts');
        Route::post('insertcomment','PostController@insertcomment');
        Route::get('me', 'UserController@mypage');
        Route::post('chpassword','UserController@chpass');
        Route::post('chteam','TeamController@chteam');
        Route::get('getteams','TeamController@getteams');
    });
});
