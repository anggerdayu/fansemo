<?php

class BadgeController extends BaseController {

	public function index(){
		$data['page'] = 'me';
		$data['badges'] = Badge::orderBy('name')->paginate(10);
		return View::make('admin.badges')->with($data);
	}

	public function add(){
		$data['page'] = 'me';
		$data['mode'] = 'add';
		return View::make('admin.formbadge')->with($data);
	}

	public function edit($id){
		$data['page'] = 'me';
		$data['mode'] = 'edit';
		$data['detail'] = Badge::find($id);
		if(!$data['detail']) return Redirect::to('admin/badges');
		return View::make('admin.formbadge')->with($data);
	}

	public function insert(){
		$rules = array(
    			'name' => 'required', 
    			'desc' => 'required',
		    	'badge' => 'required' 
    		);
		$validator = Validator::make(Input::all(),$rules);
		if ($validator->fails()){
	    	return Redirect::to('admin/addbadge')->withErrors($validator)->withInput();
	    }else{
	    	$name = Input::get('name');

	    	$image = explode('/',Input::get('badge'));
			$image = urldecode(end($image));
			$extension = explode(".", $image);
			$extension = end($extension);

			$img = Image::make('files/'.$image);
	    	$img->resize(160, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			})->save('files/'.$image);
			$newname = date('YmdHis').'_'.Str::slug($name, '_').'.'.$extension;
			File::move('files/'.$image, 'badges/'.$newname);

			$badge = new Badge;
			$badge->name = Input::get('name');
			$badge->description = Input::get('desc');
			$badge->image = $newname;
			$badge->save();

			Session::flash('success', 'New badge added');
	    	return Redirect::to('admin/badges');
	    }
	}

	public function update(){
		$rules = array(
    			'name' => 'required', 
    			'desc' => 'required'
    		);
		$validator = Validator::make(Input::all(),$rules);
		$badgeid = Input::get('id');
		if ($validator->fails()){
	    	return Redirect::to('admin/addbadge')->withErrors($validator)->withInput();
	    }else{
	    	$name = Input::get('name');
	    	if(Input::get('badge')){
	    		$image = explode('/',Input::get('badge'));
				$image = urldecode(end($image));
				$extension = explode(".", $image);
				$extension = end($extension);

				$img = Image::make('files/'.$image);
		    	$img->resize(160, null, function ($constraint) {
					$constraint->aspectRatio();
					$constraint->upsize();
				})->save('files/'.$image);
				$newname = date('YmdHis').'_'.Str::slug($name, '_').'.'.$extension;
				File::move('files/'.$image, 'badges/'.$newname);
	    	}

	    	$badge = Badge::find($badgeid);
			$badge->name = Input::get('name');
			$badge->description = Input::get('desc');
			if(Input::get('badge')) $badge->image = $newname;
			$badge->save();

			Session::flash('success', 'Badge updated');
	    	return Redirect::to('admin/badges');
	    }
	}

	public function delete($id){
		$badge = Badge::find($id);
		$badge->delete();
		Session::flash('success', 'Badge deleted');
	    return Redirect::to('admin/badges');
	}

}