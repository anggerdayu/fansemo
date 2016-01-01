<?php

class UserControllerMobile extends BaseController {

    public function signin(){
        $data['page'] = 'signin';
        return View::make('mobile.signin')->with($data);
    }

    public function get_prev_page($url){
        if(!empty($url)){
            $array_url = explode('/', $url);
            $get_end = end($array_url);
            return $get_end;
        }
    }

    public function doLogin(){
    	$email = Input::get('email');
    	$password = Input::get('password');
    	$remember = Input::has('remember') ? true : false;
    	$remember = true;
    	$rules = array(
    			'email' => 'required',
		    	'password' => 'required'
    		);
    	$validator = Validator::make(Input::all(),$rules);

		if ($validator->fails()){
		    // if validation fails redirect back to login
            return Redirect::to('signin')->withInput(Input::except('password'))->withErrors($validator);
		}else{
			// check email at db
			if (Auth::attempt(array('email' => $email, 'password' => $password),$remember)){
			    if(Session::has('pre_login_url')){
                    $url = Session::get('pre_login_url');
                    $prev_page = $this->get_prev_page($url);
                    Session::forget($url);
                    if($prev_page != 'signin' && $prev_page != 'signup'){
                        return Redirect::to($url);    
                    }else{
                        return Redirect::to('/');    
                    }
                }else{
                    return Redirect::to('/');
                }
			}else{
                // check username
                if (Auth::attempt(array('username' => $email, 'password' => $password),$remember)){
                    if(Session::has('pre_login_url')){
                        $url = Session::get('pre_login_url');
                        $prev_page = $this->get_prev_page($url);
                        Session::forget($url);
                        if($prev_page != 'signin'){
                            return Redirect::to($url);    
                        }else{
                            return Redirect::to('/');    
                        }
                    }else{
                        return Redirect::to('/');    
                    }
                }else{
                    Session::flash('not_match','wrong email and password match');
                    return Redirect::to('signin');
                }
					
			}
		}
    }

    public function signup(){
        $data['page'] = 'signup';
        return View::make('mobile.signup')->with($data);
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
		    // $messages = $validator->messages();
		    return Redirect::to('signup')->withInput(Input::all())->withErrors($validator);
		}else{
            $captcha= Input::get('g-recaptcha-response');
            if(!$captcha)
                Session::flash('alert_captcha','Please check the the captcha form');
                return Redirect::to('signup');

            $captchaResponse =file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfoDA8TAAAAALdH7bSRKE0ve2ORX57YzwTVoWZT&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
            $captchaResponse = json_decode($captchaResponse, true);

            if($captchaResponse['success']==false)
                Session::flash('alert_captcha',"Sorry, you are a spammer. We can't let you in");
                return Redirect::to('signup');

			$password = Input::get('password');
			$email = Input::get('email');
			$username = Input::get('username');

            $hash = str_random(20);
			$user = new User;
			$user->username = $username;
			$user->email = $email;
			$user->password = Hash::make($password);
			$user->status = 'member';
            $user->register_token = $hash;
			$user->save();

            $desc = 'Thank you '.$username.' for joining us, to verify your Registration Process, please click this <a href="'.url('verifyregistration/'.$hash).'">LINK</a>';
            Mail::send('emails.message', array('desc' => $desc), function($message) use($email, $username)
            {
                $message->to($email, $username)->subject('Tifosiwar Registration Confirmation');
            });
            $desc = 'New registration has been made from email : '.$email.', username : '.$username.' and IP Address : '.$_SERVER['REMOTE_ADDR'];
            Mail::send('emails.message', array('desc' => $desc), function($message) use($email, $username)
            {
                $message->to('admin@tifosiwar.com', 'Tifosiwar Auto System')->subject('Tifosiwar New Registration');
            });    

			Auth::loginUsingId($user->id);
			// sementara direct ke home
            return Redirect::to('/');
		}
    }

    public function mypage(){
    	$data['page'] = 'me';
    	$data['team'] = Team::find(Auth::user()->team_id);
    	return View::make('mobile.user.profile')->with($data);
    }

    public function chpasspage(){
    	$data['page'] = 'me';
    	return View::make('mobile.user.changepass')->with($data);	
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
	        if(!isset($result["email"])){
                Session::flash('warning','Your facebook account doesn\'t have a valid email, Try to change another account to register');
                return Redirect::to('/');
            } 

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
	    $googleService = OAuth::consumer( 'Google' ,url('gpsignup'));
	    // check if code is valid

	    // if code is provided get user data and sign in
	    if ( !empty( $code ) ) {
	        // This was a callback request from google, get the token
	        $token = $googleService->requestAccessToken( $code );
	        // Send a request with it
	        $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );
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
	        if(!isset($result["email"])){
                Session::flash('warning','Your facebook account doesn\'t have a valid email, Try to change another account to register');
                return Redirect::to('/');
            }
            
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
	        $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );
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
        $user->verified = 1;
		$user->save();
		Session::flash('warning','Congratulations, your username is registered');
		return 'success';
	}

    public function forgotpass(){
        $data['page'] = 'forgotpass';
        return View::make('mobile.user.forgotPass')->with($data);
    }

	public function forget(){
		$rules = array(
    			'email' => 'email|required',
    		);
		$email = Input::get('email');
    	$validator = Validator::make(array('email'=>$email),$rules);

		if ($validator->fails()){
		    $messages = $validator->messages();
		    foreach ($messages->all() as $message) {
		    	return $message;
		    }
		}else{
			// check email
			$getEmail = User::where('email',$email)->first();
			if(!$getEmail){
				return 'Your email haven\'t registered yet into our system';
			}else{
				$hash = str_random(20);
				$user = $getEmail->username;
				$forgetpass = new ForgetPass;
				$forgetpass->email = $email;
				$forgetpass->hash = $hash;
				$forgetpass->save();
				// send email
				Mail::send('emails.message2', array('hash' => $hash), function($message) use($email,$user)
				{
				    $message->to($email, $user)->subject('Tifosiwar Forget Password');
				});
				return 'success';
			}
		}
	}

	public function reset($hash){
		// cek hash
		$getHash = ForgetPass::where('hash',$hash)->orderBy('created_at','desc')->first();
		// if not return warning modal else modal change password
		if($getHash){
			$email = $getHash->email;
			$user = User::where('email',$email)->first();
			Session::flash('reset',$user->id);
		}else{
			Session::flash('warning','Please try to reset email again, we can\'t find reset password records in our data');
		}
		return Redirect::to('/');
	}

	public function doReset(){
		$rules = array(
			'user_id' => 'required',
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
			// change password
			$userId = Input::get('user_id');
			$password = Input::get('password');
			$user = User::find($userId);
			$user->password = Hash::make($password);
			$user->save();
			// attempt login
			Auth::loginUsingId($user->id);
			// set message
			Session::flash('warning','Congratulations, your password has been reset successfully');
			return 'success';
		}
	}

    public function verify($hash){
        $user = User::where('register_token',$hash)->orderBy('created_at','desc')->first();
        if(!$user){
            Session::flash('warning','Sorry we can\'t search this user in our system');
        }else{
            $user->verified = 1;
            $user->save();
            Session::flash('warning','Thank you for registering, you are now verified');
        }
        return Redirect::to('/');
    }

    public function doLogout(){
    	Auth::logout();
        
    	return Redirect::to('signin');
    }

}
