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
		$data['page'] = 'home';
		$data['images'] = Post::orderBy('created_at','desc');
		$data['video'] = Featuredvideo::find(1);
		if(Auth::user()){
			$data['images'] = $data['images']->with(array('votes' => function($query){
														$query->where('user_id', Auth::id());
    												}))->take(12)->get();
		}else{
			$data['images'] = $data['images']->take(12)->get();
		}
		return View::make('main')->with($data);
	}

	public function test(){
		$data['page'] = 'home';
		return View::make('main2')->with($data);	
	}

	public function trending(){
		$data['page'] = 'trending';
		$data['images'] = Post::select('posts.*',DB::raw('count(votes.id) as total'))->leftJoin('votes', 'posts.id', '=', 'votes.post_id')
							->groupBy('posts.id')->orderBy('total','desc');
		if(Auth::user()){
			$data['images'] = $data['images']->with(array('votes' => function($query){
														$query->where('user_id', Auth::id());
    												}))->take(12)->get();
		}else{
			$data['images'] = $data['images']->take(12)->get();
		}
		return View::make('trending')->with($data);	
	}

	public function post()
	{
		return View::make('post');
	}

	public function hof()
	{
		$data['page'] = 'halloffame';
		$teams = array();
		// get yg plg aktif di vote
		$total_votes = Vote::select(DB::raw('count(votes.id) as total'),'teams.name','teams.id')->join('users','votes.user_id','=','users.id')->join('teams','users.team_id','=','teams.id')
							->groupBy('teams.id')->orderBy('total','desc')->take(5)->get();
		if($total_votes){
			foreach ($total_votes as $value) {
				$teams[$value->id] = $value->total;
			}
		}
		// get total komen aktif
		$total_comments = Comment::select(DB::raw('count(comments.id) as total'),'teams.name','teams.id')->join('users','comments.user_id','=','users.id')->join('teams','users.team_id','=','teams.id')
							->groupBy('teams.id')->orderBy('total','desc')->take(5)->get();
		if($total_comments){
			foreach ($total_comments as $value) {
				if(isset($teams[$value->id])) $teams[$value->id] = $teams[$value->id] + $value->total;
				else $teams[$value->id] = $value->total;
			}
		}
		// get total post
		$total_posts = Post::select(DB::raw('count(posts.id) as total'),'teams.name','teams.id')->join('users','posts.user_id','=','users.id')->join('teams','users.team_id','=','teams.id')
							->groupBy('teams.id')->orderBy('total','desc')->take(5)->get();
		if($total_posts){
			foreach ($total_posts as $value) {
				if(isset($teams[$value->id])) $teams[$value->id] = $teams[$value->id] + $value->total;
				else $teams[$value->id] = $value->total;
			}
		}	
		$winningteam = array_search(max($teams), $teams); 
		$data['clubwinner'] = Team::find($winningteam);
		return View::make('hof')->with($data);
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

	public function featuredvideo()
	{
		$data['page'] = 'me';
		$data['video'] = Featuredvideo::find(1);
		return View::make('admin.featuredvideo')->with($data);
	}

	public function chfeaturedvideo(){
		$rules = array(
    			'title' => 'required',
		    	'url' => 'required'
    		);
    	$validator = Validator::make(Input::all(),$rules);
    	if ($validator->fails()){
	    	return Redirect::to('admin/featuredvideo')->withErrors($validator)->withInput();
	    }else{
	    	$video = Featuredvideo::find(1);
	    	$video->title = Input::get('title');
	    	$video->url = Input::get('url');
	    	$video->save();
	    	Session::flash('success', true);
	    	return Redirect::to('admin/featuredvideo');	
	    }
	}

	// public function test(){
	// 	echo File::exists('usr/1'); die();
	// 	$test = explode('/', 'http://localhost/fansemo/public/files/test.jpg');
	// 	File::move('files/'.end($test), 'aaa.jpg');
	// }

}
