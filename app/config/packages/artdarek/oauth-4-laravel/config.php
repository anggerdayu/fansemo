<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '1662953520592686',
            'client_secret' => 'cd3ea8b661b99d0aaa3662165a4fe837',
            'scope'         => array('email','user_birthday','user_location','user_about_me','user_likes'),
        ),		

	)

);