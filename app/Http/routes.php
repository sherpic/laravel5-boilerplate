<?php
$api = app('Dingo\Api\Routing\Router');

// Version 1 of our API
$api->version('v1', function ($api) {

	// Set our namespace for the underlying routes
	$api->group(['namespace' => 'Api\Controllers', 'middleware' => '\Barryvdh\Cors\HandleCors::class'], function ($api) {

		// Login route - use Basic Auth
		$api->group( [ 'middleware' => 'auth.basic.once' ], function($api) {
			$api->get('auth/jwt/login', 'AuthController@authenticate');
		});

		$api->get('auth/jwt/third', 'AuthController@thirdPartyToken');
		$api->get('auth/jwt/token', 'AuthController@getAnonymousToken');

		// All routes in here are protected and thus need a valid token
		//$api->group( [ 'protected' => true, 'middleware' => 'jwt.refresh' ], function ($api) {
		$api->group( [ 'middleware' => 'jwt.auth' ], function ($api) {

			$api->get('auth/jwt/refresh', 'AuthController@refreshToken');


		});

	});

});
