<?php
	$row = 1;
		$arrResult  = array();
		if (($handle = fopen("users.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				DB::table('users')->insert(
					array('name' => $data[1], 'surname' => $data[2], 'email' => $data[3])
				);
			}
			fclose($handle);
		}

?>