<?php
// Trip journal

// configure cron tu run every 10 minutes
require "init.php";

// actualizar base de datos con listado de frases
update_quotes_into_database('C:\Users\bu\Dropbox');

// cargar actions 
$actions = $db->from('actions')
	->where('execute_on=NOW()')
	->orderBy('person_id, social_network');

// load actions to run in this time
// do the action

$person = '';
$social_network = '';

foreach ($actions as $i => $action) {

	/* 
	 *	Update social network login, in the case person changes or social network changes
	 *	update $person if ActionPerson changed or is not already set
	 */

	if ($person == '' || $person != $action->person_id || $action->social_network != $social_network) {
		$person = $action->person_id;
		login($person, $action->social_network);
	}

	/*
	 *	Execute action
	 */

	switch ($action->type) {
		case 'post_quote':
			// upload_random_quote($user);

			$actions = $db->from('person_images')
				->where("id NOT IN (SELECT image_id FROM person_images) WHERE person_id=".$person->id)
				->orderBy('RAND()')
				->limit(1);
			break;
		case 'post_photo':
			upload_photo($action->link);
			break;
		case 'post_link':
			upload_image($action->link);
			break;
		default:
			break;
	}
}

// functions
function post_image($source) {
	$files = get_file_from_dir($source);
	post_image();
	persist();
	move_to_old_dir($source.'/uploaded');
}

function post_quote() {
	$file = get_random_file();
	if (!array_contains($file)) {
		post_image();
		persist();	 // as uploaded
	}
}

function login($person_id) {
	$person = search('WHERE personid=$person_id');
	auth($person->facebook_token);

	$helper = new FacebookRedirectLoginHelper();
	try {
	  $session = $helper->getSessionFromRedirect();
	} catch(FacebookRequestException $ex) {
	  // When Facebook returns an error
	} catch(\Exception $ex) {
	  // When validation fails or other local issues
	}
	if ($session) {
	  // Logged in
	}
}


// Marketing: 
//	- social networks: twitter, facebook, pinterest, google+
//  - blog

/*
fuentes de visitas:
	social networks: twitter, facebook, pinterest, google+
	sitios con alto page rank: buscar sitios con PR que acepten comentarios
		diarios: elcomercio.pe, 
*/