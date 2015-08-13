<?php

class BadgeController extends BaseController {

	public function index(){
		$data['page'] = 'me';
		$data['badges'] = Badge::orderBy('name')->paginate(10);
		return View::make('admin.badges')->with($data);
	}

}