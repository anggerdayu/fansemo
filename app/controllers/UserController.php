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

    public function doLogout(){
    	Auth::logout();
    	return 'true';
    }

}
