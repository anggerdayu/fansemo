
<?php

class HomeControllerMobile extends BaseController {

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

	public function index(){
		// latest / fresh
		$data['page'] = '';
		$data['video'] = Featuredvideo::find(1);
		$data['freshpost'] = Post::orderBy('created_at','desc')->first();
		$data['featuredpost'] = FeaturedPost::orderBy('id','desc')->with('post')->first();
		$data['trendingpost'] = Post::select('posts.*',DB::raw('count(votes.id) as total'))->leftJoin('votes', 'posts.id', '=', 'votes.post_id')
							->groupBy('posts.id')->orderBy('total','desc')->first();

		return View::make('mobile.main2')->with($data);	
	}

    public function featured(){
        // featured post
        $data['page'] = 'featured';
        $data['pagetype'] = 'featured';
        $data['images'] = FeaturedPost::orderBy('id','desc')->take(7)->with('post')->get();

        return View::make('mobile.scrollpost_featured')->with($data);
    }

	public function fresh()
	{
		// latest / fresh
		$data['page'] = 'home';
		$data['pagetype'] = 'fresh';
		$data['images'] = Post::orderBy('created_at','desc');
		if(Auth::user()){
			$data['images'] = $data['images']->with(array('votes' => function($query){
														$query->where('user_id', Auth::id());
    												}))->take(7)->get();
		}else{
			$data['images'] = $data['images']->take(7)->get();
		}
		return View::make('mobile.scrollpost')->with($data);
	}

	public function trending(){
		// crawl posts
		$this->crawlPosts();

		$data['page'] = 'trending';
		$data['pagetype'] = 'trending';
		// $data['images'] = Post::select('posts.*',DB::raw('count(votes.id) as total'))->leftJoin('votes', 'posts.id', '=', 'votes.post_id')
		// 					->groupBy('posts.id')->orderBy('total','desc');
		$data['images'] = Post::select('posts.*')->join('trending_posts', 'posts.id', '=', 'trending_posts.post_id')->orderBy('trending_posts.id');
		if(Auth::user()){
			$data['images'] = $data['images']->with(array('votes' => function($query){
														$query->where('user_id', Auth::id());
    												}))->take(7)->get();
		}else{
			$data['images'] = $data['images']->take(7)->get();
		}
		return View::make('mobile.scrollpost')->with($data);	
	}


	public function crawlPosts(){
		// get last post
		$lastpost = TrendingPost::orderBy('created_at')->take(1)->first(); 
		$crawl = false;
		if($lastpost){
			// check if created_at == today no crawl
			$datetime = explode(' ',$lastpost->created_at);
			$date = $datetime[0];
			$currentdate = date('Y-m-d');
			if($date != $currentdate) $crawl = true;
		}else{
			// crawl today's posts
			$crawl = true;
		}

		if($crawl){
			$yesterday = date('Y-m-d',strtotime("-1 days"));
			$yesterdayTrending = Post::select('posts.id',DB::raw('count(votes.id) as total'))->leftJoin('votes', 'posts.id', '=', 'votes.post_id')
							->where('posts.created_at','like',$yesterday.'%')->groupBy('posts.id')->orderBy('total','desc')->get();
			if(!empty($yesterdayTrending[0])){

				foreach ($yesterdayTrending as $key => $value) {
					//checking avoid double post
					$check = TrendingPost::where('post_id',$value->id)->first();
					if(empty($check))
						$insert[] = array('post_id'=>$value->id, 'total_votes'=>$value->total);
				}
				if(!empty($insert))
					TrendingPost::insert($insert);
			}
		}
	}

	public function post()
	{
		return View::make('mobile.post');
	}

	// public function hof2()
	// {
	// 	$data['page'] = 'halloffame';
	// 	$teams = array();
	// 	// get yg plg aktif di vote
	// 	$total_votes = Vote::select(DB::raw('count(votes.id) as total'),'teams.name','teams.id')->join('users','votes.user_id','=','users.id')->join('teams','users.team_id','=','teams.id')
	// 						->groupBy('teams.id')->orderBy('total','desc')->take(5)->get();
	// 	if($total_votes){
	// 		foreach ($total_votes as $value) {
	// 			$teams[$value->id] = $value->total;
	// 		}
	// 	}
	// 	// get total komen aktif
	// 	$total_comments = Comment::select(DB::raw('count(comments.id) as total'),'teams.name','teams.id')->join('users','comments.user_id','=','users.id')->join('teams','users.team_id','=','teams.id')
	// 						->groupBy('teams.id')->orderBy('total','desc')->take(5)->get();
	// 	if($total_comments){
	// 		foreach ($total_comments as $value) {
	// 			if(isset($teams[$value->id])) $teams[$value->id] = $teams[$value->id] + $value->total;
	// 			else $teams[$value->id] = $value->total;
	// 		}
	// 	}
	// 	// get total post
	// 	$total_posts = Post::select(DB::raw('count(posts.id) as total'),'teams.name','teams.id')->join('users','posts.user_id','=','users.id')->join('teams','users.team_id','=','teams.id')
	// 						->groupBy('teams.id')->orderBy('total','desc')->take(5)->get();
	// 	if($total_posts){
	// 		foreach ($total_posts as $value) {
	// 			if(isset($teams[$value->id])) $teams[$value->id] = $teams[$value->id] + $value->total;
	// 			else $teams[$value->id] = $value->total;
	// 		}
	// 	}
	// 	if(count($teams) > 0){	
	// 		$winningteam = array_search(max($teams), $teams); 
	// 		$data['clubwinner'] = Team::find($winningteam);
	// 	}else{
	// 		$data['clubwinner'] = null;
	// 	}

