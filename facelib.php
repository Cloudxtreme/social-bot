<?php
use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;

function upload_image($src, $session) {
	if($session) {

		try {

			// Upload to a user's profile. The photo will be in the
			// first album in the profile. You can also upload to
			// a specific album by using /ALBUM_ID as the path		 
			$response = (new FacebookRequest(
				$session, 'POST', '/me/photos', array(
					'source' => new CURLFile($src, 'image/png'),
					'message' => 'User provided message'
				)
			))->execute()->getGraphObject();

			// If you're not using PHP 5.5 or later, change the file reference to:
			// 'source' => '@/path/to/file.name'

			echo "Posted with id: " . $response->getProperty('id');

		} catch(FacebookRequestException $e) {
			echo "Exception occured, code: " . $e->getCode();
			echo " with message: " . $e->getMessage();
		}
	}
}

function facebook_login($token) {
	$session = new FacebookSession($token);

	// $helper = new FacebookRedirectLoginHelper();
	// try {
	// 	$session = $helper->getSessionFromRedirect();
	// } catch(FacebookRequestException $ex) {
	// 	echo "When Facebook returns an error\n";
	// } catch(\Exception $ex) {
	// 	echo "When validation fails or other local issues\n";
	// 	echo "Exception occured, code: " . $ex->getCode();
	// 	echo " with message: " . $ex->getMessage() . "\n";
	// }

	if ($session) {
		echo "Facebook session started!\n";
		print_r($session);
	}
	return $session;
}