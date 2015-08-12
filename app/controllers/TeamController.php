<?php

class TeamController extends BaseController {

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
		return View::make('admin.teams')->with($data);
	}

	public function adminAddTeam(){
		$data['page'] = 'me';
		$data['mode'] = 'add';
		return View::make('admin.formteam')->with($data);
	}
}