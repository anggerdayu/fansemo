<?php

class UserController extends BaseController {

    public function doLogin(){
    	$email = Input::get('email');
    	$password = Input::get('password');
    	$remember = Input::has('remember') ? true : false;
    	$rules = array(
    			'email' => 'required|email',
		    	'password' => 'required'
    		);
    	$validator = Validator::make(Input::all(),$rules);

		if ($validator->fails()){
		    $messages = $validator->messages();
		    foreach ($messages->all() as $message) {
		    	return $message;
		    }
		}else{
			// check username at db
			if (Auth::attempt(array('email' => $email, 'password' => $password),$remember)){
			    return 'success';
			}else{
				return 'wrong email and password match';
			}
		}
    }

    public function register(){
    	$rules = array(
    			'username' => 'required|unique:users', 
    			'email' => 'required|email|unique:users',
		    	'password' => 'required|alpha_num|min:6',
        		'password_confirmation' => 'required|same:password' 
    		);
    	$validator = Validator::make(Input::all(),$rules);

    	if ($validator->fails()){
		    $messages = $validator->messages();
		    foreach ($messages->all() as $message) {
		    	return $message;
		    }
		}else{
			$password = Input::get('password');
			$email = Input::get('email');
			$username = Input::get('username');

			$user = new User;
			$user->username = $username;
			$user->email = $email;
			$user->password = Hash::make($password);
			$user->status = 'member';
			$user->save();

			Auth::loginUsingId($user->id);
			return 'success';
		}
    }

    public function mypage(){
    	$data['page'] = 'me';
    	$data['team'] = Team::find(Auth::user()->team_id);
    	return View::make('user.profile')->with($data);
    }

    public function chpasspage(){
    	$data['page'] = 'me';
    	return View::make('user.changepass')->with($data);	
    }

    public function chpass(){
    	$rules = array(
    			'oldpass' => 'required|match_old_pass', 
    			'newpass' => 'required|confirmed',
		    	'newpass_confirmation' => 'required|alpha_num|min:6' 
    		);
    	$messages = array(
		    'match_old_pass' => 'Wrong old password'
		);

		Validator::extend('match_old_pass', function($attribute, $value, $parameters)
		{
		    return Hash::check(Input::get('oldpass'),Auth::user()->password);
		});
    	$validator = Validator::make(Input::all(),$rules,$messages);
    	
    	if ($validator->fails()){
	    	return Redirect::to('changepassword')->withErrors($validator)->withInput();
	    }else{
	    	$user = User::find(Auth::user()->id);
		    $user->password = Hash::make(Input::get('newpass'));
		    $user->save();
	    	Session::flash('success','success');
	    	return Redirect::to('changepassword');
	    }
    }

    public function changepp(){
    	$image = explode('/',Input::get('img'));
		$image = urldecode(end($image));
		$extension = explode(".", $image);
		$extension = end($extension);

		// intervention
		list($width, $height) = getimagesize('files/'.$image);
		$img = Image::make('files/'.$image);
		$img->resize(160, null, function ($constraint) {
		    $constraint->aspectRatio();
		});
		$img->save('files/'.$image);
		$newname = date('YmdHis').'_'.Auth::id().'.'.$extension;
		File::move('files/'.$image, 'usr/pp/'.$newname);

		// change db
		$user = User::find(Auth::id());
		$user->profile_pic = $newname;
		$user->save();
		Session::flash('success', true);
		return 'success';
    }

    public function registerWithFacebook() {
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

	        // check user
	        $check = User::where('email',$result["email"])->first();
	        if($check){
	        	Session::flash('warning','This user was already registered');
	        	return Redirect::to('/');
	        }else{
	        	Session::flash('regSosmed','true');
	        	Session::flash('regemail', $result['email']);
	        	return Redirect::to('/');
	        }

	        // $message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
	        // echo $message. "<br/>";
	        // //Var_dump
	        // //display whole array().
	        // dd($result);
	    }
	    // if not ask for permission first
	    else {
	        // get fb authorization
	        $url = $fb->getAuthorizationUri();
	        // return to facebook login url
	         return Redirect::to( (string)$url );
	    }
	}

	public function registerWithGoogle() {
	    // get data from input
	    $code = Input::get( 'code' );
	    // get google service
	    $googleService = OAuth::consumer( 'Google' ,url('gplogin'));
	    // check if code is valid

	    // if code is provided get user data and sign in
	    if ( !empty( $code ) ) {
	        // This was a callback request from google, get the token
	        $token = $googleService->requestAccessToken( $code );
	        // Send a request with it
	        // $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );
	        // $message = 'Your unique Google user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
	        // echo $message. "<br/>";
	        //Var_dump
	        //display whole array().
	        $check = User::where('email',$result["email"])->first();
	        if($check){
	        	Session::flash('warning','This user was already registered');
	        	return Redirect::to('/');
	        }else{
	        	Session::flash('regSosmed','true');
	        	Session::flash('regemail', $result['email']);
	        	return Redirect::to('/');
	        }
	    }
	    // if not ask for permission first
	    else {
	        // get googleService authorization
	        $url = $googleService->getAuthorizationUri();
	        // return to google login url
	        // echo (string)$url;
	        return Redirect::to( (string)$url );
	    }
	}

	public function loginWithFacebook(){
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

	        // check user
	        $check = User::where('email',$result["email"])->first();
	        if($check){
	        	Auth::login($check);	
	        	return Redirect::to('/');
	        }else{
	        	Session::flash('warning','Oops you were not registered before using this account');
	        	return Redirect::to('/');
	        }
			
	    }
	    // if not ask for permission first
	    else {
	        // get fb authorization
	        $url = $fb->getAuthorizationUri();
	        // return to facebook login url
	         return Redirect::to( (string)$url );
	    }
	}

	public function loginWithGoogle() {
	    // get data from input
	    $code = Input::get( 'code' );
	    // get google service
	    $googleService = OAuth::consumer( 'Google' ,url('gplogin'));
	    // check if code is valid

	    // if code is provided get user data and sign in
	    if ( !empty( $code ) ) {
	        // This was a callback request from google, get the token
	        $token = $googleService->requestAccessToken( $code );
	        // Send a request with it
	        // $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );
	        // $message = 'Your unique Google user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
	        // echo $message. "<br/>";
	        //Var_dump
	        //display whole array().
	        $check = User::where('email',$result["email"])->first();
	        if($check){
	        	Auth::login($check);	
	        	return Redirect::to('/');
	        }else{
	        	Session::flash('warning','Oops you were not registered before using this account');
	        	return Redirect::to('/');
	        }
	    }
	    // if not ask for permission first
	    else {
	        // get googleService authorization
	        $url = $googleService->getAuthorizationUri();
	        // return to google login url
	        // echo (string)$url;
	        return Redirect::to( (string)$url );
	    }
	}

	public function regSosmed(){
		$username = Input::get('username');
		$email = Input::get('email');
		if(empty($username)) return 'Username is required';
		$checkuser = User::where('username',$username)->first();
		if(!empty($checkuser)) return 'Username was already exist, please change another username';

		// insert user
		$user = new User;
		$user->username = $username;
		$user->email = $email;
		$user->status = 'member';
		$user->save();
		Session::flash('warning','Congratulations, your username is registered');
		return 'success';
	}

    public function doLogout(){
    	Auth::logout();
    	return 'true';
    }

}
