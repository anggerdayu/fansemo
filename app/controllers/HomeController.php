<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
		// latest / fresh
		$data['images'] = Post::orderBy('created_at','desc')->take(12)->get();
		return View::make('main')->with($data);
	}

	public function post()
	{
		return View::make('post');
	}

	public function hof()
	{
		return View::make('hof');
	}

	public function loginWithFacebook() {
	    // get data from input
	    $code = Input::get( 'code' );
	    // get fb service
	    $fb = OAuth::consumer( 'Facebook' );

	    // check if code is valid

	    // if code is provided get user data and sign in
	    if ( !empty( $code ) ) {
	        // This was a callback request from facebook, get the token
	        $token = $fb->requestAccessToken( $code );
	        // Send a request with it
	        $result = json_decode( $fb->request( '/me' ), true );
	        $message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
	        echo $message. "<br/>";
	        //Var_dump
	        //display whole array().
	        dd($result);
	    }
	    // if not ask for permission first
	    else {
	        // get fb authorization
	        $url = $fb->getAuthorizationUri();
	        // return to facebook login url
	         return Redirect::to( (string)$url );
	    }
	}

	public function test(){
		echo File::exists('usr/1'); die();
		$test = explode('/', 'http://localhost/fansemo/public/files/test.jpg');
		File::move('files/'.end($test), 'aaa.jpg');
	}

}
