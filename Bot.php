<?php

class Bot {
	
	private $logger;
	private $actions;
	private $facebook_session;


	protected $tor = FALSE;
	
	function __construct() {
		global $logger, $db;
        $this->logger = $logger;
        $this->db = $db;
	}

	function run() {
		$this->load_actions();
		$this->execute_actions();
	}

	function load_actions() {
		$this->actions = $this->db->from('actions')
			->where('execute_on BETWEEN DATE_SUB(NOW(), INTERVAL 1 HOUR) AND NOW()')
			->orderBy('person_id, social_network');

		$this->logger->info("Total actions: ".sizeof($this->actions));
	}

	function execute_actions() {
		$person_id = '';
		$social_network = '';

		foreach ($this->actions as $i => $action) {

			/* 
			 *	Authenticate again if person or social network changes
			 *	update $person if ActionPerson changed or is not already set
			 */

			if ($person_id == '' || $person_id != $action->person_id || $action->social_network != $social_network) {
				$person_id = $action['person_id'];

				$this->login($action);
			}

			$this->execute_action($action);
		}
	}

	function execute_action($action) {

		switch ($action['type']) {
			case 'post_quote':
				// upload_random_quote($user);

				// choose a image that wasn't already posted for user
				$image = $this->db->from('images')
					->where("id NOT IN (SELECT image_id FROM person_images WHERE person_id= ?)", $action['person_id'])
					->orderBy('RAND()')
					->limit(1)
					->fetch(); // 'fetch' is to get only one, not array

				$this->post_image(QUOTES_PATH.$image['filename'], $action['social_network']);
				break;
			case 'post_photo':
				// read one file order by name

				// post file to social netowork
				upload_photo($action['link']);
				// move file to uploaded folder
				
				break;
			case 'post_link':
				upload_image($action['link']);
				break;
			default:
				break;
		}
	}

	function login($action) {
		$person = $this->db->from('persons')
					->where("id = ?", $action['person_id'])
					->fetch(); // 'fetch' is to get only one, not array

		print_r($person);
		switch ($action['social_network']) {
			case 'facebook':
				$this->facebook_session = facebook_login($person['facebook_token']);
				break;

			case 'twitter':
				break;

			case 'google+':
				upload_image($action->link);
				break;

			default:
				break;
		}

	}

	function post_image($source, $social_network) {
		switch ($social_network) {
			case 'facebook':
				upload_image($source, $this->facebook_session);
				break;

			case 'twitter':
				break;

			case 'google+':
				upload_image($action->link);
				break;

			default:
				break;
		}
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
}