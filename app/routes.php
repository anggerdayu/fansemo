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
    Route::get('/post/{id}', 'PostController@post');
    Route::get('/halloffame', 'HomeController@hof');
    Route::post('/ajaxupload', 'PostController@ajaxupload');

    Route::get('/next/{type}/{page}','PostController@ajaxGetNextPage');
    Route::get('/myposts','PostController@myPosts');

    Route::post('/chlang', 'BaseController@changeLanguage');
    Route::post('/register', 'UserController@register');
    Route::post('/login', 'UserController@doLogin');
    Route::post('/logout', 'UserController@doLogout');

    Route::get('imgpost/{uid}/{src}',function($uid,$src) {
        $cacheImage = Image::cache(function($image) use ($uid,$src){
            $image->make(URL::to('/'). "/usr/$uid/".$src)->fit(266,266);
        },10,false);
        
        return Response::make($cacheImage,200,array('Content-type'=>'image/jpeg'));
    });

    Route::group(array('before' => 'auth'), function(){
        Route::get('upload','PostController@upload');
        Route::post('upload','PostController@postImage');
    });
});
