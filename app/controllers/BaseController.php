<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function changeLanguage()
	{
		$lang = Session::get('language');
		if($lang == 'id'){ 
			Session::set('language','en');
			return 'en';
		}else{ 
			Session::set('language','id');
			return 'id';
		}
	}

}