	// 	$startingeleven = array();
	// 	$data['defenders'] = array();
	// 	$data['assisters'] = array();
	// 	$data['attackers'] = array();
	// 	// player
	// 	$defenders = User::select(array('users.id','users.username','jersey_image','jersey_no','profile_pic',DB::raw('count(comments.id) as total')))->join('comments','users.id','=','comments.user_id')->join('teams','teams.id','=','users.team_id')->orderBy('total','desc')->groupBy('users.id')->where('comments.type','defense')->get();
	// 	$assisters = User::select(array('users.id','users.username','jersey_image','jersey_no','profile_pic',DB::raw('count(comments.id) as total')))->join('comments','users.id','=','comments.user_id')->join('teams','teams.id','=','users.team_id')->orderBy('total','desc')->groupBy('users.id')->where('comments.type','assist')->get();
	// 	$attackers = User::select(array('users.id','users.username','jersey_image','jersey_no','profile_pic',DB::raw('count(comments.id) as total')))->join('comments','users.id','=','comments.user_id')->join('teams','teams.id','=','users.team_id')->orderBy('total','desc')->groupBy('users.id')->where('comments.type','attack')->get();		
		
	// 	if($defenders){
	// 		foreach ($defenders as $value) {
	// 			$startingeleven[$value->id] = array('name'=>$value->username,  'no'=>$value->jersey_no, 'pic'=>$value->profile_pic, 'jersey_image'=>$value->jersey_image, 'total'=>$value->total, 'position'=>'D');	
	// 		}
	// 	}

	// 	if($assisters){
	// 		foreach ($assisters as $value) {
	// 			if(isset($startingeleven[$value->id]) && ($startingeleven[$value->id]['total'] > $value->total)) $startingeleven[$value->id] = array('name'=>$value->username, 'no'=>$value->jersey_no, 'pic'=>$value->profile_pic, 'jersey_image'=>$value->jersey_image, 'total'=>$value->total, 'position'=>'M');	
	// 			else $startingeleven[$value->id] = array('name'=>$value->username, 'no'=>$value->jersey_no, 'pic'=>$value->profile_pic, 'jersey_image'=>$value->jersey_image, 'total'=>$value->total, 'position'=>'M');	
	// 		}	
	// 	}

	// 	if($attackers){
	// 		foreach ($attackers as $value) {
	// 			if(isset($startingeleven[$value->id]) && ($startingeleven[$value->id]['total'] > $value->total)) $startingeleven[$value->id] = array('name'=>$value->username, 'no'=>$value->jersey_no, 'pic'=>$value->profile_pic, 'jersey_image'=>$value->jersey_image, 'total'=>$value->total, 'position'=>'F');	
	// 			else $startingeleven[$value->id] = array('name'=>$value->username, 'no'=>$value->jersey_no, 'pic'=>$value->profile_pic, 'jersey_image'=>$value->jersey_image, 'total'=>$value->total, 'position'=>'F');	
	// 		}
	// 	}
		
	// 	$noplayer = array('name'=>'No player', 'no'=>'0', 'pic'=>'', 'jersey_image'=>'noplayer.png', 'total'=>0);
	// 	if(count($startingeleven) > 0){
	// 		foreach($startingeleven as $se){
	// 			if($se['position'] == 'F') array_push($data['attackers'], $se);
	// 			if($se['position'] == 'M') array_push($data['assisters'], $se);
	// 			if($se['position'] == 'D') array_push($data['defenders'], $se);
	// 		}
			
	// 		if(count($data['defenders']) < 4){
	// 			$selisih = 4 - count($data['defenders']);
	// 			for($i=0; $i<$selisih; $i++){
	// 				array_push($data['defenders'], $noplayer);
	// 			}
	// 		}
	// 		if(count($data['assisters']) < 3){
	// 			$selisih = 3 - count($data['assisters']);
	// 			for($i=0; $i<$selisih; $i++){
	// 				array_push($data['assisters'], $noplayer);
	// 			}
	// 		}
	// 		if(count($data['attackers']) < 3){
	// 			$selisih = 3 - count($data['attackers']);
	// 			for($i=0; $i<$selisih; $i++){
	// 				array_push($data['attackers'], $noplayer);
	// 			}
	// 		}
	// 	}else{
	// 		for($i=0; $i<4; $i++){
	// 			array_push($data['defenders'], $noplayer);
	// 		}
	// 		for($i=0; $i<3; $i++){
	// 			array_push($data['attackers'], $noplayer);
	// 			array_push($data['assisters'], $noplayer);
	// 		}
	// 	}
	// 	return View::make('mobile.hof')->with($data);
	// }

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
		if(count($teams) > 0){	
			$winningteam = array_search(max($teams), $teams); 
			$data['clubwinner'] = Team::find($winningteam);
		}else{
			$data['clubwinner'] = null;
		}

