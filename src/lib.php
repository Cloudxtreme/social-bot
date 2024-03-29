<?php

function update_quotes_into_database($path) {

	global $db;
	global $logger;

	$files = scandir($path);
	
	/*
	 * insert all filenames into 'images' table
	 */
	foreach ($files as $i => $file) {

		if (!startsWith($file, '.')) {

			$images = $db->from('images')->where("filename='$file'");

			if (sizeof($images) == 0) {
				$image = array(
					'filename' => $file,
				);
				
				$query = $db->insertInto('images')->values($image);
				$insert = $query->execute(); 

				// echo $query->getQuery() . "\n"; 
			}
		}
	}
}
