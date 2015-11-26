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
    Route::get('/fresh', 'HomeController@fresh');
    Route::get('/trending', 'HomeController@trending');
    Route::get('/post/{id}', 'PostController@post');
    Route::get('/halloffame', 'HomeController@hof');
    Route::get('/halloffame2', 'HomeController@hof2');
    Route::get('/fblogin', 'UserController@loginWithFacebook');
    Route::get('/gplogin', 'UserController@loginWithGoogle');

    Route::get('/fbsignup', 'UserController@registerWithFacebook');
    Route::get('/gpsignup', 'UserController@registerWithGoogle');
    Route::get('/profile/{username}', 'PostController@userpage');
    Route::get('/verifyregistration/{hash}','UserController@verify');

    Route::get('/next/{type}/{page}','PostController@ajaxGetNextPage');
    Route::post('/like','VoteController@likePost');
    Route::post('/dislike','VoteController@dislikePost');
    Route::post('/commentlike','VoteController@likeCommentPost');
    Route::post('/commentdislike','VoteController@dislikeCommentPost');
    Route::post('/getnextcomments','PostController@ajaxloadcomment');
    Route::post('/ajaxRegSosmed','UserController@regSosmed');

    Route::post('/chlang', 'BaseController@changeLanguage');
    Route::post('/register', 'UserController@register');
    Route::post('/login', 'UserController@doLogin');
    Route::post('/logout', 'UserController@doLogout');
    Route::post('/forgetpass', 'UserController@forget');
    Route::get('/resetpassword/{code}', 'UserController@reset');
    Route::post('/resetpassword', 'UserController@doReset');

    Route::get('imgpost/{uid}/{src}',function($uid,$src) {
        $cacheImage = Image::cache(function($image) use ($uid,$src){
            $image->make(asset("/usr/$uid/".$src))->fit(370,370);
        },9000,true);
        
        return Response::make($cacheImage,200,array('Content-type'=>'image/jpeg'));
    });

    Route::get('imgpost/landscape/{uid}/{src}',function($uid,$src) {
        $cacheImage = Image::cache(function($image) use ($uid,$src){
            $image->make(asset("/usr/$uid/".$src))->fit(600,266);
        },9000,true);
        
        return Response::make($cacheImage,200,array('Content-type'=>'image/jpeg'));
    });

    Route::get('test', function(){
            Mail::send('emails.message', array('desc' => 'test'), function($message)
            {
                $message->to('vendera.hadi@gmail.com', 'admin')->subject('Tifosiwar Alert');
            });
    });

    Route::group(array('before' => 'auth'), function(){
        Route::get('upload','PostController@upload');
        Route::post('upload','PostController@postImage');
        Route::post('ajaxupload', 'PostController@ajaxupload');
        Route::get('myposts','PostController@myPosts');
        Route::post('insertcomment','PostController@insertcomment');
        Route::get('me', 'UserController@mypage');
        Route::get('changepassword', 'UserController@chpasspage');
        Route::post('chpassword','UserController@chpass');
        Route::post('changepp','UserController@changepp');
        Route::post('chteam','TeamController@chteam');
        Route::get('getteams','TeamController@getteams');
        Route::get('deletepost/{id}','PostController@deletePost');
        Route::post('deletecomment','PostController@deleteComment');

        Route::get('admin/teams','TeamController@adminTeamPage')->before('isadmin');
        Route::get('admin/banners','BannerController@index')->before('isadmin');
        Route::get('admin/addteam','TeamController@adminAddTeam')->before('isadmin');
        Route::get('admin/editteam/{id}','TeamController@adminEditTeam')->before('isadmin');
        Route::get('admin/deleteteam/{id}','TeamController@deleteTeam')->before('isadmin');
        Route::post('admin/insertteam','TeamController@insertTeam')->before('isadmin');
        Route::post('admin/updateteam','TeamController@updateTeam')->before('isadmin');
        Route::get('setfeaturedpost/{id}','PostController@setFeatured')->before('isadmin');
        Route::get('unsetfeaturedpost/{id}','PostController@unsetFeatured')->before('isadmin');
        Route::get('admin/badges','BadgeController@index')->before('isadmin');
        Route::get('admin/addbadge', 'BadgeController@add')->before('isadmin');
        Route::get('admin/editbadge/{id}', 'BadgeController@edit')->before('isadmin');
        Route::get('admin/deletebadge/{id}', 'BadgeController@delete')->before('isadmin');
        Route::post('admin/insertbadge', 'BadgeController@insert')->before('isadmin');
        Route::post('admin/updatebadge', 'BadgeController@update')->before('isadmin');
        Route::get('admin/featuredvideo', 'HomeController@featuredvideo')->before('isadmin');
        Route::post('admin/chfeaturedvideo','HomeController@chfeaturedvideo')->before('isadmin');
        Route::get('admin/addbanner', 'BannerController@add')->before('isadmin');
        Route::post('admin/insertbanner', 'BannerController@insert')->before('isadmin');
        Route::get('admin/editbanner/{id}', 'BannerController@edit')->before('isadmin');
        Route::post('admin/updatebanner', 'BannerController@update')->before('isadmin');
        Route::get('admin/deletebanner/{id}', 'BannerController@delete')->before('isadmin');
    });
});