		$startingeleven = array();
		$data['defenders'] = array();
		$data['assisters'] = array();
		$data['attackers'] = array();
		// player
		$defenders = User::select(array('users.id','users.username','jersey_image','jersey_no','profile_pic',DB::raw('count(comments.id) as total')))->join('comments','users.id','=','comments.user_id')->join('teams','teams.id','=','users.team_id')->orderBy('total','desc')->groupBy('users.id')->where('comments.type','defense')->take(5)->get();
		$assisters = User::select(array('users.id','users.username','jersey_image','jersey_no','profile_pic',DB::raw('count(comments.id) as total')))->join('comments','users.id','=','comments.user_id')->join('teams','teams.id','=','users.team_id')->orderBy('total','desc')->groupBy('users.id')->where('comments.type','assist')->take(3)->get();
		$attackers = User::select(array('users.id','users.username','jersey_image','jersey_no','profile_pic',DB::raw('count(comments.id) as total')))->join('comments','users.id','=','comments.user_id')->join('teams','teams.id','=','users.team_id')->orderBy('total','desc')->groupBy('users.id')->where('comments.type','attack')->take(3)->get();		
		
		if($defenders){
			foreach ($defenders as $value) {
				$startingeleven[$value->id] = array('name'=>$value->username,  'no'=>$value->jersey_no, 'pic'=>$value->profile_pic, 'jersey_image'=>$value->jersey_image, 'total'=>$value->total, 'position'=>'D');	
			}
		}

		if($assisters){
			foreach ($assisters as $value) {
				if(isset($startingeleven[$value->id]) && ($startingeleven[$value->id]['total'] > $value->total)) $startingeleven[$value->id] = array('name'=>$value->username, 'no'=>$value->jersey_no, 'pic'=>$value->profile_pic, 'jersey_image'=>$value->jersey_image, 'total'=>$value->total, 'position'=>'M');	
				else $startingeleven[$value->id] = array('name'=>$value->username, 'no'=>$value->jersey_no, 'pic'=>$value->profile_pic, 'jersey_image'=>$value->jersey_image, 'total'=>$value->total, 'position'=>'M');	
			}	
		}

		if($attackers){
			foreach ($attackers as $value) {
				if(isset($startingeleven[$value->id]) && ($startingeleven[$value->id]['total'] > $value->total)) $startingeleven[$value->id] = array('name'=>$value->username, 'no'=>$value->jersey_no, 'pic'=>$value->profile_pic, 'jersey_image'=>$value->jersey_image, 'total'=>$value->total, 'position'=>'F');	
				else $startingeleven[$value->id] = array('name'=>$value->username, 'no'=>$value->jersey_no, 'pic'=>$value->profile_pic, 'jersey_image'=>$value->jersey_image, 'total'=>$value->total, 'position'=>'F');	
			}
		}
		
		$noplayer = array('name'=>'No player', 'no'=>'0', 'pic'=>'', 'jersey_image'=>'player_dummy.png', 'total'=>0);
		if(count($startingeleven) > 0){
			foreach($startingeleven as $se){
				if($se['position'] == 'F') array_push($data['attackers'], $se);
				if($se['position'] == 'M') array_push($data['assisters'], $se);
				if($se['position'] == 'D') array_push($data['defenders'], $se);
			}
			
			if(count($data['defenders']) < 5){
				$selisih = 5 - count($data['defenders']);
				for($i=0; $i<$selisih; $i++){
					array_push($data['defenders'], $noplayer);
				}
			}
			if(count($data['assisters']) < 3){
				$selisih = 3 - count($data['assisters']);
				for($i=0; $i<$selisih; $i++){
					array_push($data['assisters'], $noplayer);
				}
			}
			if(count($data['attackers']) < 3){
				$selisih = 3 - count($data['attackers']);
				for($i=0; $i<$selisih; $i++){
					array_push($data['attackers'], $noplayer);
				}
			}
		}else{
			for($i=0; $i<5; $i++){
				array_push($data['defenders'], $noplayer);
			}
			for($i=0; $i<3; $i++){
				array_push($data['attackers'], $noplayer);
				array_push($data['assisters'], $noplayer);
			}
		}
		return View::make('mobile.halloffame2')->with($data);
	}

	public function htm(){
		// how to meme
		return View::make('mobile.howtomeme');	
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
		return View::make('mobile.admin.featuredvideo')->with($data);
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

	public function howtomeme(){
        return View::make('landingPage.howtomeme');
    }

    public function promotion(){
        return View::make('landingPage.promotion');
    }

    public function tebakskor2(){
        return View::make('landingPage.tebakskor2');
    }

}
