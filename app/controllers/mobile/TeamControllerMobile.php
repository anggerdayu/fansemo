<?php

class TeamControllerMobile extends BaseController {

	public function getteams(){
		$keyword = Input::get('q');
		$teams = Team::where('name','like','%'.$keyword.'%')->get();
		$results = array();
		if($teams->count() > 0){
			foreach($teams as $team){
				array_push($results, array('id'=>$team->id, 'text'=>$team->name));
			}
		}
		$results = array('results'=>$results);
		return Response::json($results);
	}

	public function chteam(){
		$rules = array(
    			'team' => 'required',
		    	'jersey' => 'required|numeric|max:99'
    		);
    	$validator = Validator::make(Input::all(),$rules);
    	if ($validator->fails()){
	    	return Redirect::to('me')->withErrors($validator)->withInput();
	    }else{
	    	$inputteam = Input::get('team');
	    	$inputjersey = Input::get('jersey');

	    	$user = User::find(Auth::id());
	    	$user->team_id = $inputteam;
	    	$user->jersey_no = $inputjersey;
	    	$user->save();
	    	Session::flash('success2', true);
	    	return Redirect::to('me');	
	    }
	}

	public function adminTeamPage(){
		$data['page'] = 'me';
		$data['teams'] = Team::orderBy('name')->paginate(10);
		return View::make('mobile.admin.teams')->with($data);
	}

	public function adminAddTeam(){
		$data['page'] = 'me';
		$data['mode'] = 'add';
		return View::make('mobile.admin.formteam')->with($data);
	}

	public function adminEditTeam($id){
		$data['page'] = 'me';
		$data['mode'] = 'edit';
		$data['detail'] = Team::find($id);
		if(!$data['detail']) return Redirect::to('admin/teams');
		return View::make('mobile.admin.formteam')->with($data);
	}

	public function insertTeam(){
		$rules = array(
    			'name' => 'required', 
    			'imglogo' => 'required',
		    	'imgjersey' => 'required' 
    		);
		$validator = Validator::make(Input::all(),$rules);
		if ($validator->fails()){
	    	return Redirect::to('admin/addteam')->withErrors($validator)->withInput();
	    }else{
	    	$name = Input::get('name');

	    	$imagelogo = explode('/',Input::get('imglogo'));
			$imagelogo = urldecode(end($imagelogo));
			$extensionlogo = explode(".", $imagelogo);
			$extensionlogo = end($extensionlogo);

			$imagejersey = explode('/',Input::get('imgjersey'));
			$imagejersey = urldecode(end($imagejersey));
			$extensionjersey = explode(".", $imagejersey);
			$extensionjersey = end($extensionjersey);

			$imglogo = Image::make('files/'.$imagelogo);
	    	$imglogo->resize(160, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			})->save('files/'.$imagelogo);
			$newnamelogo = date('YmdHis').'_'.Str::slug($name, '_').'.'.$extensionlogo;
			File::move('files/'.$imagelogo, 'teams/'.$newnamelogo);

			$imgjersey = Image::make('files/'.$imagejersey);
	    	$imgjersey->resize(160, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			})->save('files/'.$imagejersey);
			$newnamejersey = date('YmdHis').'_'.Str::slug($name, '_').'.'.$extensionjersey;
			File::move('files/'.$imagejersey, 'jerseys/'.$newnamejersey);

	    	$team = new Team;
	    	$team->name = Input::get('name');
	    	$team->type = Input::get('type');
	    	$team->logo_image = $newnamelogo;
	    	$team->jersey_image = $newnamejersey;
	    	$team->save();
	    	Session::flash('success', 'New team added');
	    	return Redirect::to('admin/teams');
	    }
	}

	public function updateTeam(){
		$rules = array(
    			'name' => 'required'
    		);
		$validator = Validator::make(Input::all(),$rules);
		$teamid = Input::get('id');
		if ($validator->fails()){
	    	return Redirect::to('admin/editteam/'.$teamid)->withErrors($validator)->withInput();
	    }else{
	    	$name = Input::get('name');
	    	if(Input::get('imglogo')){
		    	$imagelogo = explode('/',Input::get('imglogo'));
				$imagelogo = urldecode(end($imagelogo));
				$extensionlogo = explode(".", $imagelogo);
				$extensionlogo = end($extensionlogo);

				$imglogo = Image::make('files/'.$imagelogo);
		    	$imglogo->resize(160, null, function ($constraint) {
					$constraint->aspectRatio();
					$constraint->upsize();
				})->save('files/'.$imagelogo);
				$newnamelogo = date('YmdHis').'_'.Str::slug($name, '_').'.'.$extensionlogo;
				File::move('files/'.$imagelogo, 'teams/'.$newnamelogo);
			}
			if(Input::get('imgjersey')){
				$imagejersey = explode('/',Input::get('imgjersey'));
				$imagejersey = urldecode(end($imagejersey));
				$extensionjersey = explode(".", $imagejersey);
				$extensionjersey = end($extensionjersey);

				$imgjersey = Image::make('files/'.$imagejersey);
		    	$imgjersey->resize(160, null, function ($constraint) {
					$constraint->aspectRatio();
					$constraint->upsize();
				})->save('files/'.$imagejersey);
				$newnamejersey = date('YmdHis').'_'.Str::slug($name, '_').'.'.$extensionjersey;
				File::move('files/'.$imagejersey, 'jerseys/'.$newnamejersey);
			}

	    	$team = Team::find($teamid);
	    	$team->name = Input::get('name');
	    	$team->type = Input::get('type');
	    	
	    	if(Input::get('imglogo')) $team->logo_image = $newnamelogo;
	    	if(Input::get('imgjersey')) $team->jersey_image = $newnamejersey;
	    	
	    	$team->save();
	    	Session::flash('success', 'Team updated');
	    	return Redirect::to('admin/teams');
	    }
	}

	public function deleteTeam($id){
		$team = Team::find($id);
		$team->delete();
		Session::flash('success', 'Team deleted');
	    return Redirect::to('admin/teams');
	}
}