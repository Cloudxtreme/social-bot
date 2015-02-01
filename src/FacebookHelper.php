<?php
use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;

class FacebookHelper {
	
	private $session;
	
	function __construct() {
		global $logger, $db;
        $this->logger = $logger;
        $this->db = $db;
	}

	function upload_image($src) {
		if($this->session) {

			try {

				// Upload to a user's profile. The photo will be in the
				// first album in the profile. You can also upload to
				// a specific album by using /ALBUM_ID as the path		 
				$response = (new FacebookRequest(
					$this->session, 'POST', '/me/photos', array(
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

	function login($person) {
		if (isset($person['facebook_token'])) {
			$this->session = new FacebookSession($person['facebook_token']);
		} else {
			if (isset($person['facebook_token_tmp'])) {
				$this->session = new FacebookSession($person['facebook_token_tmp']);
				$this->session = $this->session->getLongLivedSession(FACEBOOK_APP_ID, FACEBOOK_APP_SECRET);

				$set = array('facebook_token' => $this->session->getToken());
				$query = $this->db->update('persons', $set, $person['id'])->execute();
			} else {
				echo "ERROR: no facebook token for ".$person['person_id'];
			}
		}

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

		if ($this->session) {
			echo "Facebook session started!\n";
			print_r($this->session);
		}

		return $this->session;
	}

}