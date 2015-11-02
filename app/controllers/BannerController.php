<?php

class BannerController extends BaseController {

	public function index(){
		$data['page'] = 'me';
		$data['banners'] = Banner::orderBy('id')->get();
		return View::make('admin.banners')->with($data);
	}

	public function add(){
		$data['page'] = 'me';
		$data['mode'] = 'add';
		return View::make('admin.formbanner')->with($data);
	}

	public function edit($id){
		$data['page'] = 'me';
		$data['mode'] = 'edit';
		$data['detail'] = Banner::find($id);
		if(!$data['detail']) return Redirect::to('admin/banners');
		return View::make('admin.formbanner')->with($data);
	}

	public function insert()
	{
		$rules = array( 
    			'image_banner' => 'required'
    		);
		$validator = Validator::make(Input::all(),$rules);
		if ($validator->fails()){
	    	return Redirect::to('admin/addbanner')->withErrors($validator)->withInput();
	    }else{
	    	$image = explode(url().'/', Input::get('image_banner'));
	    	$realpath = public_path($image[1]);
	    	$newname = date('YmdHis').'.jpg';
	    	File::move($realpath, 'images/slider/'.$newname);

	    	// insert to db
	    	$banner = new Banner;
	    	$banner->image = 'images/slider/'.$newname;
	    	if(Input::has('url')) $banner->link = Input::get('url');
	    	$banner->save();
	    	Session::flash('success','New banner created');
	    	return Redirect::to('admin/banners'); 
	    }
	}

	public function update(){
		$id = Input::get('id');
		if(Input::has('url')) $rules = array();
		else $rules = array( 
    			'image_banner' => 'required'
    		);
		$validator = Validator::make(Input::all(),$rules);
		if ($validator->fails()){
	    	return Redirect::to('admin/editbanner/'.$id)->withErrors($validator)->withInput();
	    }else{
	    	if(Input::has('image_banner')){
		    	$image = explode(url().'/', Input::get('image_banner'));
		    	$realpath = public_path($image[1]);
		    	$newname = date('YmdHis').'.jpg';
		    	File::move($realpath, 'images/slider/'.$newname);
			}
	    	// update db
	    	$banner = Banner::find($id);
	    	if(Input::has('image_banner')) $banner->image = 'images/slider/'.$newname;
	    	if(Input::has('url')) $banner->link = Input::get('url');
	    	$banner->save();
	    	Session::flash('success','Banner updated');
	    	return Redirect::to('admin/banners');
	    }
	}

	public function delete($id){
		$banner = Banner::find($id);
		$banner->delete();
		Session::flash('success', 'Banner deleted');
	    return Redirect::to('admin/banners');
	}

}