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
            'client_id'     => '1673965186225544',
            'client_secret' => 'e4a7554e1366bce6884c97da875c56d3',
            'scope'         => array('email','user_birthday','user_location','user_about_me','user_likes'),
        ),

        'Google' => array(
		    'client_id'     => '854173205194-f20o7afhu3mnpoansmpru0kb2tceljml.apps.googleusercontent.com',
		    'client_secret' => '-e6zGXTSnCz_EFWNjFDSzo_t',
		    'scope'         => array('userinfo_email', 'userinfo_profile'),
		),		

	)

);