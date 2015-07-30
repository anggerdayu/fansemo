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

	    	
	    }
	}
}